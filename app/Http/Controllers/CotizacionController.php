<?php

namespace App\Http\Controllers;
use App\Almacen;
use App\Banco;
use App\Boleta;
use App\Boleta_registro;
use App\Cliente;
use App\Codigo_guia_almacen;
use App\ConfiguracionGuiaIngresos;
use App\Cotizacion;
use App\Cotizacion_Servicios;
use App\Cotizacion_boleta_registro;
use App\Cotizacion_factura_registro;
use App\Cuotas_credito;
use App\EmailBandejaEnvios;
use App\EmailBandejaEnviosArchivos;
use App\EmailConfiguraciones;
use App\Empresa;
use App\Facturacion;
use App\Facturacion_registro;
use App\Forma_pago;
use App\Garantia;
use App\Igv;
use App\Kardex_entrada;
use App\Marcas;
use App\Moneda;
use App\Personal;
use App\Personal_venta;
use App\Producto;
use App\Servicios;
use App\Stock_almacen;
use App\Stock_producto;
use App\TipoCambio;
use App\Tipo_operacion_f;
use App\Unidad_medida;
use App\User;
use App\Validez;
use App\Ventas_registro;
use App\kardex_entrada_registro;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Luecano\NumeroALetras\NumeroALetras;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;


class CotizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Configuracion
        $array=array('comisionista_create','forma_pago_create','tipo_operacion_create','moneda_create','validez_create','garantia_create');
        foreach ($array as $key ) {
            $buscador=ConfiguracionGuiaIngresos::where('nombre',$key)->where('tipo_guia','cotizacion')->first();
            $configuracion_nuevo=new ConfiguracionGuiaIngresos;
            $configuracion_nuevo->nombre=$key;
            $configuracion_nuevo->tipo_guia='cotizacion';
            $configuracion_nuevo->estado='0';
            if (empty($buscador)){$configuracion_nuevo->save();}
        }
        //Configuracion

        // Migracion nuevav
        $garantia=Garantia::all()->count();
        $validez=Validez::all()->count();
        if ($garantia==0) {
         $garantia=new Garantia;
         $garantia->descripcion='Sin Garantia';
         $garantia->estado='0';
         $garantia->save();
     }
     if ($validez==0) {
         $validez=new Validez;
         $validez->descripcion='1 dia';
         $validez->estado='0';
         $validez->save();
     }
        // Migracion nueva

        // REDIRECCION PARA MOSTRAR EL inventario_inicial
     $existe_id=Kardex_entrada::where('estado',2)->first();
     if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

     $cotizacion=Cotizacion::all();
     $user_login =auth()->user();
     $conteo_almacen=Almacen::where('estado',0)->count();
     $almacen=Almacen::where('estado',0)->get();
     $almacen_primero=Almacen::where('estado',0)->first();
     return view('transaccion.venta.cotizacion.index2',compact('cotizacion','conteo_almacen','user_login','almacen','almacen_primero'));
 }
    /**
       
     * 
     * @return \Illuminate\Http\Response
     */
    public function parameter_call(Request $request)
    {
        //Obtención del articulo
        $articulo=$request->get('articulo');
        $id=explode(" ",$articulo); //separador del articulo por espacio

        //Obtención de los datos del articulo (producto-servicio)
        $producto=Producto::where('id',$id[0])->where('codigo_producto',$id[2])->where('codigo_original',$id[4])->first();
        $servicio=Servicios::where('id',$id[0])->where('codigo_servicio',$id[2])->where('codigo_original',$id[4])->first();

        //Diferenciador de producto y servicio
        if(isset($producto)){
            $descripcion= $producto->descripcion;
        }else{
            $descripcion= $servicio->descripcion;
        }
        return $descripcion;
    }

    public function create_factura(Request $request)
    {
        $config_create = array(
            array('nombre' => 'comisionista_create', 'id_input' => 'comisionista', 'input_value' => 'Comisionista'),
            array('nombre' => 'forma_pago_create', 'id_input' => 'comisionista', 'input_value' => 'Comisionista'),
            array('nombre' => 'tipo_operacion_create', 'id_input' => 'comisionista', 'input_value' => 'Comisionista'),
            array('nombre' => 'moneda_create', 'id_input' => 'comisionista', 'input_value' => 'Comisionista'),
            array('nombre' => 'validez_create', 'id_input' => 'comisionista', 'input_value' => 'Comisionista'),
            array('nombre' => 'garantia_create', 'id_input' => 'comisionista', 'input_value' => 'Comisionista'),
            );
        // return $config_create;
        $garantia=Garantia::where('estado',0)->get();
        $validez=Validez::where('estado',0)->get();

        $inventario_inicial=Kardex_entrada::first();
        if (isset($inventario_inicial)) {
            if ( $inventario_inicial->estado==1) {
                return redirect()->route('kardex-entrada.show',$inventario_inicial->id);
            }
        }

        //CODIGO N° DE  COTIZACION
        $almacen=$request->get('almacen');
        $sucursal=Almacen::where('id',$almacen)->first();
        /*Codigo Cotizacion Factura*/
        $cotizacion=Cotizacion::where('almacen_id',$almacen)->where('tipo','factura')->latest()->first();
        if (empty($cotizacion)) {
            $numero_serie=$sucursal->id;
            $correlativo=1;
        } else{
            $numero_serie_busqueda=strstr($cotizacion->cod_cotizacion,' ');

            $numero_serie=strstr($numero_serie_busqueda,'-',true);
            $correlativo_ultimo=substr(strrchr($numero_serie_busqueda, "-"),1);
            $correlativo = $correlativo_ultimo+1;

            if($correlativo_ultimo == 99999999){
                $correlativo = 1;
                $numero_serie = $numero_serie+1;
            }
        }


        $sucursal_nr = str_pad($numero_serie, 3, "0", STR_PAD_LEFT);
        $correlativo=str_pad($correlativo, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero="COTF ".$sucursal_nr."-".$correlativo;
        //FIN CODIGO N° DE  COTIZACION

        /*Codigo Cotizacion BOLETA*/
        $cotizacion_boleta=Cotizacion::where('almacen_id',$almacen)->where('tipo','boleta')->latest()->first();
        
        if (empty($cotizacion_boleta)) {
            $numero_serie_boleta=$sucursal->id;
            $correlativo_boleta=1;
        } else{
            $numero_serie_busqueda_boleta=strstr($cotizacion_boleta->cod_cotizacion,' ');

            $numero_serie_boleta=strstr($numero_serie_busqueda_boleta,'-',true);
            $correlativo_ultimo_boleta=substr(strrchr($numero_serie_busqueda_boleta, "-"),1);
            $correlativo_boleta = $correlativo_ultimo_boleta+1;

            if($correlativo_ultimo_boleta == 99999999){
                $correlativo_boleta = 1;
                $numero_serie_boleta = $numero_serie_boleta+1;
            }
        }


        $sucursal_nr_boleta = str_pad($numero_serie_boleta, 3, "0", STR_PAD_LEFT);
        $correlativo_boleta=str_pad($correlativo_boleta, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero_boleta="COTB ".$sucursal_nr_boleta."-".$correlativo_boleta;
        //LLAMADO A KARDEX POR ALMACEN
        $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen)->count();
        foreach($kardex_entrada as $kardex_entradas){
            $kadex_entrada_id[]=$kardex_entradas->id;
        }
        for($x=0;$x<$kardex_entrada_count;$x++){
            if(Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado',1)->where('tipo_registro_id','!=',2)->get()){
                $nueva=Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado',1)->where('tipo_registro_id','!=',2)->get();
                foreach( $nueva as $nuevas){
                    $prod[]=$nuevas->producto_id;
                }
            }
        }
        // return $nueva;
        //validacion si hay prductos en el almacen
        if(!isset($prod)){
            return back()->withErrors(['No hay productos en el Almacen con nombre: '.$sucursal->nombre.'']);
        }

        //LLAMAMIENTO DE PRODUCTOS
        $lista=array_values(array_unique($prod));
        $lista_count=count($lista);
        for($x=0;$x<$lista_count;$x++){
            $validacion[$x]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            if(!$validacion[$x]==NULL){
                $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            }
        }

        //CALCULO PARA ARRAY DE PRECIO,STOCK,ETC
        $moneda=Moneda::where('principal','1')->first();
        if ($moneda->tipo == 'nacional') {
            foreach ($productos as $index => $producto) {
                // return $index;
                $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad[$index]),2);
                $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen)->pluck('stock')->first();
                $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional'),2);
                // return $;
            }
            // return $array_promedio;
        }else{
            foreach ($productos as $index => $producto) {
                $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad[$index]),2);
                $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen)->pluck('stock')->first();
                $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero'),2);
            }
        }
        //LLAMADO A TABLAS PARA LA VISTA
        $tipo_operacion = Tipo_operacion_f::all();
        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::where('documento_identificacion','ruc')->get();
        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $igv=Igv::first();
        $empresa=Empresa::first();
        $personal_contador= Facturacion::all()->count();
        $suma=$personal_contador+1;
        $categoria='producto';

        // Servicios

        $servicios=Servicios::where('estado_anular',0)->get();
        $tipo_cambio=TipoCambio::latest('created_at')->first();
        // return $servicios;
        if(count($servicios) == 0){
            return back()->withErrors(['No hay Servicios Agregados: '.$sucursal->nombre.'']);
        }

        if($moneda->tipo =='nacional'){
            foreach ($servicios as $index2 => $servicio) {
                $utilidad_serv[]=$servicio->precio_nacional*($servicio->utilidad)/100;
                $array2[]=round($servicio->precio_nacional+$utilidad_serv[$index2],2);
                $array_promedio_serv[]=($servicio->precio_nacional);
            }
        }else{
            foreach ($servicios as $index2 => $servicio) {
                $utilidad_serv[]=$servicio->precio_extranjero*($servicio->utilidad)/100;
                $array2[]=round($servicio->precio_extranjero+$utilidad_serv[$index2],2);
                $array_promedio_serv[]=($servicio->precio_extranjero);
            }
        }
        // r
        $config=ConfiguracionGuiaIngresos::where('tipo_guia','cotizacion')->get();

        return view('transaccion.venta.cotizacion.factura.create2',compact('config','garantia','validez','productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','suma','categoria','cotizacion_numero','sucursal','tipo_operacion','servicios','array2','array_promedio_serv','cotizacion_numero_boleta','config_create'));
    }

    public function create_factura_ms(Request $request)
    {
        $garantia=Garantia::where('estado',0)->get();
        $validez=Validez::where('estado',0)->get();
        $inventario_inicial=Kardex_entrada::first();
        if (isset($inventario_inicial)) {
            if ( $inventario_inicial->estado==1) {
                return redirect()->route('kardex-entrada.show',$inventario_inicial->id);
            }
        }
        //CODIGO N° DE  COTIZACION
        $sucursal_p=$request->get('almacen');
        $sucursal=Almacen::where('id',$sucursal_p)->first();
        /*Codigo Cotizacion Factura*/
        $cotizacion=Cotizacion::where('almacen_id',$sucursal_p)->where('tipo','factura')->latest()->first();
        if (empty($cotizacion)) {
            $numero_serie=$sucursal->id;
            $correlativo=1;
        } else{
            $numero_serie_busqueda=strstr($cotizacion->cod_cotizacion,' ');

            $numero_serie=strstr($numero_serie_busqueda,'-',true);
            $correlativo_ultimo=substr(strrchr($numero_serie_busqueda, "-"),1);
            $correlativo = $correlativo_ultimo+1;

            if($correlativo_ultimo == 99999999){
                $correlativo = 1;
                $numero_serie = $numero_serie+1;
            }
        }


        $sucursal_nr = str_pad($numero_serie, 3, "0", STR_PAD_LEFT);
        $correlativo=str_pad($correlativo, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero="COTF ".$sucursal_nr."-".$correlativo;
        //FIN CODIGO N° DE  COTIZACION
        /*Codigo Cotizacion BOLETA*/
        $cotizacion_boleta=Cotizacion::where('almacen_id',$sucursal_p)->where('tipo','boleta')->latest()->first();
        
        if (empty($cotizacion_boleta)) {
            $numero_serie_boleta=$sucursal->id;
            $correlativo_boleta=1;
        } else{
            $numero_serie_busqueda_boleta=strstr($cotizacion_boleta->cod_cotizacion,' ');

            $numero_serie_boleta=strstr($numero_serie_busqueda_boleta,'-',true);
            $correlativo_ultimo_boleta=substr(strrchr($numero_serie_busqueda_boleta, "-"),1);
            $correlativo_boleta = $correlativo_ultimo_boleta+1;

            if($correlativo_ultimo_boleta == 99999999){
                $correlativo_boleta = 1;
                $numero_serie_boleta = $numero_serie_boleta+1;
            }
        }


        $sucursal_nr_boleta = str_pad($numero_serie_boleta, 3, "0", STR_PAD_LEFT);
        $correlativo_boleta=str_pad($correlativo_boleta, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero_boleta="COTB ".$sucursal_nr_boleta."-".$correlativo_boleta;
        //LLAMADO A KARDEX POR ALMACEN
        $kardex_entrada=Kardex_entrada::where('almacen_id',$sucursal_p)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',$sucursal_p)->count();
        foreach($kardex_entrada as $kardex_entradas){
            $kadex_entrada_id[]=$kardex_entradas->id;
        }
        for($x=0;$x<$kardex_entrada_count;$x++){
            if(Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->get()){
                $nueva=Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->get();
                foreach( $nueva as $nuevas){
                    $prod[]=$nuevas->producto_id;
                }
            }
        }
        //validacion si hay prductos en el almacen
        if(!isset($prod)){
         return back()->withErrors(['No hay productos en el Almacen con nombre: '.$sucursal->nombre.'']);
     }

        //LLAMAMIENTO DE PRODUCTOS
     $lista=array_values(array_unique($prod));
     $lista_count=count($lista);
     for($x=0;$x<$lista_count;$x++){
        $validacion[$x]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
        if(!$validacion[$x]==NULL){
            $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
        }
    }
    $almacen = $sucursal_p;
          //CALCULO PARA ARRAY DE PRECIO,STOCK,ETC
    $moneda=Moneda::where('principal','0')->first();
    $tipo_cambio=TipoCambio::latest('created_at')->first();
    if ($moneda->tipo == 'extranjera'){
        foreach ($productos as $index => $producto) {
            $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
            $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad[$index])/$tipo_cambio->paralelo,2);
            $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen)->pluck('stock')->first();
            $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')/$tipo_cambio->paralelo,2);
                // return ($producto->utilidad-$producto->descuento1)/100;
        }
    }else{
        foreach ($productos as $index => $producto) {
            $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
            $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad[$index])*$tipo_cambio->paralelo,2);
            $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen)->pluck('stock')->first();
            $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*$tipo_cambio->paralelo,2);
        }
    }

            //LLAMADOS DE TABLAS PARA LA VISTA
    $forma_pagos=Forma_pago::all();
    $clientes=Cliente::where('documento_identificacion','ruc')->get();
    $personales=Personal::all();
    $p_venta=Personal_venta::where('estado','0')->get();
    $igv=Igv::first();
    $empresa=Empresa::first();
    $personal_contador= Facturacion::all()->count();
    $suma=$personal_contador+1;
    $tipo_operacion = Tipo_operacion_f::all();
    $categoria='producto';

    // $moneda=Moneda::where('principal','0')->first();
    $servicios=Servicios::where('estado_anular',0)->get();
    if($moneda->tipo =='extranjera'){
        foreach ($servicios as $index2 => $servicio) {
            $utilidad_serv[]=$servicio->precio_nacional*($servicio->utilidad)/100;
            $array2[]=round(($servicio->precio_nacional+$utilidad_serv[$index2])/$tipo_cambio->paralelo,2);
            $array_promedio_serv[]=round(($servicio->precio_nacional)/$tipo_cambio->paralelo,2);
        }
    }else{
        foreach ($servicios as $index2 => $servicio) {
            $utilidad_serv[]=$servicio->precio_extranjero*($servicio->utilidad)/100;
            $array2[]=round(($servicio->precio_extranjero+$utilidad_serv[$index2])*$tipo_cambio->paralelo,2);
            $array_promedio_serv[]=round(($servicio->precio_extranjero)/$tipo_cambio->paralelo,2);
        }
    }


    return view('transaccion.venta.cotizacion.factura.create_ms2',compact('garantia','validez','productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','suma','categoria','cotizacion_numero','sucursal','tipo_operacion','servicios','array2','array_promedio_serv','cotizacion_numero_boleta'));
        // return $utilidad;
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     ///agregamiento de un parametro extra

    public function store_factura(Request $request,$id_moneda)
    {
        // return $request;

        //codigo para convertir nombre a producto
        $cantidad_p = $request->input('cantidad');
        $count_cantidad_p=count($cantidad_p);
        for($i=0 ; $i<$count_cantidad_p;$i++){
            $articulos[$i]= $request->input('articulo')[$i];
            $producto_id_name[$i]=strstr($articulos[$i], '|');
            $producto_id_2[$i]=strstr($producto_id_name[$i], ' ');
            $producto_id_3[$i]=substr(strstr($producto_id_2[$i], ' '),1);
            $producto_id[$i]=strstr($producto_id_3[$i], ' ', true);
        }
        // return $producto_id; 
        //contador de valores de articulos
        $articulo = $request->input('articulo');
        $count_articulo=count($articulo);

        //validacion para la no incersion de dobles articulos
        // for ($e=0; $e < $count_articulo; $e++){
        //     $articulo_comparacion_inicial=$request->get('articulo')[$e];
        //     for ($a=0; $a< $count_articulo ; $a++) {
        //         if ($a==$e) {
        //             $a++;
        //         }else {
        //             $articulo_comparacion=$request->get('articulo')[$a];
        //             if ($articulo_comparacion_inicial==$articulo_comparacion) {
        //                 // return ->with('repite', 'Datos repetidos - No permitidos!');
        //                 return redirect()->route('cotizacion.index')->withErrors(['Productos repetido - No permitido! ']);
        //             }
        //         }
        //     }
        // }

        // Comisionista cobnvertir id
        $comisionista=$request->get('comisionista');
        if($comisionista!="" and $comisionista!="Sin comision - 0"){
            $numero = strstr($comisionista, '-',true);
            $cod_vendedor=Personal_venta::where('cod_vendedor',$numero)->first();
            $id_personal=$cod_vendedor->id;
            $comisionista_buscador=Personal_venta::where('id',$id_personal)->first();
            $comi=$comisionista_buscador->comision;
        }else{
            $comi=0;
        }

        //Convertir nombre del cliente a id
        $cliente_nombre=$request->get('cliente');
        // $nombre = strstr($cliente_nombre, '-',true);
        $cliente_buscador=Cliente::where('id',$cliente_nombre)->first();

        if(!$cliente_buscador){
            return 'NO hay';
        }

        $forma_pago_id=$request->get('forma_pago');
        $formapago= Forma_pago::find($forma_pago_id);
        $dias= $formapago->dias;
        /*Fecha vencimiento*/
        $fecha =date("d-m-Y");
        $nuevafecha = strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) ;
        $nuevafechas = date("d-m-Y", $nuevafecha );

    //CODIGO N° DE  COTIZACION
        $sucursal=$request->get('almacen');
        $sucursal=Almacen::where('id',$sucursal)->first();
        /*Codigo Cotizacion Factura*/
        if($request->get('tipo_coti') == "1"){
            // FACTURA
            $cotizacion=Cotizacion::where('almacen_id',$sucursal->id)->where('tipo','factura')->latest()->first();
            if (empty($cotizacion)) {
                $numero_serie=$sucursal->id;
                $correlativo=1;
            } else{
                $numero_serie_busqueda=strstr($cotizacion->cod_cotizacion,' ');

                $numero_serie=strstr($numero_serie_busqueda,'-',true);
                $correlativo_ultimo=substr(strrchr($numero_serie_busqueda, "-"),1);
                $correlativo = $correlativo_ultimo+1;

                if($correlativo_ultimo == 99999999){
                    $correlativo = 1;
                    $numero_serie = $numero_serie+1;
                }
            }

            $sucursal_nr = str_pad($numero_serie, 3, "0", STR_PAD_LEFT);
            $correlativo=str_pad($correlativo, 8, "0", STR_PAD_LEFT);
            $cotizacion_numero="COTF ".$sucursal_nr."-".$correlativo;

            $tipo = 'factura';
            $tipo_document = 1;

        }else{
            //BOLETA
            $cotizacion = Cotizacion::where('almacen_id',$sucursal->id)->where('tipo','boleta')->latest()->first();
            if(empty($cotizacion)){
                $numero_serie = $sucursal->id;
                $correlativo = 1;
            }else{
                $numero_serie_busqueda = strstr($cotizacion->cod_cotizacion,' ');
                $numero_serie = strstr($numero_serie_busqueda, '-',true);
                // $numero_serie = strstr($cotizacion->cod_cotizacion,' ');
                $correlativo_ultimo = substr(strstr($numero_serie_busqueda, "-"),1);
                $correlativo = $correlativo_ultimo+1;
                if($correlativo_ultimo == 99999999){
                    $correlativo = 1;
                    $numero_serie = $numero_serie+1;
                }
            }

            $sucursal_nr = str_pad($numero_serie, 3, "0", STR_PAD_LEFT);
            $cotizacion_nr=str_pad($correlativo, 8, "0", STR_PAD_LEFT);
            $cotizacion_numero="COTB ".$sucursal_nr."-".$cotizacion_nr;

            $tipo = 'boleta';
            $tipo_document = 3;
        }
        // return $cotizacion_numero;
        //FIN CODIGO N° DE  COTIZACION

        // return $cotizacion_numero;
        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }
        $tipo_cambio=TipoCambio::latest('created_at')->first();
        //calculo para el stock del producto
        $almacen_producto_validacion=$request->get('almacen');
        for($i=0;$i<$count_articulo;$i++){
            $producto_servicio = Producto::where('codigo_producto',$producto_id[$i])->first();
            if(isset($producto_servicio)){

                $kardex_entrada_v=Kardex_entrada::where('almacen_id',$almacen_producto_validacion)->get();
                $kardex_entrada_count_v=Kardex_entrada::where('almacen_id',$almacen_producto_validacion)->count();
                foreach($kardex_entrada_v as $kardex_entradas_v){
                    $kadex_entrada_id_v[]=$kardex_entradas_v->id;
                }
                for($x=0;$x<$kardex_entrada_count_v;$x++){
                    if(Kardex_entrada_registro::where('producto_id',$producto_servicio->id)->where('kardex_entrada_id',$kadex_entrada_id_v[$x])->first()){
                        $nueva_v[]=Kardex_entrada_registro::where('producto_id',$producto_servicio->id)->where('kardex_entrada_id',$kadex_entrada_id_v[$x])->first();
                    }
                }
                $comparacion_v=$nueva_v;

                //buCle para la cantidad
                $cantidad_v=0;
                foreach($comparacion_v as $comparaciones_v){
                    $cantidad_v=$comparaciones_v->cantidad+$cantidad_v;
                }
                $cantidad_entrada=$request->get('cantidad')[$i];
                if($cantidad_v<$cantidad_entrada){
                    return "cantidad mayor al stock";
                }
            }else{

            }
        }
        // return $cantidad_v;
        // CODIGO PARA BUSCAR EL ID DEL TIPO DE DOCUMENTO
        $operacion=$request->get('tipo_operacion');
        $nombre = strstr($operacion, '-',true);
        $busca_ope=Tipo_operacion_f::where('codigo',$nombre)->first();

        //MONEDA
        $nombre_moneda = $request->get('moneda');
        $id_moneda = Moneda::where('nombre', $nombre_moneda)->first();

        $cotizacion=new Cotizacion;
        $cotizacion->cod_cotizacion=$cotizacion_numero;
        $cotizacion->almacen_id=$request->get('almacen');
        $cotizacion->cliente_id=$cliente_buscador->id;
        $cotizacion->moneda_id=$id_moneda->id;
        $cotizacion->forma_pago_id=$request->get('forma_pago');
        $cotizacion->estado_aprovar='0';
        $cotizacion->estado_aprobado='0';
        $cotizacion->garantia=$request->get('garantia');
        $cotizacion->validez=$request->get('validez');
        $cotizacion->fecha_emision=$request->get('fecha_emision');
        $cotizacion->fecha_vencimiento=$nuevafechas;
        $cotizacion->cambio=$cambio->paralelo;
        $cotizacion->observacion=$request->get('observacion');
        if($comisionista!="" and $comisionista!="Sin comision - 0"){
         $cotizacion->comisionista_id= $comisionista_buscador->id;
     }
     $cotizacion->user_id =auth()->user()->id;
     $cotizacion->estado='0';
     $cotizacion->estado_vigente='0';
     $cotizacion->tipo= $tipo;
     $cotizacion->tipo_documento_id = $tipo_document;
     $cotizacion->tipo_operacion_id = $busca_ope->id;
     $cotizacion->save();

        //contador de valores de cantidad
     $cantidad = $request->input('cantidad');
     $count_cantidad=count($cantidad);

        //contador de valores del check descuento
     $check = $request->input('check_descuento');
     $count_check=count($check);

        //validacion dependiendo de la amoneda escogida
     $moneda=Moneda::where('principal',1)->first();
     $moneda_registrada=$cotizacion->moneda_id;

     if($count_articulo = $count_cantidad  = $count_check){
        for($i=0;$i<$count_articulo;$i++){
            $producto_servicio = Producto::where('codigo_producto',$producto_id[$i])->first();
            if(isset($producto_servicio)){

                $producto=Producto::where('id',$producto_servicio->id)->where('estado_id',1)->first();

                $cotizacion_registro=new Cotizacion_factura_registro;
                $cotizacion_registro->cotizacion_id=$cotizacion->id;
                $cotizacion_registro->producto_id=$producto->id;
                if($request->get('descripcion_item')[$i] == null){ 
                    $cotizacion_registro->descripcion_item = null;
                }else{ 
                    $cotizacion_registro->descripcion_item = $request->get('descripcion_item')[$i];
                }
                
                        // $producto=Producto::where('id',$producto_id[$i])->where('estado_id',1)->where('estado_anular',1)->first();
                        //stock --------------------------------------------------------
                $stock=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$sucursal->id)->pluck('stock')->first();
                // return $sucursal;
                $cotizacion_registro->stock=$stock;

                        //precio --------------------------------------------------------
                if($moneda->id == $moneda_registrada){
                    if ($moneda->tipo == 'nacional') {
                                //promedio original ojo revisar que es precio nacional --------------------------------------------------------

                        $array2=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional'),2);
                        $cotizacion_registro->promedio_original=$array2;

                                // respectividad de la moneda deacurdo al id
                        $utilidad=Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                        $array=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad),2);
                        $cotizacion_registro->precio=$array;
                    }else{
                            //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                        $array2=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero'),2);
                        $cotizacion_registro->promedio_original=$array2;

                            // validacion para la otra moneda con igv paralelo
                        $utilidad=Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                        $array=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad),2);
                        $cotizacion_registro->precio=$array;
                    }
                }else{
                    if ($moneda->tipo == 'extranjera') {
                            //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                        $array2=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*$cambio->paralelo,2);
                        $cotizacion_registro->promedio_original=$array2;

                            // respectividad de la moneda deacuerdo al id
                        $utilidad=Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                        $array=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad)*$cambio->paralelo,2);
                        $cotizacion_registro->precio=$array;
                    }else{
                            //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                        $array2=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')/$cambio->paralelo,2);
                        $cotizacion_registro->promedio_original=$array2;

                            // validacion para la otra moneda con igv paralelo
                        $utilidad=Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                        $array=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad)/$cambio->paralelo,2);
                        $cotizacion_registro->precio=$array;
                    }
                }
                $cotizacion_registro->cantidad=$request->get('cantidad')[$i];
                $cotizacion_registro->descuento=$request->get('check_descuento')[$i];
                $cotizacion_registro->comision=$comi;
                     //precio unitario descuento ----------------------------------------
                $desc_comprobacion=$request->get('check_descuento')[$i];
                //PARA BOLETA
                if($request->get('tipo_coti') == "0"){
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                        $igv=Igv::first();
                        $igv_ac = 0;
                    }else{
                        $igv_ac = 0;
                    }
                }else{
                    $igv_ac = 0;
                }

                if($desc_comprobacion <> 0){
                    $precio_uni = $array - ( $array2*$desc_comprobacion/100);
                    $cotizacion_registro->precio_unitario_desc=$precio_uni+($precio_uni*$igv_ac/100);
                }else{
                    $cotizacion_registro->precio_unitario_desc=$array+($array*($igv_ac/100));
                }
                    //precio unitario comision ----------------------------------------
                if($desc_comprobacion <> 0){
                    $precio_uni = $array - ( $array2*$desc_comprobacion/100);
                    $precio_comi =$precio_uni + ($precio_uni*($comi/100));
                    $prec_uni_des=round($precio_comi+($precio_comi*($igv_ac/100)),2);
                    $cotizacion_registro->precio_unitario_comi=$prec_uni_des;
                }else{
                    $precio_comi = $array+($array*($comi/100));
                    $cotizacion_registro->precio_unitario_comi=round(($precio_comi)+($precio_comi*($igv_ac/100)),2);
                }
                //TIPO DE AFECTACION
                $cotizacion_2=Cotizacion::find($cotizacion->id);
                if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                    $cotizacion_2->op_gravada += round($cotizacion_registro->precio_unitario_comi*$cotizacion_registro->cantidad,2);
                }
                if(strpos($producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                    $cotizacion_2->op_exonerada += round($cotizacion_registro->precio_unitario_comi*$cotizacion_registro->cantidad,2);
                }
                if(strpos($producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                    $cotizacion_2->op_inafecta += round($cotizacion_registro->precio_unitario_comi*$cotizacion_registro->cantidad,2);
                }
                // return $cotizacion_registro->precio_unitario_comi;

                $cotizacion_2->save();
                $cotizacion_registro->save();
            }else{

                $servicio=Servicios::where('codigo_servicio',$producto_id[$i])->where('estado_anular',0)->first();

                $cotizacion_registro=new Cotizacion_factura_registro;
                $cotizacion_registro->cotizacion_id=$cotizacion->id;
                $cotizacion_registro->servicio_id=$servicio->id;
                if($request->get('descripcion_item')[$i] == null){ 
                    $cotizacion_registro->descripcion_item = null;
                }else{ 
                    $cotizacion_registro->descripcion_item = $request->get('descripcion_item')[$i];
                }
                
                // return $servicio;
                //logica para el precio dependiendo de la moneda
                if($moneda->id == $moneda_registrada){
                    if ($moneda->tipo == 'nacional') {
                        $array2 = $servicio->precio_nacional;
                        $cotizacion_registro->promedio_original=$array2;
                        $utilidad=$servicio->precio_nacional*($servicio->utilidad/100);
                        $array=$servicio->precio_nacional+$utilidad;
                        $cotizacion_registro->precio=$array;
                    }else{
                        $array2 = $servicio->precio_extranjero;
                        $cotizacion_registro->promedio_original=$array2;
                        $utilidad=$servicio->precio_extranjero*($servicio->utilidad/100);
                        $array=$servicio->precio_extranjero+$utilidad;
                        $cotizacion_registro->precio=$array;
                    }
                }else{
                    if ($moneda->tipo == 'extranjera') {
                        $array2 = round($servicio->precio_extranjero*$tipo_cambio->paralelo,2);
                        $cotizacion_registro->promedio_original=$array2;
                        $utilidad=$servicio->precio_extranjero*($servicio->utilidad/100);
                        $array=round(($servicio->precio_extranjero+$utilidad)*$tipo_cambio->paralelo,2);
                        $cotizacion_registro->precio=$array;
                    }else{
                        $array2 = round( $servicio->precio_nacional/$tipo_cambio->paralelo,2);
                        $cotizacion_registro->promedio_original=$array2;
                        $utilidad=$servicio->precio_nacional*($servicio->utilidad/100);
                        $array=round(($servicio->precio_nacional+$utilidad)/$tipo_cambio->paralelo,2);
                        $cotizacion_registro->precio=$array;
                    }
                }

                $cotizacion_registro->cantidad=$request->get('cantidad')[$i];
                //descuento
                $desc_comprobacion=$request->get('check_descuento')[$i];
                //PARA BOLETA
                if($request->get('tipo_coti') == "0"){
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                        $igv=Igv::first();
                        $igv_ac = 0;
                    }else{
                        $igv_ac = 0;
                    }
                }else{
                    $igv_ac = 0;
                }

                $cotizacion_registro->comision=$comi;

                $cotizacion_registro->descuento = $desc_comprobacion;

                if($desc_comprobacion <> 0){
                    $precio_uni = $array - ($array2*($desc_comprobacion/100));
                    $cotizacion_registro->precio_unitario_desc=$precio_uni+ ($precio_uni*($igv_ac/100));
                }else{
                    $precio_uni = $array + ($array*($igv_ac/100));
                    $cotizacion_registro->precio_unitario_desc=$precio_uni;
                }
                    //precio unitario comision ----------------------------------------
                if($desc_comprobacion <> 0){
                    $precio_uni = $array - ($array*($desc_comprobacion/100));
                    $precio_comi = $precio_uni+($precio_uni*($comi/100));
                    $prec_uni_des=$array-($array2*$desc_comprobacion/100);
                    $cotizacion_registro->precio_unitario_comi=$precio_comi+($precio_comi*($igv_ac/100));
                }else{
                    $precio_comi = $array + ($array*($comi/100));
                    $cotizacion_registro->precio_unitario_comi=$precio_comi+($precio_comi*($igv_ac/100));
                }
                //TIPO DE AFECTACION
                $cotizacion_2=Cotizacion::find($cotizacion->id);
                if(strpos($servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                    $cotizacion_2->op_gravada += round($cotizacion_registro->precio_unitario_comi*$cotizacion_registro->cantidad,2);
                }
                if(strpos($servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                    $cotizacion_2->op_exonerada += round($cotizacion_registro->precio_unitario_comi*$cotizacion_registro->cantidad,2);
                }
                if(strpos($servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                    $cotizacion_2->op_inafecta += round($cotizacion_registro->precio_unitario_comi*$cotizacion_registro->cantidad,2);
                }
                $cotizacion_2->save();

                $cotizacion_registro->save();
            }
        }
    }else{
        return redirect()->route('cotizacion.create_factura')->with('campo', 'Falto introducir un campo de la tabla productos');
    }
    return redirect()->route('cotizacion.show',$cotizacion->id);
}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function create_boleta(Request $request)
    {
        $inventario_inicial=Kardex_entrada::first();
        if (isset($inventario_inicial)) {
            if ( $inventario_inicial->estado==1) {
                return redirect()->route('kardex-entrada.show',$inventario_inicial->id);
            }
        }
        //CODIGO N° DE  COTIZACION
        $almacen=$request->get('almacen');
        $sucursal=Almacen::where('id',$almacen)->first();
        /*Codigo Cotizacion Factura*/
        $cotizacion=Cotizacion::where('almacen_id',$almacen)->where('tipo','boleta')->latest()->first();
        if (empty($cotizacion)) {
            $numero_serie=$sucursal->id;
            $correlativo=1;
        } else{
            $numero_serie_busqueda=strstr($cotizacion->cod_cotizacion,' ');

            $numero_serie=strstr($numero_serie_busqueda,'-',true);
            $correlativo_ultimo=substr(strrchr($numero_serie_busqueda, "-"),1);
            $correlativo = $correlativo_ultimo+1;

            if($correlativo_ultimo == 99999999){
                $correlativo = 1;
                $numero_serie = $numero_serie+1;
            }
        }


        $sucursal_nr = str_pad($numero_serie, 3, "0", STR_PAD_LEFT);
        $correlativo=str_pad($correlativo, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero="COTB ".$sucursal_nr."-".$correlativo;
        //FIN CODIGO N° DE  COTIZACION



        //LLAMADO A KARDEX POR ALMACEN
        $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen)->count();
        foreach($kardex_entrada as $kardex_entradas){
            $kadex_entrada_id[]=$kardex_entradas->id;
        }
        for($x=0;$x<$kardex_entrada_count;$x++){
            if(Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->get()){
                $nueva=Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->get();
                foreach( $nueva as $nuevas){
                    $prod[]=$nuevas->producto_id;
                }
            }
        }

        //validacion si hay prductos en el almacen
        if(!isset($prod)){
         return back()->withErrors(['No hay productos en el Almacen con nombre: '.$sucursal->nombre.'']);
     }

        //LLAMADO DE PRODUCTOS
     $lista=array_values(array_unique($prod));
     $lista_count=count($lista);
     for($x=0;$x<$lista_count;$x++){
        $validacion[$x]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
        if(!$validacion[$x]==NULL){
            $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
        }
    }

        //CALCULO PARA ARRAY DE PRECIO,STOCK,ETC
    $moneda=Moneda::where('principal','1')->first();
    $igv=Igv::where('id','1')->first();
    $tipo_cambio=TipoCambio::latest('created_at')->first();
    if ($moneda->tipo == 'nacional') {
        foreach ($productos as $index => $producto) {
            $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
            $igv_p[]=(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad[$index]);

            $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad[$index]),2);
            $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen)->sum('stock');
            $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional'),2);
        }
    }else{
        foreach ($productos as $index => $producto) {
            $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
            $igv_p[]=(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad[$index]);

            $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad[$index]),2);
            $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen)->sum('stock');
            $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero'),2);
        }
    }

        //LLAMADO DE TABLAS PARA EL RETURN
    $forma_pagos=Forma_pago::all();
    $clientes=Cliente::where('documento_identificacion','!=','RUC')->get();
    $moneda=Moneda::where('principal','1')->first();
    $personales=Personal::all();
    $p_venta=Personal_venta::where('estado','0')->get();
    $empresa=Empresa::first();
    $tipo_operacion = Tipo_operacion_f::all();

    return view('transaccion.venta.cotizacion.boleta.create',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','cotizacion_numero','sucursal','tipo_operacion'));
}

    //agregamiento de una nueva funcion create_boleta a monde secundaria comnetado
public function create_boleta_ms(Request $request)
{
    $inventario_inicial=Kardex_entrada::first();
    if (isset($inventario_inicial)) {
        if ( $inventario_inicial->estado==1) {
            return redirect()->route('kardex-entrada.show',$inventario_inicial->id);
        }
    }
        //CODIGO N° DE  COTIZACION
    $almacen=$request->get('almacen');
    $sucursal=Almacen::where('id',$almacen)->first();
    /*Codigo Cotizacion Factura*/
    $cotizacion=Cotizacion::where('almacen_id',$almacen)->where('tipo','boleta')->latest()->first();
    if (empty($cotizacion)) {
        $numero_serie=$sucursal->id;
        $correlativo=1;
    } else{
        $numero_serie_busqueda=strstr($cotizacion->cod_cotizacion,' ');

        $numero_serie=strstr($numero_serie_busqueda,'-',true);
        $correlativo_ultimo=substr(strrchr($numero_serie_busqueda, "-"),1);
        $correlativo = $correlativo_ultimo+1;

        if($correlativo_ultimo == 99999999){
            $correlativo = 1;
            $numero_serie = $numero_serie+1;
        }
    }


    $sucursal_nr = str_pad($numero_serie, 3, "0", STR_PAD_LEFT);
    $correlativo=str_pad($correlativo, 8, "0", STR_PAD_LEFT);
    $cotizacion_numero="COTB ".$sucursal_nr."-".$correlativo;
        //FIN CODIGO N° DE  COTIZACION


        //LLAMADO A KARDEX PARA LOS PRODUCTOS
    $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen)->get();
    $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen)->count();
    foreach($kardex_entrada as $kardex_entradas){
        $kadex_entrada_id[]=$kardex_entradas->id;
    }
    for($x=0;$x<$kardex_entrada_count;$x++){
        if(Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->get()){
            $nueva=Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->get();
            foreach( $nueva as $nuevas){
                $prod[]=$nuevas->producto_id;
            }
        }
    }
        //validacion si hay prductos en el almacen
    if(!isset($prod)){
        return back()->withErrors(['No hay productos en el Almacen con nombre: '.$sucursal->nombre.'']);
    }

        //LLAMADO PARA LOS PRODUCTOS
    $lista=array_values(array_unique($prod));
    $lista_count=count($lista);
    for($x=0;$x<$lista_count;$x++){
        $validacion[$x]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
        if(!$validacion[$x]==NULL){
            $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
        }
    }
        //CALCULO PARA ARRAY DE PRECIO,STOCK,ETC
    $moneda=Moneda::where('principal','0')->first();
    $igv=Igv::first();
    $tipo_cambio=TipoCambio::latest('created_at')->first();
    if ($moneda->tipo == 'extranjera') {
        foreach ($productos as $index => $producto) {
            $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
            $igv_p[]=(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad[$index]);
            $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad[$index])/$tipo_cambio->paralelo,2);
            $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen)->sum('stock');
            $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')/$tipo_cambio->paralelo,2);
        }
    }else{
        foreach ($productos as $index => $producto) {
            $utilidad[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100,2);
            $igv_p[]=(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad[$index]);

            $array[]=(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad[$index])*$tipo_cambio->paralelo;
            $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen)->sum('stock');
            $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*$tipo_cambio->paralelo,2);
        }
    }

        //LLAMADO PARA EL LLENADO DE CAMPOS
    $forma_pagos=Forma_pago::all();
    $clientes=Cliente::where('documento_identificacion','!=','RUC')->get();
    $personales=Personal::all();
    $p_venta=Personal_venta::where('estado','0')->get();
    $empresa=Empresa::first();
    $tipo_operacion = Tipo_operacion_f::all();

    return view('transaccion.venta.cotizacion.boleta.create_ms',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','cotizacion_numero','sucursal','tipo_operacion'));
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //  agregar una nueva parametro para recibirtipo de moneda
    public function store_boleta(Request $request,$id_moneda)
    {
        //codigo para convertir nombre a producto
        $cantidad_p = $request->input('cantidad');
        $count_cantidad_p=count($cantidad_p);

        for($i=0 ; $i<$count_cantidad_p;$i++){
            $articulos[$i]= $request->input('articulo')[$i];
            $producto_id[$i]=strstr($articulos[$i], ' ', true);
        }

        //contador de valores de articulos
        $articulo = $request->input('articulo');
        $count_articulo=count($articulo);

        //validacion para la no incersion de dobles articulos
        for ($e=0; $e < $count_articulo; $e++){
            $articulo_comparacion_inicial=$request->get('articulo')[$e];
            for ($a=0; $a< $count_articulo ; $a++) {
                if ($a==$e) {
                    $a++;
                }else {
                    $articulo_comparacion=$request->get('articulo')[$a];
                    if ($articulo_comparacion_inicial==$articulo_comparacion) {
                        return redirect()->route('cotizacion.index')->with('repite', 'Datos repetidos - No permitidos!');
                    }
                }

            }
        }

        // Comisionista convertir id
        $comisionista=$request->get('comisionista');
        if($comisionista!="" and $comisionista!="Sin comision - 0"){
            $numero = strstr($comisionista, '-',true);
            $cod_vendedor=Personal_venta::where('cod_vendedor',$numero)->first();
            $id_personal=$cod_vendedor->id;
            $comisionista_buscador=Personal_venta::where('id',$id_personal)->first();

            //Comision segun comisionista
            $comi=$comisionista_buscador->comision;
        }else{
            $comi=0;
        }

        //Convertir nombre del cliente a id
        $cliente_nombre=$request->get('cliente');
        $nombre = strstr($cliente_nombre, '-',true);
        $cliente_buscador=Cliente::where('numero_documento',$nombre)->first();
        if(!$cliente_buscador){
         return 'NO hay';
     }


     $personal_contador= Cotizacion::all()->count();
     $suma=$personal_contador+1;
     $cod_comision='COBOL-0000'.$suma;


     $forma_pago_id=$request->get('forma_pago');
     $formapago= Forma_pago::find($forma_pago_id);
     $dias= $formapago->dias;
     /*Fecha vencimiento*/
     $fecha =date("d-m-Y");
     $nuevafecha = strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) ;
     $nuevafechas = date("d-m-Y", $nuevafecha );


        //CODIGO COTIZACION
     $almacen=$request->get('almacen');
     $sucursal=Almacen::where('id',$almacen)->first();

     $cotizacion = Cotizacion::where('almacen_id',$sucursal->id)->where('tipo','boleta')->latest()->first();
     if(empty($cotizacion)){
        $numero_serie = $sucursal->id;
        $correlativo = 1;
    }else{
        $numero_serie_busqueda = strstr($cotizacion->cod_cotizacion,' ');
        $numero_serie = strstr($numero_serie_busqueda, '-',true);
        // $numero_serie = strstr($cotizacion->cod_cotizacion,' ');
        $correlativo_ultimo = substr(strstr($numero_serie_busqueda, "-"),1);
        $correlativo = $correlativo_ultimo+1;
        if($correlativo_ultimo == 99999999){
            $correlativo = 1;
            $numero_serie = $numero_serie+1;
        }
    }

    $sucursal_nr = str_pad($numero_serie, 3, "0", STR_PAD_LEFT);
    $cotizacion_nr=str_pad($correlativo, 8, "0", STR_PAD_LEFT);
    $cotizacion_numero="COTB ".$sucursal_nr."-".$cotizacion_nr;


        //CODIGO COTIZACION


    $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
    if(!$cambio){
        return "error por no hacer el cambio diario";
    }

        //PARA SELECCIONAR EL ALMACEN CODIGO PARA AÑADIR

    $almacen_producto_validacion=$request->get('almacen');
    for($i=0;$i<$count_articulo;$i++){
        $kardex_entrada_v=Kardex_entrada::where('almacen_id',$almacen_producto_validacion)->get();
        $kardex_entrada_count_v=Kardex_entrada::where('almacen_id',$almacen_producto_validacion)->count();

            //return $kardex_entrada;
        foreach($kardex_entrada_v as $kardex_entradas_v){
            $kadex_entrada_id_v[]=$kardex_entradas_v->id;
        }
            // return $kardex_entrada;
        for($x=0;$x<$kardex_entrada_count_v;$x++){
            if(Kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('kardex_entrada_id',$kadex_entrada_id_v[$x])->first()){
                $nueva_v[]=Kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('kardex_entrada_id',$kadex_entrada_id_v[$x])->first();
            }
        }
        $comparacion_v=$nueva_v;

            //buble para la cantidad
        $cantidad_v=0;
        foreach($comparacion_v as $comparaciones_v){
            $cantidad_v=$comparaciones_v->cantidad+$cantidad_v;
        }
        $cantidad_entrada=$request->get('cantidad')[$i];
        if($cantidad_v<$cantidad_entrada){
            return "cantidad mayor al stock";
        }
    }
    // CODIGO PARA BUSCAR EL ID DEL TIPO DE DOCUMENTO
    $operacion=$request->get('tipo_operacion');
    $nombre = strstr($operacion, '-',true);
    $busca_ope=Tipo_operacion_f::where('codigo',$nombre)->first();
        //REGISTRO EN TABLA COTIZACION
    $cotizacion=new Cotizacion;
    $cotizacion->cod_cotizacion=$cotizacion_numero;
    $cotizacion->almacen_id=$request->get('almacen');
    $cotizacion->cliente_id=$cliente_buscador->id;
    $cotizacion->moneda_id=$id_moneda;
    $cotizacion->forma_pago_id=$request->get('forma_pago');
    $cotizacion->estado_aprovar='0';
    $cotizacion->estado_aprobado='0';
    $cotizacion->garantia=$request->get('garantia');
    $cotizacion->validez=$request->get('validez');
    $cotizacion->fecha_emision=$request->get('fecha_emision');
    $cotizacion->fecha_vencimiento=$nuevafechas;
    $cotizacion->cambio=$cambio->paralelo;
    $cotizacion->observacion=$request->get('observacion');
    if($comisionista!="" and $comisionista!="Sin comision - 0"){
        $cotizacion->comisionista_id= $comisionista_buscador->id;
    }
    $cotizacion->user_id =auth()->user()->id;
    $cotizacion->estado='0';
    $cotizacion->estado_vigente='0';
    $cotizacion->tipo='boleta';
    $cotizacion->tipo_documento_id = 3;
    $cotizacion->tipo_operacion_id = $busca_ope->id;
    $cotizacion->save();

        //contador de valores de cantidad
    $cantidad = $request->input('cantidad');
    $count_cantidad=count($cantidad);

        //contador de valores del check descuento
    $check = $request->input('check_descuento');
    $count_check=count($check);

    $igv=Igv::first();

    $moneda=Moneda::where('principal',1)->first();
    $moneda_registrada=$cotizacion->moneda_id;


    if($count_articulo = $count_cantidad  = $count_check){
        for($i=0;$i<$count_articulo;$i++){
            $cotizacion_registro=new Cotizacion_boleta_registro;
            $cotizacion_registro->cotizacion_id=$cotizacion->id;
            $cotizacion_registro->producto_id=$producto_id[$i];
            $producto=Producto::where('id',$producto_id[$i])->where('estado_id',1)->first();
            if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false ){
                $igv=Igv::first();
                $igv_tot = $igv->igv_total;
            }else{
                $igv_tot = 0;
            }
            //stock --------------------------------------------------------
            $stock=Stock_almacen::where('producto_id',$producto_id[$i])->where('almacen_id',$sucursal->id)->sum('stock');
            $cotizacion_registro->stock=$stock;

                //precio --------------------------------------------------------
            if($moneda->id == $moneda_registrada){
                if ($moneda->tipo == 'nacional'){
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                    $array2=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional');
                    $cotizacion_registro->promedio_original=$array2;
                    $utilidad=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                    $igv_p=(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')+$utilidad);
                    $array=(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')+$utilidad);
                    $array_pre_prom=$array+($array*($igv_tot/100));
                    $cotizacion_registro->precio = $array_pre_prom;
                }else{
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                    $array2=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero');
                    $cotizacion_registro->promedio_original=$array2;
                    $utilidad=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                    $igv_p=(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')+$utilidad);
                    $array=(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')+$utilidad);
                    $array_pre_prom=$array+($array*($igv_tot/100));
                    $cotizacion_registro->precio = $array_pre_prom;
                }
            }else{
                if ($moneda->tipo == 'extranjera'){
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                    $array2=round(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')*$cambio->paralelo,2);
                    $cotizacion_registro->promedio_original=$array2;
                    $utilidad=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                    $igv_p=(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')+$utilidad);
                    $array=round((Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')+$utilidad)*$cambio->paralelo,2);
                    $array_pre_prom=($array)+($array*($igv_tot/100));
                    $cotizacion_registro->precio = $array_pre_prom;
                }else{
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                    $array2=round(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')/$cambio->paralelo,2);
                    $cotizacion_registro->promedio_original=$array2;
                    $utilidad=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                    $igv_p=(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')+$utilidad);
                    $array=round(((Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')+$utilidad)/$cambio->paralelo),2);
                    $array_pre_prom=($array)+($array*($igv_tot/100));
                    $cotizacion_registro->precio = $array_pre_prom;
                }
            }
            $cotizacion_registro->cantidad=$request->get('cantidad')[$i];
            $cotizacion_registro->descuento=$request->get('check_descuento')[$i];
            $cotizacion_registro->comision=$comi;
                //precio unitario descuento ----------------------------------------
            $desc_comprobacion=$request->get('check_descuento')[$i];
            if($desc_comprobacion <> 0){
                $precio_uni = $array - ($array2*$desc_comprobacion/100);
                $cotizacion_registro->precio_unitario_desc=$precio_uni+($precio_uni*($igv_tot/100));
                // return $array*($igv->igv_total/100);
            }else{
                $cotizacion_registro->precio_unitario_desc=$array+($array*($igv_tot/100));
                // return $array_pre_prom;
            }
                //precio unitario comision ----------------------------------------
            if($desc_comprobacion <> 0){
               $precio_uni = $array - ($array2*$desc_comprobacion/100);
               $precio_comi = $precio_uni+($precio_uni*($comi/100));
               $cotizacion_registro->precio_unitario_comi=$precio_comi+($precio_comi*($igv_tot/100));
           }else{
            $precio_comi = $array+($array*($comi/100));
            $cotizacion_registro->precio_unitario_comi=($precio_comi)+($precio_comi*($igv_tot/100));
        }

             //TIPO DE AFECTACION
        $cotizacion_2=Cotizacion::find($cotizacion->id);
        if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
            $cotizacion_2->op_gravada += round($cotizacion_registro->precio_unitario_comi*$cotizacion_registro->cantidad,2);
        }
        if(strpos($producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
            $cotizacion_2->op_exonerada += round($cotizacion_registro->precio_unitario_comi*$cotizacion_registro->cantidad,2);
        }
        if(strpos($producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
            $cotizacion_2->op_inafecta += round($cotizacion_registro->precio_unitario_comi*$cotizacion_registro->cantidad,2);
        }
        $cotizacion_2->save();
        $cotizacion_registro->save();
            // return $cotizacion_registro->precio_unitario_comi;
    }
}else {
    return redirect()->route('cotizacion.create_boleta')->with('campo', 'Falto introducir un campo de la tabla productos');
}
return redirect()->route('cotizacion.show2',$cotizacion->id);
}

public function show($id)
{
    // REDIRECCION PARA MOSTRAR EL inventario_inicial
    $existe_id=kardex_entrada::where('estado',2)->first();
    if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

    //REDIRECCION PARA NO MOSTRAR ERROR LARAVEL DE ID SHOW
    $existe_id=Cotizacion::where('id',$id)->first();
    if(empty($existe_id)){ return redirect()->route('cotizacion.index'); }

    $banco=Banco::where('estado','0')->get();
    $banco_count=Banco::where('estado','0')->count();
    $cotizacion=Cotizacion::find($id);
    $regla=$cotizacion->tipo;
    $sub_total=0;
    $igv=Igv::first();
    $factura= Facturacion::where('id_cotizador',$id)->first();
    $boleta=Boleta::where('id_cotizador',$id)->first();

    /*registros boleta y factura*/
    if ($regla=='factura') {
        $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
    }elseif ($regla=='boleta') {
        $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
    }
    /* FIN registros boleta y factura*/

    /*de numeros a Letras*/
    // foreach ($cotizacion_registro as $cotizacion_registros) {
    //     $sub_total=($cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi)+$sub_total;
    //     $simbologia=$cotizacion->moneda->simbolo.$igv_p=round($sub_total, 2)*$igv->igv_total/100;

    // }
    // if($cotizacion->tipo == "factura"){
    $sub_total = $cotizacion->op_gravada+$cotizacion->op_exonerada+$cotizacion->op_inafecta;
    // }else{
    //      foreach ($cotizacion_registro as $cotizacion_registros) {
    //         $sub_total=($cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi)+$sub_total;
    //         $simbologia=$cotizacion->moneda->simbolo.$igv_p=round($sub_total, 2)*$igv->igv_total/100;
    //     }
    // }
    $igv_p=round($cotizacion->op_gravada, 2)*$igv->igv_total/100;
    // if ($regla=='factura') {
    $end=round($sub_total, 2)+round($igv_p, 2);
    $end2=number_format(round($sub_total, 2)+round($igv_p, 2),2);
    // }elseif ($regla=='boleta'){
    //     $end=round($sub_total, 2);
    //     $end2=number_format(round($sub_total, 2),2);

    // }
    /* Finde numeros a Letras*/

    $firma= EmailConfiguraciones::where('id_usuario',$cotizacion->user_id)->pluck('firma_digital')->first();
    $empresa=Empresa::first();
    $sum=0;
    $i=1;

        //para mandar una nueva cotizacion en la vista .show como un boton
    $almacen=Almacen::where('id',$cotizacion->almacen_id)->pluck('id')->first();
    $nueva_cot='cotizacion.create_factura';

    return view('transaccion.venta.cotizacion.show2', compact('cotizacion','empresa','cotizacion_registro','sum','igv',"sub_total","regla",'banco','end','igv_p','almacen','nueva_cot','banco_count','i','boleta','factura','firma','end2'));
}

public function print($id){

    // REDIRECCION PARA MOSTRAR EL inventario_inicial
    $existe_id=kardex_entrada::where('estado',2)->first();
    if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

    //REDIRECCION PARA NO MOSTRAR ERROR LARAVEL DE ID SHOW
    $existe_id=Cotizacion::where('id',$id)->first();
    if(empty($existe_id)){ return redirect()->route('cotizacion.index'); }

    $banco=Banco::where('estado','0')->get();
    $banco_count=Banco::where('estado','0')->count();
    $cotizacion=Cotizacion::find($id);
    $regla=$cotizacion->tipo;
    $sub_total=0;
    $igv=Igv::first();

    /*registros boleta y factura*/
    if($regla=='factura'){
        $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
    }elseif($regla=='boleta'){
        $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
    }
    /* FIN registros boleta y factura*/
    /*de numeros a Letras*/

    // foreach($cotizacion_registro as $cotizacion_registros){
    $sub_total=$cotizacion->op_gravada;

    $igv_p=round($cotizacion->op_gravada, 2)*$igv->igv_total/100;
    // if ($regla=='factura') {
    $end=round($sub_total, 2)+round($igv_p, 2);
    $end2=number_format(round($sub_total, 2)+round($igv_p, 2),2);
    // }elseif ($regla=='boleta'){
    //     $end=round($sub_total, 2);
    //     $end2=number_format(round($sub_total, 2),2);

    // }
    /* Finde numeros a Letras*/
    $empresa=Empresa::first();
    $sum=0;
    $i=1;

    return view('transaccion.venta.cotizacion.print2', compact('cotizacion','empresa','cotizacion_registro','sum','igv',"sub_total","regla",'banco','i','end','igv_p','banco_count','end2'));
}
public function pdf(Request $request,$id){
    $name = $request->get('name');
    $banco=Banco::where('estado','0')->get();
    $banco_count=Banco::where('estado','0')->count();
    $cotizacion=Cotizacion::find($id);
    $regla=$cotizacion->tipo;
    $sub_total=0;
    $igv=Igv::first();
    /*registros boleta y factura*/
    // if($regla=='factura'){
    $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
    // }elseif($regla=='boleta'){
    //     $cotizacion_registro=Cotizacion_boleta_registro::where('cotizacion_id',$id)->get();
    // }
    /* FIN registros boleta y factura*/
    /*de numeros a Letras*/
    // foreach($cotizacion_registro as $cotizacion_registros){
    $sub_total = $cotizacion->op_gravada+$cotizacion->op_exonerada+$cotizacion->op_inafecta;
    $igv_p=round($cotizacion->op_gravada, 2)*$igv->igv_total/100;
    // if ($regla=='factura') {
    $end=round($sub_total, 2)+round($igv_p, 2);
    $end2=number_format(round($sub_total, 2)+round($igv_p, 2),2);
    // }elseif ($regla=='boleta'){
    //     $end=round($sub_total, 2);
    //     $end2=number_format(round($sub_total, 2),2);

    // }
    // }

    /* Finde numeros a Letras*/
    $empresa=Empresa::first();
    $sum=0;
    $i=1;
    $regla=$cotizacion->tipo;
    $archivo=$name.$regla.$id.".pdf";
    // return "1";
    // return view('transaccion.venta.cotizacion.pdf2',compact('cotizacion','empresa','cotizacion_registro','regla','sum','igv','sub_total','banco','i','end','igv_p','banco_count','end2'));
    if($request->get('firma') == "0"){
        $pdf=PDF::loadView('transaccion.venta.cotizacion.pdf2',compact('cotizacion','empresa','cotizacion_registro','regla','sum','igv','sub_total','banco','i','end','igv_p','banco_count','end2'));
        return $pdf->download('Cotizacion - '.$archivo.'.pdf');
    }else{
        $firma= EmailConfiguraciones::where('id_usuario',$cotizacion->user_id)->pluck('firma_digital')->first();
        $pdf=PDF::loadView('transaccion.venta.cotizacion.pdf2',compact('cotizacion','empresa','cotizacion_registro','regla','sum','igv','sub_total','banco','i','end','igv_p','banco_count','firma','end2'));
        return $pdf->download('Cotizacion - '.$archivo.'.pdf');
    }
}
    //envio hacia facturar cambiar en caso incluya algo
public function facturar(Request $request,$id)
{

    // REDIRECCION PARA MOSTRAR EL inventario_inicial
    $existe_id=kardex_entrada::where('estado',2)->first();
    if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

    //REDIRECCION PARA NO MOSTRAR ERROR LARAVEL DE ID SHOW
    $existe_id=Cotizacion::where('id',$id)->first();
    if(empty($existe_id)){ return redirect()->route('cotizacion.index'); }

    $cotizacion=Cotizacion::where('id',$id)->first();
    $cotizacion_moneda=$cotizacion->moneda_id;

    // CONVERSION A MONEDA PRINCIPAL Y SECUNDARIO
    $tipo_cambio=TipoCambio::latest('created_at')->first();
    $moneda1=Moneda::where('principal',1)->first();
    $moneda2=Moneda::where('principal',0)->first();

    $cotizacion_registros=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();

    foreach ($cotizacion_registros as  $cotizacion_registro) {
        if(isset($cotizacion_registro->producto_id)){
            $productos = Producto::where('estado_id','!=',2)->where('id',$cotizacion_registro->producto_id)->get();
            
            foreach ($productos as $index => $producto) {
                // dd($producto);
                if($cotizacion_moneda == $moneda1->id){
                    if($moneda1->tipo == "nacional"){
                       $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                       $array[] = Stock_producto::where('producto_id' , $producto->id)->avg('precio_nacional')+$utilidad;
                       $array_cantidad[] = Stock_almacen::where('producto_id', $producto->id)->where('almacen_id',$cotizacion->almacen_id)->sum('stock');
                       $array_promedio[] = Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional');
                   }else{
                    $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                    $array[] = Stock_producto::where('producto_id' , $producto->id)->avg('precio_extranjero')+$utilidad;
                    $array_cantidad[] = Stock_almacen::where('producto_id', $producto->id)->where('almacen_id',$cotizacion->almacen_id)->sum('stock');
                    $array_promedio[] = Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero');
                }

            }elseif($cotizacion_moneda == $moneda2->id){
                if($moneda2->tipo == "extranjera"){
                    $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                    $array[] = round((Stock_producto::where('producto_id' , $producto->id)->avg('precio_nacional')+$utilidad)/$tipo_cambio->paralelo,2);
                    $array_cantidad[] = Stock_almacen::where('producto_id', $producto->id)->where('almacen_id',$cotizacion->almacen_id)->sum('stock');
                    $array_promedio[] = round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional'))/$tipo_cambio->paralelo,2);
                }else{
                    $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                    $array[] = round((Stock_producto::where('producto_id' , $producto->id)->avg('precio_extranjero')+$utilidad)*$tipo_cambio->paralelo,2);
                    $array_cantidad[] = Stock_almacen::where('producto_id', $producto->id)->where('almacen_id',$cotizacion->almacen_id)->sum('stock');
                    $array_promedio[] = round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero'))*$tipo_cambio->paralelo,2);
                }

            }
            $val[] = $array;
        }

    }else{
            // dd($index);
        $servicios = Servicios::where('estado_anular',0)->where('id', $cotizacion_registro->servicio_id)->get();
            // dd($servicios);
        foreach ($servicios as $index2 => $servicio) {
            if($cotizacion_moneda == $moneda1->id){
                if($moneda1->tipo == "nacional"){
                    $utilidad_serv = $servicio->precio_nacional*($servicio->utilidad)/100;
                    $array[] = round($servicio->precio_nacional + $utilidad_serv,2);
                    $array_cantidad[] = 10;
                    $array_promedio[] = ($servicio->precio_nacional);
                }else{
                    $utilidad_serv = $servicio->precio_extranjero*($servicio->utilidad)/100;
                    $array[] = round($servicio->precio_extranjero + $utilidad_serv,2);
                    $array_cantidad[] = 10;
                    $array_promedio[] = ($servicio->precio_extranjero);
                }
            }elseif($cotizacion_moneda == $moneda2->id){
                if($moneda2->tipo == "extranjera"){
                    $utilidad_serv = $servicio->precio_nacional*($servicio->utilidad)/100;
                    $array[] = round(($servicio->precio_nacional + $utilidad_serv)/$tipo_cambio->paralelo,2);
                    $array_cantidad[] = 10;
                    $array_promedio[] = round(($servicio->precio_nacional)/$tipo_cambio->paralelo,2);
                }else{
                    $utilidad_serv = $servicio->precio_extranjero*($servicio->utilidad)/100;
                    $array[] = round(($servicio->precio_extranjero + $utilidad_serv)*$tipo_cambio->paralelo,2);
                    $array_cantidad[] = 10;
                    $array_promedio[] = round(($servicio->precio_extranjero)*$tipo_cambio->paralelo,2);
                }
            }

        }
        $val[] = $array;
    }

}
    // return $array;


    // return  $producto[$index];
$comisionista=$cotizacion->comisionista_id;
if($comisionista!="" and $comisionista!="Sin comision - 0"){
        // $numero = strstr($comisionista, '-',true);
        // $cod_vendedor=Personal_venta::where('cod_vendedor',$numero)->first();
        // $id_personal=$cod_vendedor->id;
    $comisionista_buscador=Personal_venta::where('id',$comisionista)->first();
                //Comision segun comisionista
    $comi=$comisionista_buscador->comision;
         // return $numero;
}else{
    $comi=0;
}
$forma_pagos=Forma_pago::all();
$clientes=Cliente::where('documento_identificacion','ruc')->get();
$personales=Personal::all();
$p_venta=Personal_venta::where('estado','0')->get();
$igv=Igv::first();
$empresa=Empresa::first();
$personal_contador= Facturacion::all()->count();
$suma=$personal_contador+1;

$banco = Banco::all();
$categoria='producto';

$cotizacion=Cotizacion::find($id);

$empresa=Empresa::first();
$sum=0;
$igv=Igv::first();
$sub_total=0;

$almacen=$request->get('almacen');

        //obtencion del almacen
$sucursal=Almacen::where('id', $almacen)->first();
$codigo_guia = Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
        // return $sucursal;
$factura_cod_fac=$codigo_guia->cod_factura;
if (is_numeric($factura_cod_fac)) {
            // exprecion del numero de fatura
    $factura_cod_fac++;
    $sucursal_nr = str_pad($codigo_guia->serie_factura, 3, "0", STR_PAD_LEFT);
    $factura_nr=str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);
}else{
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
    $ultima_factura=Facturacion::where('almacen_id',$sucursal->id)->latest()->first();
    $factura_num=$ultima_factura->codigo_fac;
    $factura_num_string_porcion= explode("-", $factura_num);
    $factura_num_string=$factura_num_string_porcion[1];
    $factura_num=(int)$factura_num_string;
        /// +99999999
    $almacen_codigo = Codigo_guia_almacen::orderBy('serie_factura','DESC')->latest()->first();
    if($factura_num == 99999999){
        $ultima_factura = $almacen_codigo->serie_factura+1;
        $factura_num = 00000000;
    }else{
        $ultima_factura = $codigo_guia->serie_factura;
    }
    $factura_num++;
    $sucursal_nr = str_pad($ultima_factura, 3, "0", STR_PAD_LEFT);
    $factura_nr=str_pad($factura_num, 8, "0", STR_PAD_LEFT);
}
        // return  $ultima_facturac;
$cod_fac="F".$sucursal_nr."-".$factura_nr;



if ($cotizacion->estado==0) {
    return view('transaccion.venta.cotizacion.facturar2', compact('cotizacion','empresa','sum','igv',"array","sub_total",'cod_fac','cotizacion_registros','array_cantidad','comi','array_promedio','forma_pagos','banco'));
}
elseif ($cotizacion->estado==1) {
    return redirect()->route('cotizacion.show',$cotizacion->id);
}
}

public function facturar_store(Request $request)
{
    // return $request;
    $id = $request->get('id');
    $id_cotizador=$request->get('id_cotizador');
    $cotizacion=Cotizacion::where('id',$id_cotizador)->first();
    $cotizacion_registros=Cotizacion_factura_registro::where('cotizacion_id',$cotizacion->id)->get();
    // $almacen_producto_validacion=$request->get('almacen');
    
    foreach ($cotizacion_registros as $index_val => $cotizacion_registros2) {
        $producto_servicio = Producto::where('id',$cotizacion_registros2->producto_id)->first();
        if(isset($producto_servicio->id)){
            $kardex_entrada_v=Kardex_entrada::where('almacen_id',$cotizacion->almacen_id)->get();
            $kardex_entrada_count_v=Kardex_entrada::where('almacen_id',$cotizacion->almacen_id)->count();

            //return $kardex_entrada;
            foreach($kardex_entrada_v as $kardex_entradas_v){
                $kadex_entrada_id_v[]=$kardex_entradas_v->id;
            }
            // return $kardex_entrada;
            for($x=0;$x<$kardex_entrada_count_v;$x++){
                if(Kardex_entrada_registro::where('producto_id',$producto_servicio->id)->where('kardex_entrada_id',$kadex_entrada_id_v[$x])->where('estado',1)->where('tipo_registro_id','!=',2)->first()){
                    $nueva_v[]=Kardex_entrada_registro::where('producto_id',$producto_servicio->id)->where('kardex_entrada_id',$kadex_entrada_id_v[$x])->where('estado',1)->where('tipo_registro_id','!=',2)->first();
                }
            }
            $comparacion_v=$nueva_v;
            //buble para la cantidad
            $cantidad_v=0;
            foreach($comparacion_v as $comparaciones_v){
                $cantidad_v=$comparaciones_v->cantidad+$cantidad_v;
            }
            $cantidad_entrada=$cotizacion_registros2->cantidad;
            if($cantidad_v<$cantidad_entrada){
               // return back()->with('repite',);
             return redirect()->route('cotizacion.show',$cotizacion->id)->withErrors('El producto '.$cotizacion_registros2->producto->nombre.' no cuenta con el stock suficiente para crear la factura');
         }
     }
 }
    // return $cantidad_entrada;
    //LLAMDO AL DIA ACTUAL Y CONVERSION DE SIMBOLOS
 $date_sp = Carbon::now();
 $data_g = str_replace(' ', '_',$date_sp);
 $carbon_sp = str_replace(':','-',$data_g);
    //buscador al cambio
 $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
    // if(!$cambio){return "error por no hacer el cambio diario"; }

 $tipo_cambio=TipoCambio::latest('created_at')->first();
        // cambio de Estado Cotizador

 $cotizacion=Cotizacion::where('id',$id_cotizador)->first();
 $cotizacion->estado=1;
 $cotizacion->save();
    //CODIGO DE LA FACTURA
 $almacen=$cotizacion->almacen_id;
    //obtencion del almacen
 $sucursal=Almacen::where('id', $almacen)->first();
 $codigo_guia = Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
 $factura_cod_fac=$codigo_guia->cod_factura;
 if (is_numeric($factura_cod_fac)) {
            // exprecion del numero de fatura
    $factura_cod_fac++;
    $sucursal_nr = str_pad($codigo_guia->serie_factura, 3, "0", STR_PAD_LEFT);
    $factura_nr=str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);
}else{
           // exprecion del numero de fatura
           // GENERACION DE NUMERO DE FACTURA
    $ultima_factura=Facturacion::where('almacen_id',$sucursal->id)->latest()->first();
    $factura_num=$ultima_factura->codigo_fac;
    $factura_num_string_porcion= explode("-", $factura_num);
    $factura_num_string=$factura_num_string_porcion[1];
    $factura_num=(int)$factura_num_string;

    $almacen_codigo = Codigo_guia_almacen::orderBy('serie_factura','DESC')->latest()->first();
    if($factura_num == 99999999){
        $ultima_factura = $almacen_codigo->serie_factura+1;
        $almacen_fac_ser = Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
        $almacen_fac_ser->serie_factura = $ultima_factura;
        $almacen_fac_ser->save();
        $factura_num = 00000000;
    }else{
        $ultima_factura = $codigo_guia->serie_factura;
    }
    $factura_num++;
    $sucursal_nr = str_pad($ultima_factura, 3, "0", STR_PAD_LEFT);
    $factura_nr=str_pad($factura_num, 8, "0", STR_PAD_LEFT);
}
$factura_numero="F".$sucursal_nr."-".$factura_nr;

        // Comisionista convertir id
$comisionista=$cotizacion->comisionista_id;
if($comisionista!="" and $comisionista!="Sin comision - 0"){
        // $numero = strstr($comisionista, '-',true);
        // $cod_vendedor=Personal_venta::where('cod_vendedor',$numero)->first();
        // $id_personal=$cod_vendedor->id;
    $comisionista_buscador=Personal_venta::where('id',$comisionista)->first();
                //Comision segun comisionista
    $comi=$comisionista_buscador->comision;
}else{
    $comi=0;
}

    // FORMA DE PAGO
$forma_pago_id=$request->get('forma_pago');
if($forma_pago_id == 1){
    $val = $request->get('fecha_vencimiento');

    $nuevafechas = date('d-m-Y', strtotime(($val)));


}else{
    $fecha_pago_forma = $request->input('fecha_pago');
    $contador_for_1 = count($fecha_pago_forma);
    for($c = 0; $c<$contador_for_1;$c++ ){
        $val = $fecha_pago_forma[$c];
    }

    $nuevafechas = date('d-m-Y', strtotime(($val)));
}
            // Creacion de Facturacion
$facturar=new Facturacion;
$facturar->codigo_fac=$factura_numero;
$facturar->almacen_id=$cotizacion->almacen_id;
$facturar->id_cotizador=$request->get('id_cotizador');
$facturar->orden_compra=$request->get('orden_compra');
$facturar->guia_remision=$request->get('guia_remision');
$facturar->cliente_id=$cotizacion->cliente_id;
$facturar->moneda_id=$cotizacion->moneda_id;
$facturar->forma_pago_id=$request->get('forma_pago');
$facturar->fecha_emision=$request->get('fecha_emision');
$facturar->fecha_vencimiento=$nuevafechas;
$facturar->cambio=$cambio->paralelo;
$facturar->observacion=$request->get('observacion');
$facturar->comisionista=$cotizacion->comisionista_id;
$facturar->user_id =auth()->user()->id;
$facturar->estado='0';
$facturar->tipo='producto';
    // $facturar->op_gravada=$cotizacion->op_gravada;
    // $facturar->op_inafecta=$cotizacion->op_inafecta;
    // $facturar->op_exonerada=$cotizacion->op_exonerada;
$facturar->tipo_operacion_id=$cotizacion->tipo_operacion_id;
$facturar->tipo_documento_id=$cotizacion->tipo_documento_id;
$facturar->save();
if($facturar->forma_pago_id == 2){
    $fecha_pago = $request->input('fecha_pago');
    $contador_for = count($fecha_pago);
    $monto_pago = $request->input('monto_pago');
        // foreach($contador_for as $cuotas => $index ){
    for($c = 0; $c<$contador_for;$c++ ){
        $cuota_cred = new Cuotas_credito;
        $cuota_cred->facturacion_id = $facturar->id;
        $cuota_cred->numero_cuota = $c+1;
        $cuota_cred->monto = $monto_pago[$c];
        $cuota_cred->fecha_pago = $fecha_pago[$c];
        $cuota_cred->save();
    }
}
    // modificacion para que se cierre el codigo en almacen
$factura_primera=Codigo_guia_almacen::where('almacen_id', $sucursal->id)->first();
if(is_numeric($factura_primera->cod_factura)){
    $factura_primera->cod_factura='NN';
    $factura_primera->save();
}

        //validacion dependiendo de la amoneda escogida
$moneda=Moneda::where('principal',1)->first();
$moneda_registrada=$facturar->moneda_id;
$moneda1=Moneda::where('principal',1)->first();
$moneda2=Moneda::where('principal',0)->first();


$cotizacion_registros=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();

foreach ($cotizacion_registros as $index0=> $cotizacion_registro) {
    if(isset($cotizacion_registro->producto_id)){
        $productos = Producto::where('estado_id','!=',2)->where('id',$cotizacion_registro->producto_id)->get();


        foreach ($productos as $index => $producto) {
            $facturacion_registro=new Facturacion_registro;
            $facturacion_registro->facturacion_id=$facturar->id;
            $facturacion_registro->producto_id=$producto->id;
            $facturacion_registro->numero_serie=$request->get('numero_serie')[$index0];
            $facturacion_registro->descripcion_item=$request->get('descripcion_item')[$index0];
            $stock = Stock_almacen::where('producto_id', $producto->id)->where('almacen_id',$cotizacion->almacen_id)->sum('stock');

            $facturacion_registro->stock = $stock;
                // dd($producto);
            if($moneda1->id == $moneda_registrada){
                if($moneda1->tipo == "nacional"){
                    $array_promedio = Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional');
                    $facturacion_registro->promedio_original = $array_promedio;
                    $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                    $array = Stock_producto::where('producto_id' , $producto->id)->avg('precio_nacional')+$utilidad;
                    $facturacion_registro->precio = $array;
                }else{
                    $array_promedio = Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero');
                    $facturacion_registro->promedio_original = $array_promedio;
                    $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                    $array = Stock_producto::where('producto_id' , $producto->id)->avg('precio_extranjero')+$utilidad;
                    $facturacion_registro->precio = $array;
                }

            }elseif($moneda2->id == $moneda_registrada){
                if($moneda2->tipo == "extranjera"){
                    $array_promedio = round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional'))/$tipo_cambio->paralelo,2);
                    $facturacion_registro->promedio_original = $array_promedio;
                    $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                    $array = round((Stock_producto::where('producto_id' , $producto->id)->avg('precio_nacional')+$utilidad)/$tipo_cambio->paralelo,2);
                    $facturacion_registro->precio = $array;
                }else{
                    $array_promedio = round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero'))*$tipo_cambio->paralelo,2);
                    $facturacion_registro->promedio_original = $array_promedio;
                    $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                    $array = round((Stock_producto::where('producto_id' , $producto->id)->avg('precio_extranjero')+$utilidad)*$tipo_cambio->paralelo,2);
                    $facturacion_registro->precio = $array;
                }

            }
            $facturacion_registro->cantidad=$cotizacion_registro->cantidad;
            $facturacion_registro->descuento=$cotizacion_registro->descuento;
            $facturacion_registro->comision=$cotizacion_registro->comision;
            $desc_comprobacion=$cotizacion_registro->descuento;

            if($desc_comprobacion <> 0){
                $facturacion_registro->precio_unitario_desc=$array-($array_promedio*$desc_comprobacion/100);
            }else{
                $facturacion_registro->precio_unitario_desc=$array;
            }
                    //precio unitario comision ----------------------------------------
            if($desc_comprobacion <> 0){
                $array_desc= ($array-($array_promedio*$desc_comprobacion/100));
                $facturacion_registro->precio_unitario_comi=$array_desc+($array_desc*$comi/100);
            }else{
                $facturacion_registro->precio_unitario_comi=$array+($array*$comi/100);
            }

            $facturacion_2=Facturacion::find($facturar->id);
            if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                $facturacion_2->op_gravada += round($facturacion_registro->precio_unitario_comi*$facturacion_registro->cantidad,2);
            }
            if(strpos($producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                $facturacion_2->op_exonerada += round($facturacion_registro->precio_unitario_comi*$facturacion_registro->cantidad,2);
            }
            if(strpos($producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                $facturacion_2->op_inafecta += round($facturacion_registro->precio_unitario_comi*$facturacion_registro->cantidad,2);
            }
                    // return $cotizacion_registro->precio_unitario_comi;
            $facturacion_2->save();
            $facturacion_registro->save();
            $nueva=Kardex_entrada_registro::where('producto_id',$facturacion_registro->producto_id)->where('almacen_id',$almacen)->where('estado',1)->get();
            // return $nueva;
            // return $nueva;
            $comparacion=$nueva;
            //buble para la cantidad
            $cantidad=0;
            foreach($comparacion as $comparaciones){
                $cantidad=$comparaciones->cantidad+$cantidad;
            }
            if(isset($comparacion)){
                $var_cantidad_entrada=$facturacion_registro->cantidad;
                $contador=0;
                foreach ($comparacion as $p_com) {
                    if($p_com->cantidad>$var_cantidad_entrada){
                        $cantidad_mayor=$p_com->cantidad;
                        $cantidad_final=$cantidad_mayor-$var_cantidad_entrada;
                        $p_com->cantidad=$cantidad_final;
                        if($cantidad_final==0){
                            $p_com->estado=0;
                            $p_com->save();
                            break;
                        }else{
                            $p_com->save();
                            break;
                        }
                    }elseif($p_com->cantidad==$var_cantidad_entrada){
                        $p_com->cantidad=0;
                        $p_com->estado=0;
                        $p_com->save();
                        break;
                    }
                    else{
                        $var_cantidad_entrada=$var_cantidad_entrada-$p_com->cantidad;
                        $p_com->cantidad=0;
                        $p_com->estado=0;
                        $p_com->save();
                    }
                }
            }
            $stock_productos=Stock_producto::where('producto_id',$producto->id)->first();
            $stock_productos->stock=$stock_productos->stock-$facturacion_registro->cantidad;
            $stock_productos->save();
            //Resta en la tabla stock almacen
            Stock_almacen::egreso($cotizacion->almacen_id,$producto->id,$facturacion_registro->cantidad);
        }


    }else{

        $facturacion_registro=new Facturacion_registro;
        $facturacion_registro->facturacion_id=$facturar->id;
        $facturacion_registro->servicio_id=$cotizacion_registro->servicio_id;
        $facturacion_registro->numero_serie=$request->get('numero_serie')[$index0];
        $facturacion_registro->descripcion_item=$request->get('descripcion_item')[$index0];
        $facturacion_registro->promedio_original=$cotizacion_registro->promedio_original;
        $facturacion_registro->precio=$cotizacion_registro->precio;
        $facturacion_registro->cantidad=$cotizacion_registro->cantidad;
        $facturacion_registro->descuento=$cotizacion_registro->descuento;
        $facturacion_registro->precio_unitario_desc=$cotizacion_registro->precio_unitario_desc;
        $facturacion_registro->comision=$cotizacion_registro->comision;
        $facturacion_registro->precio_unitario_comi=$cotizacion_registro->precio_unitario_comi;
        $facturacion_registro->save();

        $facturacion_2=Facturacion::find($facturar->id);
        if(strpos($cotizacion_registro->servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
            $facturacion_2->op_gravada += ($facturacion_registro->precio_unitario_comi*$facturacion_registro->cantidad);
        }
        if(strpos($cotizacion_registro->servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
            $facturacion_2->op_exonerada += ($facturacion_registro->precio_unitario_comi*$facturacion_registro->cantidad);
        }
        if(strpos($cotizacion_registro->servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
            $facturacion_2->op_inafecta += ($facturacion_registro->precio_unitario_comi*$facturacion_registro->cantidad);
        }
        $facturacion_2->save();
            // }
            // $val[] = $array;
    }

}
kardex_entrada_registro::stock_producto_precio();

    // return ""





     // Creacion de Ventas Registros del Comisinista
$cotizador=$request->get('id_cotizador');
$precio_final_igv=$request->get('precio_final_igv');
$sub_total_sin_igv=$request->get('sub_total_sin_igv');
$tipo_moneda=$request->get('tipo_moneda');
$id_comisionista=$request->get('id_comisionista');
$comisionista=Cotizacion::where('id',$cotizador)->first();
$comisionista_porcentaje=Personal_venta::where('id',$id_comisionista)->first();
$id_comi=$comisionista->comisionista_id;
if(isset($id_comi)){
   $comisionista=new Ventas_registro;
   $comisionista->comisionista=$request->get('id_comisionista');
   $comisionista->tipo_moneda=$tipo_moneda;
   $comisionista->estado_aprobado='0';
   $comisionista->estado_pagado='0';
   $comisionista->estado_anular_fac_bol='0';
   $comisionista->monto_final_fac_bol=$precio_final_igv;
   $porcentaje=100+$comisionista_porcentaje->comision;
   $comisionista->monto_comision=(100*$sub_total_sin_igv/$porcentaje)*$comisionista_porcentaje->comision/100;
   $comisionista->id_coti_produc=$cotizador;
   $comisionista->id_fac=$facturar->id;
   $comisionista->observacion='Viene del Cotizador';
   $comisionista->save();
}
   // return "bien?";
        //CONDICIONAL PARA ENVIO DE CORREO
$validacion = $request->get('validacion');
if($validacion==1){
            //pdf request
    $name = $request->get('name');
    $banco=Banco::where('estado','0')->get();
    $banco_count=Banco::where('estado','0')->count();
    $cotizacion=Cotizacion::find($id);
    $regla=$cotizacion->tipo;
    $sub_total=0;
    $igv=Igv::first();
    /*registros boleta y factura*/
    if($regla=='factura'){
        $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
    }elseif($regla=='boleta'){
        $cotizacion_registro=Cotizacion_boleta_registro::where('cotizacion_id',$id)->get();
    }
    /* FIN registros boleta y factura*/
    /*de numeros a Letras*/
    foreach($cotizacion_registro as $cotizacion_registros){
        $sub_total=($cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi)+$sub_total;
        $simbologia=$cotizacion->moneda->simbolo.$igv_p=round($sub_total, 2)*$igv->igv_total/100;
        if ($regla=='factura') {$end=round($sub_total, 2)+round($igv_p, 2);} elseif ($regla=='boleta') {$end=round($sub_total, 2);}
    }
    /* Finde numeros a Letras*/
    $empresa=Empresa::first();
    $sum=0;
    $i=1;
    $regla=$cotizacion->tipo;

    $archivo=$name.'_'.$id.".pdf";
    $pdf=PDF::loadView('transaccion.venta.cotizacion.pdf',compact('cotizacion','empresa','cotizacion_registro','regla','sum','igv','sub_total','banco','i','end','igv_p','banco_count'));
    $content = $pdf->download();
            //pdf fin
    $especif = $carbon_sp.$archivo;
    Storage::disk('mailbox')->put($especif,$content);
    $date = $carbon_sp;

    $id_usuario=auth()->user()->id;
    $correo_busqueda=EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
    $correo=$correo_busqueda->email;

    $firma=$correo_busqueda->firma;
    $mensaje_html = $request->get('mensaje');
            //FIRMA DE CORREO ELECTRONICO
    if($firma == null){
        $mensaje_con_firma ='<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script> $(document).ready(function(){ $("table").removeClass("table table-bordered").addClass("css"); });</script>
        <style> .css,table,tr,td{ padding: 15px; border: 1px solid black; border-collapse: collapse;} table{ width:100%;}
        </style>'.$mensaje_html.'</body>';
    }else{
        $mensaje_con_firma ='<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script> $(document).ready(function(){ $("table").removeClass("table table-bordered").addClass("css"); }); </script>
        <style> .css,table,tr,td{ padding: 15px; border: 1px solid black; border-collapse: collapse; } table{ width:100%; }
        </style>'.$mensaje_html.'</body><br/><footer><img name="firma" src=" '.url('/').'/archivos/imagenes/firmas/'.$firma.'" width="550px" height="auto" /></footer>';
    }
            /////////ENVIO DE CORREO/////// https://myaccount.google.com/u/0/lesssecureapps?pli=1 <--- VAINA DE AUTORIZACION PARA EL GMAIL
            $smtpAddress = $correo_busqueda->smtp; // = $request->smtp
            $port = $correo_busqueda->port;
            $encryption = $correo_busqueda->encryption;
            $yourEmail = $correo;
            $estado = '0';
            $yourPassword = $correo_busqueda->password;
            $sendto = $request->get('remitente') ;
            $titulo = "Envio de Factura Automatico";
            $mensaje = $mensaje_con_firma;
            $bakcup=    $correo_busqueda->email_backup ;
            //ARCHIVO DE PDF
            $pdf=$archivo;
            $pdfile = public_path().'/archivos/'.$especif;
            //DATOS DE ENVIO
            $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
            $mailer = new \Swift_Mailer($transport);
            //ARCHIVOS POR BOTON ARCHIVO
            $newfile = $request->file('archivos');
            if($request->hasfile('archivos')){
                foreach ($newfile as $file) {
                    $nombre =  $file->getClientOriginalName();
                    $especif = $carbon_sp.$nombre;
                    \Storage::disk('mailbox')->put( $especif ,  \File::get($file));
                    $news[] = public_path().'/archivos/'.$especif;
                    $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto,$bakcup])->setBody($mensaje, 'text/html');
                    $message->attach(\Swift_Attachment::fromPath($pdfile));
                    foreach ($news as $attachment) {
                        $message->attach(\Swift_Attachment::fromPath($attachment));
                    }
                }
            }else{
                $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto,$bakcup ])->setBody($mensaje, 'text/html');
                $message->attach(\Swift_Attachment::fromPath($pdfile));
            }
            if($mailer->send($message)){
                $mensaje =$request->get('mensaje') ;
                $texto= strip_tags($mensaje);
                $mail = new EmailBandejaEnvios;
                $mail->id_usuario =auth()->user()->id;
                $mail->destinatario =$correo;
                $mail->remitente =$request->get('remitente') ;
                $mail->asunto =$titulo;
                $mail->mensaje =$mensaje_con_firma;
                $mail->mensaje_sin_html =$texto ;
                $mail->estado= $estado;
                $mail->fecha_hora =Carbon::now() ;
                $mail-> save();
                $newfile2 = $request->file('archivos');
                if($request->hasfile('archivos')){
                    foreach ($newfile2 as $file2) {
                        $guardar_email_archivo=new EmailBandejaEnviosArchivos;
                        $guardar_email_archivo->id_bandeja_envios=$mail->id;
                        $guardar_email_archivo->archivo= $file2->getClientOriginalName();
                        $guardar_email_archivo->fecha_hora= $carbon_sp;
                        $guardar_email_archivo->save();
                    }
                }
                $archivo_pdf = new EmailBandejaEnviosArchivos;
                $archivo_pdf->id_bandeja_envios=$mail->id;
                $archivo_pdf->archivo=$pdf;
                $archivo_pdf->fecha_hora= $especif;
                $archivo_pdf->save();
            }else{
                return "Something went wrong :(";
            }
        }else{
            return redirect()->route('facturacion.show',$facturar->id);
        }
    }

    public function boletear(Request $request,$id)
    {
        $igv=Igv::where('id','1')->first();

        $cotizacion=Cotizacion::where('id',$id)->first();
        $cotizacion_moneda=$cotizacion->moneda_id;

        $banco = Banco::get();

        $tipo_cambio=TipoCambio::latest('created_at')->first();
        $moneda1=Moneda::where('principal',1)->first();
        $moneda2=Moneda::where('principal',0)->first();

        $cotizacion_registros=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
        // foreach($productos as $lista){
        //     $produc[]=Producto::where('estado_id','!=',2)->where('id',$lista->producto_id)->first();
        // }

        foreach ($cotizacion_registros as  $cotizacion_registro) {
            if(isset($cotizacion_registro->producto_id)){
                $productos = Producto::where('estado_id','!=',2)->where('id',$cotizacion_registro->producto_id)->get();

                foreach ($productos as $index => $producto) {
                // dd($producto);
                    if($cotizacion_moneda == $moneda1->id){
                        if($moneda1->tipo == "nacional"){
                           $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                           $array[] = Stock_producto::where('producto_id' , $producto->id)->avg('precio_nacional')+$utilidad;
                           $array_cantidad[] = Stock_almacen::where('producto_id', $producto->id)->where('almacen_id',$cotizacion->almacen_id)->sum('stock');
                           $array_promedio[] = Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional');
                       }else{
                        $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                        $array[] = Stock_producto::where('producto_id' , $producto->id)->avg('precio_extranjero')+$utilidad;
                        $array_cantidad[] = Stock_almacen::where('producto_id', $producto->id)->where('almacen_id',$cotizacion->almacen_id)->sum('stock');
                        $array_promedio[] = Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero');
                    }

                }elseif($cotizacion_moneda == $moneda2->id){
                    if($moneda2->tipo == "extranjera"){
                        $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                        $array[] = round((Stock_producto::where('producto_id' , $producto->id)->avg('precio_nacional')+$utilidad)/$tipo_cambio->paralelo,2);
                        $array_cantidad[] = Stock_almacen::where('producto_id', $producto->id)->where('almacen_id',$cotizacion->almacen_id)->sum('stock');
                        $array_promedio[] = round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional'))/$tipo_cambio->paralelo,2);
                    }else{
                        $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                        $array[] = round((Stock_producto::where('producto_id' , $producto->id)->avg('precio_extranjero')+$utilidad)*$tipo_cambio->paralelo,2);
                        $array_cantidad[] = Stock_almacen::where('producto_id', $producto->id)->where('almacen_id',$cotizacion->almacen_id)->sum('stock');
                        $array_promedio[] = round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero'))*$tipo_cambio->paralelo,2);
                    }
                    
                }
                $val[] = $array;
            }
            
        }else{
            // dd($index);
            $servicios = Servicios::where('estado_anular',0)->where('id', $cotizacion_registro->servicio_id)->get();
            // dd($servicios);
            foreach ($servicios as $index2 => $servicio) {
                if($cotizacion_moneda == $moneda1->id){
                    if($moneda1->tipo == "nacional"){
                        $utilidad_serv = $servicio->precio_nacional*($servicio->utilidad)/100;
                        $array[] = round($servicio->precio_nacional + $utilidad_serv,2);
                        $array_cantidad[] = 10;
                        $array_promedio[] = ($servicio->precio_nacional);
                    }else{
                        $utilidad_serv = $servicio->precio_extranjero*($servicio->utilidad)/100;
                        $array[] = round($servicio->precio_extranjero + $utilidad_serv,2);
                        $array_cantidad[] = 10;
                        $array_promedio[] = ($servicio->precio_extranjero);
                    }
                }elseif($cotizacion_moneda == $moneda2->id){
                    if($moneda2->tipo == "extranjera"){
                        $utilidad_serv = $servicio->precio_nacional*($servicio->utilidad)/100;
                        $array[] = round(($servicio->precio_nacional + $utilidad_serv)/$tipo_cambio->paralelo,2);
                        $array_cantidad[] = 10;
                        $array_promedio[] = round(($servicio->precio_nacional)/$tipo_cambio->paralelo,2);
                    }else{
                        $utilidad_serv = $servicio->precio_extranjero*($servicio->utilidad)/100;
                        $array[] = round(($servicio->precio_extranjero + $utilidad_serv)*$tipo_cambio->paralelo,2);
                        $array_cantidad[] = 10;
                        $array_promedio[] = round(($servicio->precio_extranjero)*$tipo_cambio->paralelo,2);
                    }
                }

            }
            $val[] = $array;
        }

    }
    $comisionista=$cotizacion->comisionista_id;
    if($comisionista!="" and $comisionista!="Sin comision - 0"){
            // $numero = strstr($comisionista, '-',true);
            // $cod_vendedor=Personal_venta::where('cod_vendedor',$numero)->first();
            // $id_personal=$cod_vendedor->id;
        $comisionista_buscador=Personal_venta::where('id',$comisionista)->first();
                    //Comision segun comisionista
        $comi=$comisionista_buscador->comision;
    }else{
        $comi=0;
    }
    $empresa=Empresa::first();
    $sum=0;
    $igv=Igv::first();
    $sub_total=0;
    $almacen=$request->get('almacen');
    $forma_pagos=Forma_pago::all();
        //obtencion del almacen
    $sucursal=Almacen::where('id', $almacen)->first();
    $codigo_guia = Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
    $factura_cod_bol=$codigo_guia->cod_boleta;
    if (is_numeric($factura_cod_bol)) {
            // exprecion del numero de fatura
        $factura_cod_bol++;
        $sucursal_nr = str_pad($codigo_guia->serie_boleta, 3, "0", STR_PAD_LEFT);
        $boleta_nr=str_pad($factura_cod_bol, 8, "0", STR_PAD_LEFT);
    }else{
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
        $ultima_boleta=Boleta::where('almacen_id',$sucursal->id)->latest()->first();
        $boleta_num=$ultima_boleta->codigo_boleta;
        $boleta_num_string_porcion= explode("-", $boleta_num);
        $boleta_num_string=$boleta_num_string_porcion[1];
        $boleta_num=(int)$boleta_num_string;
        $almacen_codigo = Codigo_guia_almacen::orderBy('serie_boleta','DESC')->latest()->first();
        if($boleta_num == 99999999){
            $ultima_boleta = $almacen_codigo->serie_boleta+1;
            $boleta_num = 00000000;
        }else{
            $ultima_boleta = $codigo_guia->serie_boleta;
        }
        $boleta_num++;
        $sucursal_nr = str_pad($ultima_boleta, 3, "0", STR_PAD_LEFT);
        $boleta_nr=str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
    }
        // return $factura_cod_bol;
    $cod_bol="B".$sucursal_nr."-".$boleta_nr;

    if ($cotizacion->estado==0) {
        return view('transaccion.venta.cotizacion.boletear2', compact('cotizacion','empresa','cotizacion_registros','sum','igv',"array","sub_total" ,'cod_bol','array_cantidad','comi','array_promedio','forma_pagos','banco'));
    }
    elseif ($cotizacion->estado==1) {
        return redirect()->route('cotizacion.show',$cotizacion->id);
    }

}

public function boletear_store(Request $request)
{
        //LLAMA A LA FECHA Y COMVIERTE LOS SIGNOS
    $date_sp = Carbon::now();
    $data_g = str_replace(' ', '_',$date_sp);
    $carbon_sp = str_replace(':','-',$data_g);
    $id = $request->get('id');
    $cotizacion=Cotizacion::where('id',$id)->first();
    $cotizacion_registros=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
    foreach ($cotizacion_registros as $index_val => $cotizacion_registros2) {
        $producto_servicio = Producto::where('id',$cotizacion_registros2->producto_id)->first();
        if(isset($producto_servicio->id)){
            $kardex_entrada_v=Kardex_entrada::where('almacen_id',$cotizacion->almacen_id)->get();
            $kardex_entrada_count_v=Kardex_entrada::where('almacen_id',$cotizacion->almacen_id)->count();

                //return $kardex_entrada;
            foreach($kardex_entrada_v as $kardex_entradas_v){
                $kadex_entrada_id_v[]=$kardex_entradas_v->id;
            }
                // return $kardex_entrada;
            for($x=0;$x<$kardex_entrada_count_v;$x++){
                if(Kardex_entrada_registro::where('producto_id',$producto_servicio->id)->where('kardex_entrada_id',$kadex_entrada_id_v[$x])->where('estado',1)->where('tipo_registro_id','!=',2)->first()){
                    $nueva_v[]=Kardex_entrada_registro::where('producto_id',$producto_servicio->id)->where('kardex_entrada_id',$kadex_entrada_id_v[$x])->where('estado',1)->where('tipo_registro_id','!=',2)->first();
                }
            }
            $comparacion_v=$nueva_v;
                //buble para la cantidad
            $cantidad_v=0;
            foreach($comparacion_v as $comparaciones_v){
                $cantidad_v=$comparaciones_v->cantidad+$cantidad_v;
            }
            $cantidad_entrada=$cotizacion_registros2->cantidad;
            if($cantidad_v<$cantidad_entrada){
                   // return back()->with('repite',);
             return redirect()->route('cotizacion.show',$cotizacion->id)->withErrors('El producto '.$cotizacion_registros2->producto->nombre.' no cuenta con el stock suficiente para crear la factura');
         }
     }
 }
        //buscador al cambio
 $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
 $tipo_cambio=TipoCambio::latest('created_at')->first();

 $id_cotizador=$request->get('id_cotizador');

 $cotizacion=Cotizacion::where('id',$id_cotizador)->first();
 $cotizacion->estado=1;
 $cotizacion->save();

        // obtencion de la sucursal
 $almacen=$cotizacion->almacen_id;
        //obtencion del almacen
 $sucursal=Almacen::where('id', $almacen)->first();
 $codigo_guia = Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
 $boleta_cod_fac=$codigo_guia->cod_boleta;
 if (is_numeric($boleta_cod_fac)) {
            // exprecion del numero de fatura
    $boleta_cod_fac++;
    $sucursal_nr = str_pad($codigo_guia->serie_boleta, 3, "0", STR_PAD_LEFT);
    $boleta_nr=str_pad($boleta_cod_fac, 8, "0", STR_PAD_LEFT);
}else{
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
    $ultima_factura=Boleta::where('almacen_id',$sucursal->id)->latest()->first();
    $boleta_num=$ultima_factura->codigo_boleta;
    $boleta_num_string_porcion= explode("-", $boleta_num);
    $boleta_num_string=$boleta_num_string_porcion[1];
    $boleta_num=(int)$boleta_num_string;
    $almacen_codigo = Codigo_guia_almacen::orderBy('serie_boleta','DESC')->latest()->first();
    if($boleta_num == 99999999){
        $ultima_boleta = $almacen_codigo->serie_boleta+1;
        $almacen_bol_ser = Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
        $almacen_bol_ser->serie_boleta = $ultima_boleta;
        $almacen_bol_ser->save();
        $boleta_num = 00000000;
    }else{
        $ultima_boleta = $codigo_guia->serie_boleta;
    }
    $boleta_num++;
    $sucursal_nr = str_pad($ultima_boleta, 3, "0", STR_PAD_LEFT);
    $boleta_nr=str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
}
$boleta_numero="B".$sucursal_nr."-".$boleta_nr;

        // Comisionista convertir id
$comisionista=$cotizacion->comisionista_id;
if($comisionista!="" and $comisionista!="Sin comision - 0"){
            // $numero = strstr($comisionista, '-',true);
            // $cod_vendedor=Personal_venta::where('cod_vendedor',$numero)->first();
            // $id_personal=$cod_vendedor->id;
    $comisionista_buscador=Personal_venta::where('id',$comisionista)->first();
            //Comision segun comisionista
    $comi=$comisionista_buscador->comision;
}else{
    $comi=0;
}

        // Creacion de Boleta
$boletear=new Boleta;
$boletear->codigo_boleta=$boleta_numero;
$boletear->almacen_id=$cotizacion->almacen_id;
$boletear->orden_compra=$request->get('orden_compra');
$boletear->guia_remision=$request->get('guia_remision');
$boletear->id_cotizador=$request->get('id_cotizador');
$boletear->cliente_id=$cotizacion->cliente_id;
$boletear->moneda_id=$cotizacion->moneda_id;
$boletear->forma_pago_id=$cotizacion->forma_pago_id;
$boletear->fecha_emision=$request->get('fecha_emision');
$boletear->fecha_vencimiento=$request->get('fecha_vencimiento');
$boletear->cambio=$cambio->paralelo;
$boletear->observacion=$cotizacion->observacion;
$boletear->comisionista=$cotizacion->comisionista_id;
$boletear->user_id =auth()->user()->id;
$boletear->estado='0';
$boletear->tipo='producto';
        // $boletear->op_gravada=$cotizacion->op_gravada;
        // $boletear->op_inafecta=$cotizacion->op_inafecta;
        // $boletear->op_exonerada=$cotizacion->op_exonerada;
$boletear->tipo_operacion_id=$cotizacion->tipo_operacion_id;
$boletear->tipo_documento_id=$cotizacion->tipo_documento_id;
$boletear->save();

if($boletear->forma_pago_id == 2){
    $fecha_pago = $request->input('fecha_pago');
    $contador_for = count($fecha_pago);
    $monto_pago = $request->input('monto_pago');
        // foreach($contador_for as $cuotas => $index ){
    for($c = 0; $c<$contador_for;$c++ ){
        $cuota_cred = new Cuotas_credito;
        $cuota_cred->boletear = $boletear->id;
        $cuota_cred->numero_cuota = $c+1;
        $cuota_cred->monto = $monto_pago[$c];
        $cuota_cred->fecha_pago = $fecha_pago[$c];
        $cuota_cred->save();
    }
}
        // modificacion para que se cierre el codigo en almacen
$boleta_primera=Codigo_guia_almacen::where('almacen_id', $sucursal->id)->first();
if(is_numeric($boleta_primera->cod_boleta)){
    $boleta_primera->cod_boleta='NN';
    $boleta_primera->save();
}

$buscador_id=Cotizacion::where('id',$boletear->id_cotizador)->first();

$productos=Cotizacion_boleta_registro::where('cotizacion_id',$buscador_id->id)->get();
foreach($productos as $lista){
    $produc[]=Producto::where('estado_id','!=',2)->where('id',$lista->producto_id)->first();
}

        //validacion dependiendo de la amoneda escogida
$moneda=Moneda::where('principal',1)->first();
$moneda_registrada=$boletear->moneda_id;
$moneda1=Moneda::where('principal',1)->first();
$moneda2=Moneda::where('principal',0)->first();





foreach ($cotizacion_registros as $index0=> $cotizacion_registro) {
    if(isset($cotizacion_registro->producto_id)){
        $productos = Producto::where('estado_id','!=',2)->where('id',$cotizacion_registro->producto_id)->get();


        foreach ($productos as $index => $producto) {
            $boleta_registros=new Boleta_registro;
            $boleta_registros->boleta_id=$boletear->id;
            $boleta_registros->producto_id=$producto->id;
            $boleta_registros->numero_serie=$request->get('numero_serie')[$index0];
            $boleta_registros->descripcion_item=$request->get('descripcion_item')[$index0];
            $stock = Stock_almacen::where('producto_id', $producto->id)->where('almacen_id',$cotizacion->almacen_id)->sum('stock');

            $boleta_registros->stock = $stock;
                // dd($producto);
            if($moneda1->id == $moneda_registrada){
                if($moneda1->tipo == "nacional"){
                    $array_promedio = Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional');
                    $boleta_registros->promedio_original = $array_promedio;
                    $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                    $array = Stock_producto::where('producto_id' , $producto->id)->avg('precio_nacional')+$utilidad;
                    $boleta_registros->precio = $array;
                }else{
                    $array_promedio = Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero');
                    $boleta_registros->promedio_original = $array_promedio;
                    $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                    $array = Stock_producto::where('producto_id' , $producto->id)->avg('precio_extranjero')+$utilidad;
                    $boleta_registros->precio = $array;
                }

            }elseif($moneda2->id == $moneda_registrada){
                if($moneda2->tipo == "extranjera"){
                    $array_promedio = round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional'))/$tipo_cambio->paralelo,2);
                    $boleta_registros->promedio_original = $array_promedio;
                    $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                    $array = round((Stock_producto::where('producto_id' , $producto->id)->avg('precio_nacional')+$utilidad)/$tipo_cambio->paralelo,2);
                    $boleta_registros->precio = $array;
                }else{
                    $array_promedio = round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero'))*$tipo_cambio->paralelo,2);
                    $boleta_registros->promedio_original = $array_promedio;
                    $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                    $array = round((Stock_producto::where('producto_id' , $producto->id)->avg('precio_extranjero')+$utilidad)*$tipo_cambio->paralelo,2);
                    $boleta_registros->precio = $array;
                }

            }
            $boleta_registros->cantidad=$cotizacion_registro->cantidad;
            $boleta_registros->descuento=$cotizacion_registro->descuento;
            $boleta_registros->comision=$cotizacion_registro->comision;
            $desc_comprobacion=$cotizacion_registro->descuento;

            if(strpos($boleta_registros->producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                $igv = Igv::first();
                $igv_tot = 0;
            }else{
                $igv_tot = 0;
            }

            if($desc_comprobacion <> 0){
                $array_desc = ($array-($array_promedio*$desc_comprobacion/100));
                $boleta_registros->precio_unitario_desc=$array_desc+($array_desc*$igv_tot /100);
            }else{
                $boleta_registros->precio_unitario_desc=$array+($array*$igv_tot/100);
            }
                        //precio unitario comision ----------------------------------------
            if($desc_comprobacion <> 0){
                $array_desc = ($array-($array_promedio*$desc_comprobacion/100));
                $array_comi = $array_desc + ($array_desc*$comi/100);
                $boleta_registros->precio_unitario_comi = $array_comi + ($array_comi*$igv_tot / 100);
            }else{
                $array_comi = $array+($array*$comi/100);
                $boleta_registros->precio_unitario_comi= $array_comi + ($array_comi*$igv_tot / 100);
            }
            $boleta_2=Boleta::find($boletear->id);
            if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                $boleta_2->op_gravada += round($boleta_registros->precio_unitario_comi*$boleta_registros->cantidad,2);
            }
            if(strpos($producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                $boleta_2->op_exonerada += round($boleta_registros->precio_unitario_comi*$boleta_registros->cantidad,2);
            }
            if(strpos($producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                $boleta_2->op_inafecta += round($boleta_registros->precio_unitario_comi*$boleta_registros->cantidad,2);
            }
            $boleta_2->save();
            $boleta_registros->save();

            $nueva=Kardex_entrada_registro::where('producto_id',$boleta_registros->producto_id)->where('almacen_id',$almacen)->where('estado',1)->get();
                // return $nueva;
                // return $nueva;
            $comparacion=$nueva;
                //buble para la cantidad
            $cantidad=0;
            foreach($comparacion as $comparaciones){
                $cantidad=$comparaciones->cantidad+$cantidad;
            }
            if(isset($comparacion)){
                $var_cantidad_entrada=$boleta_registros->cantidad;
                $contador=0;
                foreach ($comparacion as $p_com) {
                    if($p_com->cantidad>$var_cantidad_entrada){
                        $cantidad_mayor=$p_com->cantidad;
                        $cantidad_final=$cantidad_mayor-$var_cantidad_entrada;
                        $p_com->cantidad=$cantidad_final;
                        if($cantidad_final==0){
                            $p_com->estado=0;
                            $p_com->save();
                            break;
                        }else{
                            $p_com->save();
                            break;
                        }
                    }elseif($p_com->cantidad==$var_cantidad_entrada){
                        $p_com->cantidad=0;
                        $p_com->estado=0;
                        $p_com->save();
                        break;
                    }
                    else{
                        $var_cantidad_entrada=$var_cantidad_entrada-$p_com->cantidad;
                        $p_com->cantidad=0;
                        $p_com->estado=0;
                        $p_com->save();
                    }
                }
            }
            $stock_productos=Stock_producto::where('producto_id',$producto->id)->first();
            $stock_productos->stock=$stock_productos->stock-$boleta_registros->cantidad;
            $stock_productos->save();
                //Resta en la tabla stock almacen
            Stock_almacen::egreso($cotizacion->almacen_id,$producto->id,$boleta_registros->cantidad);
        }

    }else{

        $boleta_registros=new Boleta_registro;
        $boleta_registros->boleta_id=$boletear->id;
        $boleta_registros->servicio_id=$cotizacion_registro->servicio_id;
        $boleta_registros->numero_serie=$request->get('numero_serie')[$index0];
        $boleta_registros->descripcion_item=$request->get('descripcion_item')[$index0];
        $boleta_registros->promedio_original=$cotizacion_registro->promedio_original;
        $boleta_registros->precio=$cotizacion_registro->precio;
        $boleta_registros->cantidad=$cotizacion_registro->cantidad;
        $boleta_registros->descuento=$cotizacion_registro->descuento;
        $boleta_registros->precio_unitario_desc=$cotizacion_registro->precio_unitario_desc;
        $boleta_registros->comision=$cotizacion_registro->comision;
        $boleta_registros->precio_unitario_comi=$cotizacion_registro->precio_unitario_comi;
        $boleta_registros->save();

        $boleta_2=Boleta::find($boletear->id);
        if(strpos($cotizacion_registro->servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
            $boleta_2->op_gravada += ($boleta_registros->precio_unitario_comi*$boleta_registros->cantidad);
        }
        if(strpos($cotizacion_registro->servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
            $boleta_2->op_exonerada += ($boleta_registros->precio_unitario_comi*$boleta_registros->cantidad);
        }
        if(strpos($cotizacion_registro->servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
            $boleta_2->op_inafecta += ($boleta_registros->precio_unitario_comi*$boleta_registros->cantidad);
        }
        $boleta_2->save();
            // }
            // $val[] = $array;
    }

}
kardex_entrada_registro::stock_producto_precio();

        // Creacion de Ventas Registros del Comisinista
$cotizador=$request->get('id_cotizador');
$total=$request->get('total');
$tipo_moneda=$request->get('tipo_moneda');
$id_comisionista=$request->get('id_comisionista');
$comisionista=Cotizacion::where('id',$cotizador)->first();
$igv=Igv::first();
$comisionista_porcentaje=Personal_venta::where('id',$id_comisionista)->first();
$id_comi=$comisionista->comisionista_id;
if(isset($id_comi)){
   $comisionista=new Ventas_registro;
   $comisionista->comisionista=$request->get('id_comisionista');
   $comisionista->tipo_moneda=$tipo_moneda;
   $comisionista->estado_aprobado='0';
   $comisionista->estado_pagado='0';
   $comisionista->estado_anular_fac_bol='0';
   $comisionista->monto_final_fac_bol=$total;
   $porcentaje_igv=100+$igv->igv_total;
   $porcentaje=100+$comisionista_porcentaje->comision;
   $comisionista->monto_comision=((100*$total/$porcentaje_igv)*100/$porcentaje)*$comisionista_porcentaje->comision/100;
   $comisionista->id_coti_produc=$cotizador;
   $comisionista->id_bol=$boletear->id;
   $comisionista->observacion='Viene del Cotizador';
   $comisionista->save();
}

$validacion = $request->get('validacion');
if($validacion==1){
    $name = $request->get('name');
    $banco=Banco::where('estado','0')->get();
    $banco_count=Banco::where('estado','0')->count();
    $cotizacion=Cotizacion::find($id);
    $regla=$cotizacion->tipo;
    $sub_total=0;
    $igv=Igv::first();
    /*registros boleta y factura*/
    if($regla=='factura'){
        $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
    }elseif($regla=='boleta'){
        $cotizacion_registro=Cotizacion_boleta_registro::where('cotizacion_id',$id)->get();
    }
    /* FIN registros boleta y factura*/
    /*de numeros a Letras*/
    foreach($cotizacion_registro as $cotizacion_registros){
        $sub_total=($cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi)+$sub_total;
        $simbologia=$cotizacion->moneda->simbolo.$igv_p=round($sub_total, 2)*$igv->igv_total/100;
        if ($regla=='factura') {
            $end=round($sub_total, 2)+round($igv_p, 2);
        } elseif ($regla=='boleta') {
            $end=round($sub_total, 2);
        }
    }
    /* Finde numeros a Letras*/
    $empresa=Empresa::first();
    $sum=0;
    $i=1;
    $regla=$cotizacion->tipo;
    $archivo=$name.'_'.$id.".pdf";
    $pdf=PDF::loadView('transaccion.venta.cotizacion.pdf2',compact('cotizacion','empresa','cotizacion_registro','regla','sum','igv','sub_total','banco','i','end','igv_p','banco_count'));
    $content = $pdf->download();
    $especif = $carbon_sp.$archivo;
    Storage::disk('mailbox')->put($especif,$content);
    $date = $carbon_sp;

    $id_usuario=auth()->user()->id;
    $correo_busqueda=EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
    $correo=$correo_busqueda->email;

    $firma=$correo_busqueda->firma;
    $mensaje_html = $request->get('mensaje');
            //CONDICIONAL DE FIRMA
    if($firma == null){
        $mensaje_con_firma ='<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script> $(document).ready(function(){ $("table").removeClass("table table-bordered").addClass("css"); }); </script>
        <style> .css,table,tr,td{ padding: 15px; border: 1px solid black; border-collapse: collapse; } table{ width:100%; }
        </style>'.$mensaje_html.'</body>';
    }else{
        $mensaje_con_firma ='<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>$(document).ready(function(){$("table").removeClass("table table-bordered").addClass("css");});</script>
        <style>.css,table,tr,td{padding: 15px; border: 1px solid black; border-collapse: collapse; }table{ width:100%;}
        </style>'.$mensaje_html.'</body><br/><footer><img name="firma" src=" '.url('/').'/archivos/imagenes/firmas/'.$firma.'" width="550px" height="auto" /></footer>';
    }
            /////////ENVIO DE CORREO/////// https://myaccount.google.com/u/0/lesssecureapps?pli=1 <--- VAINA DE AUTORIZACION PARA EL GMAIL
            $smtpAddress = $correo_busqueda->smtp; // = $request->smtp
            $port = $correo_busqueda->port;
            $encryption = $correo_busqueda->encryption;
            $yourEmail = $correo;
            $estado = '0';
            $yourPassword = $correo_busqueda->password;
            $sendto = $request->get('remitente') ;
            $titulo = "Envio de Factura Automatico";
            $mensaje = $mensaje_con_firma;
            $bakcup=    $correo_busqueda->email_backup ;

            //ARCHIVO PDF
            $pdf=$archivo;
            $pdfile = public_path().'/archivos/'.$especif;
            //DATOS DE ENVIO
            $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
            $mailer =new \Swift_Mailer($transport);
            $newfile = $request->file('archivos');
            if($request->hasfile('archivos')){
                foreach ($newfile as $file) {
                    $nombre =  $file->getClientOriginalName();
                    $especif = $carbon_sp.$nombre;
                    \Storage::disk('mailbox')->put( $especif ,  \File::get($file));

                    $news[] = public_path().'/archivos/'.$especif;
                    $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto,$bakcup])->setBody($mensaje, 'text/html');
                    $message->attach(\Swift_Attachment::fromPath($pdfile));
                    foreach ($news as $attachment) {
                        $message->attach(\Swift_Attachment::fromPath($attachment));
                    }
                }
            }else{
                $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto,$bakcup ])->setBody($mensaje, 'text/html');
                $message->attach(\Swift_Attachment::fromPath($pdfile));
            }
            if($mailer->send($message)){
                $mensaje =$request->get('mensaje') ;
                $texto= strip_tags($mensaje);
                $mail = new EmailBandejaEnvios;
                $mail->id_usuario =auth()->user()->id;
                $mail->destinatario =$correo;
                $mail->remitente =$request->get('remitente') ;
                $mail->asunto =$titulo;
                $mail->mensaje =$mensaje_con_firma;
                $mail->mensaje_sin_html =$texto ;
                $mail->estado= $estado;
                $mail->fecha_hora =Carbon::now() ;
                $mail-> save();

                $newfile2 = $request->file('archivos');
                if($request->hasfile('archivos')){
                    foreach ($newfile2 as $file2) {
                        $guardar_email_archivo=new EmailBandejaEnviosArchivos;
                        $guardar_email_archivo->id_bandeja_envios=$mail->id;
                        $guardar_email_archivo->archivo= $file2->getClientOriginalName();
                        $guardar_email_archivo->fecha_hora= $carbon_sp;
                        $guardar_email_archivo->save();
                    }
                }
                $archivo_pdf = new EmailBandejaEnviosArchivos;
                $archivo_pdf->id_bandeja_envios=$mail->id;
                $archivo_pdf->archivo=$pdf;
                $archivo_pdf->fecha_hora= $especif;
                $archivo_pdf->save();

                return redirect()->route('boleta.show',$boletear->id);
            }else{
                return "Something went wrong :(";
            }
        }else{
           return redirect()->route('boleta.show',$boletear->id);
       }
   }

   public function aprobar(Request $request, $id)
   {
    $cotizacion=Cotizacion::find($id);
    $cotizacion->estado_aprovar='1';
    if (!isset($cotizacion->aprobado_por)) {
        $cotizacion->aprobado_por=auth()->user()->id;
    }
    $cotizacion->save();
    return redirect()->route('cotizacion.index');
}

public function ticket_ajax_cotizacion(Request $request){
    $ids = $request->get('id');
    $cotizacion=Cotizacion::find($ids);
    if($cotizacion->tipo == "factura"){
        $tipo_coti = "FACTURA";
        $registro=Cotizacion_factura_registro::where('cotizacion_id',$ids)->get();
    }else{
        $tipo_coti = "BOLETA";
        $registro=Cotizacion_boleta_registro::where('cotizacion_id',$ids)->get();
    }

    $empresa=Empresa::first();
    $moneda = Moneda::where('id',$cotizacion->moneda_id)->first();
    $igv=Igv::first();

    $nombre_impresora = "EPSONTICKET";

    $connector = new WindowsPrintConnector($nombre_impresora);
    $printer = new Printer($connector);
        #Mando un numero de respuesta para saber que se conecto correctamente.
    echo 1;

         //EMPRESA
    $empresa=Empresa::first();
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->setEmphasis(true);
    $printer->text("COTIZACION ".$tipo_coti." ELECTRONICA\n");
    $printer->text($cotizacion->cod_cotizacion."\n");
    $printer->text("===============================\n");
    $printer->text($cotizacion->created_at."\n");
    $printer->text($empresa->nombre."\n");
    $printer->setEmphasis(true);
    $printer->text("RUC: ".$empresa->ruc."\n");
        // $printer->setEmphasis(false);
    $printer->text($empresa->calle." - ".$empresa->ciudad." - ".$empresa->region_provincia."\n");
    $printer->text("Telefono: ".$empresa->telefono);
    $printer->setEmphasis(false);
    $printer->text("\n===============================\n");

        //Cliente
    $cliente_dato = sprintf('%-15.15s %-2.2s %-21.21s', "Cliente", ':', $cotizacion->cliente->nombre);
    $printer->text($cliente_dato."\n");
    $cliente_id= sprintf('%-15.20s %-2.2s %-21.21s', $cotizacion->cliente->documento_identificacion, ':', $cotizacion->cliente->numero_documento);
    $printer->text($cliente_id);
    $printer->text("\n===============================\n");

        //Productos
    $leyenda = sprintf('%-14.14s %6.6s %8.8s  %8.8s', 'Producto', 'Cant.', 'P.Unit', 'Total');

    $printer->text( $leyenda);
    $printer->text("\n");
    foreach($registro as $data_regs){
            // $printer -> selectPrintMode(Printer::MODE_UNDERLINE);
        $subtotal = ($data_regs->precio_unitario_comi * $data_regs->cantidad);
            // %-4.2s $facturacion->moneda->simbolo,
        $line = sprintf('%-14.14s %6.0d %8.2F %8.2F', $data_regs->producto->nombre, $data_regs->cantidad, $data_regs->precio_unitario_comi, $subtotal);
            // $printer->setJustification(Printer::JUSTIFY_LEFT);
            // $printer->text( ("%.2fx%s\n", , ));
            // $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text( $line);
        $printer->text("\n");
            // $printer -> selectPrintMode();
            // $total += $subtotal;
    }

    $sub_total=($cotizacion->op_gravada)+($cotizacion->op_inafecta)+($cotizacion->op_exonerada);
    $sub_total_gravado=($cotizacion->op_gravada);

    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text("\n===============================\n");
    $printer->setJustification(Printer::JUSTIFY_RIGHT);

    if($cotizacion->tipo == "factura"){
        $igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100;
        $end=round($sub_total, 2)+round($igv_p, 2);

        $subtotal = sprintf('%20.20s %-2.2s %15.2F', "SUBTOTAL ".$moneda->simbolo, " : ", $sub_total);
        $printer->text($subtotal."\n");
        $op_gravada = sprintf('%20.20s %-2.2s %15.2F', "OP. Gravada ".$moneda->simbolo, " : ", $cotizacion->op_gravada);
        $printer->text($op_gravada."\n");
        $op_inafecta = sprintf('%20.20s %-2.2s %15.2F', "OP. Inafecta ".$moneda->simbolo, " : ", $cotizacion->op_inafecta);
        $printer->text($op_inafecta."\n");
        $op_exonerada = sprintf('%20.20s %-2.2s %15.2F', "OP. Exonerada ".$moneda->simbolo, " : ", $cotizacion->op_exonerada);
        $printer->text($op_exonerada."\n");
        $igv = sprintf('%20.20s %-2.2s %15.2F', "I.G.V ".$moneda->simbolo, " : ", $igv_p);
        $printer->text($igv."\n");
        $printer->setEmphasis(true);
        $total = sprintf('%20.20s %-2.2s %15.2F', "TOTAL ".$moneda->simbolo, " : ", $end);
        $printer->text($total."\n");
        $printer->setEmphasis(false);
    }else{
        $end=round($sub_total, 2);

        $subtotal = sprintf('%20.20s %-2.2s %15.2F', "SUBTOTAL ".$moneda->simbolo, " : ", $sub_total);
        $printer->text($subtotal."\n");
        $igv = sprintf('%20.20s %-2.2s %15.2F', "I.G.V ".$moneda->simbolo, " : ", "0.00");
        $printer->text($igv."\n");
        $total = sprintf('%20.20s %-2.2s %15.2F', "TOTAL ".$moneda->simbolo, " : ", $end);
        $printer->text($total."\n");
        $printer->setEmphasis(false);
    }
    $end = $end;

        //NUMEROS A LETRAS
    $formatter = new NumeroALetras();
    $num_let = $formatter->toInvoice($end);
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text("Son: ".$num_let." ".$moneda->nombre."\n");

    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text("\n===============================\n");
    $printer->text("Atendido por: ".$cotizacion->user_personal->name."\n");
    $printer->text("Autorizado mediante resolucion\n");
    $printer->text("N° RS 018-005-0002243/SUNAT\n");
    $printer->text("Representación impresa de la \n");
    $printer->text("Boleta de Venta Electronica\n");
    $printer->text("Para consultar el documento\n");
    $printer->text("Ingrese a:\n");
    $printer->text("https://ww2.todasmisfacturas.com.pe\n");
        // $printer->text("Muchas gracias por su compra\n");
    /*Alimentamos el papel 3 veces*/
    $printer->feed(3);

        /*
            Cortamos el papel. Si nuestra impresora
            no tiene soporte para ello, no generará
            ningún error
        */
            $printer->cut();

        /*
            Por medio de la impresora mandamos un pulso.
            Esto es útil cuando la tenemos conectada
            por ejemplo a un cajón
        */
            $printer->pulse();

        /*
            Para imprimir realmente, tenemos que "cerrar"
            la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
        */
            $printer->close();
        }

    }