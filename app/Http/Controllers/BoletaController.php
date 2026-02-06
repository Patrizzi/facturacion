<?php

namespace App\Http\Controllers;

use App\Banco;
use App\Boleta;
use App\Boleta_registro;
use App\Cliente;
use App\Cotizacion;
use App\Cotizacion_boleta_registro;
use App\Cotizacion_factura_registro;
use App\Empresa;
use App\Facturacion;
use App\Forma_pago;
use App\Igv;
use App\Marcas;
use App\Moneda;
use App\Cuotas_credito;
use App\Personal;
use App\Personal_venta;
use App\Producto;
use App\Servicios;
use App\Unidad_medida;
use App\User;
use App\Ventas_registro;
use App\Kardex_entrada;
use App\kardex_entrada_registro;
use App\TipoCambio;
use App\Tipo_operacion_f;
use App\Stock_almacen;
use App\Stock_producto;
use Carbon\Carbon;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Almacen;
use App\Codigo_guia_almacen;
use App\Nota_Credito;
use App\Nota_Debito;
use Illuminate\Http\Request;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Luecano\NumeroALetras\NumeroALetras;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\EmailConfiguraciones;
use App\EmailBandejaEnviosArchivos;
use App\EmailBandejaEnvios;
use App\Exports\BoletasExport;

class BoletaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        // $existe_id=kardex_entrada::where('estado',2)->first();
        // if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

        $boletas=Boleta::all();
        if(count($boletas) == 0){
            $nota_credito[0] = null;
            $nota_debito[0] = null;
        }else{
            foreach ($boletas as $key => $boleta) {
                $nota_credito[$key] = Nota_Credito::where('boleta_id', $boleta->id)->first();
                $nota_debito[$key] = Nota_Debito::where('boleta_id', $boleta->id)->first();
                if (!isset($nota_credito[$key])) {
                    $nota_credito[$key] = null;
                }
                if (!isset($nota_debito[$key])) {
                    $nota_debito[$key] = null;
                }
            }
        }
        // return $nota_credito;
        $boletas_enviadas=Boleta::where('b_electronica',1)->get();
        $user_login =auth()->user();
        $conteo_almacen=Almacen::where('estado',0)->count();
        $almacen=Almacen::where('estado',0)->get();
        $almacen_primero=Almacen::where('estado',0)->first();
        $igv = Igv::first();
        return view('transaccion.venta.boleta.index', compact('boletas','boletas_enviadas','user_login','conteo_almacen','almacen','almacen_primero','igv','nota_credito','nota_debito'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $inventario_inicial=Kardex_entrada::first();
        // if (isset($inventario_inicial)) {
        //     if ( $inventario_inicial->estado==1) {
        //         return redirect()->route('kardex-entrada.show',$inventario_inicial->id);
        //     }
        // }

        // $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();
        //validar almacen con prodcutos vacios
        $almacen_p=$request->get('almacen');
        $sucursal = Almacen::where('id',$almacen_p)->first();
        $inventario_inicial=Kardex_entrada::count();
        $servicios = Servicios::count();
        if($inventario_inicial == 0 && $servicios == 0){
            return back()->withErrors(['No hay Productos o Servicios Agregados: '.$sucursal->nombre.'']);
        }



        $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen_p)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen_p)->count();


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

        // if(!isset($prod)){
        //     return redirect()->route('boleta.index')->with('repite', 'No hay productos en el almacen seleccionado');
        // }

        // $lista=array_values(array_unique($prod));
        // $lista_count=count($lista);

        // for($x=0;$x<$lista_count;$x++){
        //  $validacion[$x]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
        //  if(!$validacion[$x]==NULL){
        //     $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
        // }
            // $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
    // }

    $moneda=Moneda::where('principal','1')->first();

    $igv=Igv::where('id','1')->first();

    // $tipo_cambio=TipoCambio::latest('created_at')->first();
    // if ($moneda->tipo == 'nacional') {
    //     foreach ($productos as $index => $producto) {
    //         $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
    //         $igv_p[]=(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad[$index]);

    //         $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad[$index]),2);
    //         $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen_p)->sum('stock');
    //         $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional'),2);
    //     }
    // }else{
    //     foreach ($productos as $index => $producto) {
    //         $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
    //         $igv_p[]=(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad[$index]);
    //         $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad[$index]),2);
    //         $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen_p)->sum('stock');
    //         $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero'),2);
    //     }
    // }
    $servicios=Servicios::where('estado_anular',0)->get();
    $igv_proceso=Igv::first();
    $igv_total=$igv_proceso->igv_total;

    // if($moneda->tipo =='nacional'){
    //     foreach ($servicios as $index2 => $servicio) {
    //         $utilidad2[]=$servicio->precio_nacional*($servicio->utilidad)/100;
    //         $igv_precio[]=$servicio->precio_nacional;
    //         $igv2[]=$igv_precio[$index2]*$igv_total/100;
    //         $array2[]=round(($servicio->precio_nacional+$utilidad2[$index2]),2);

    //     }
    // }else{
    //     foreach ($servicios as $index2 => $servicio) {
    //         $utilidad2[]=$servicio->precio_extranjero*($servicio->utilidad)/100;
    //         $igv_precio[]=$servicio->precio_extranjero;
    //         $igv2[]=$igv_precio[$index2]*$igv_total/100;
    //         $array2[]=round($servicio->precio_extranjero+$utilidad2[$index2],2);

    //     }
    // }
    $forma_pagos=Forma_pago::all();
    $clientes=Cliente::where('documento_identificacion', '!=' ,'ruc')->where('documento_identificacion', '!=' ,'RUC')->get();
    $moneda=Moneda::where('principal','1')->first();
    $personales=Personal::all();
    $p_venta=Personal_venta::where('estado','0')->get();
    $tipo_operacion = Tipo_operacion_f::all();
    $empresa=Empresa::first();

        // obtencion de la sucursal
    $almacen=$request->get('almacen');
        //obtencion del almacen
    $sucursal=Almacen::where('id', $almacen)->first();
    $cod_guias = Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
    $boleta_cod_fac=$cod_guias->cod_boleta;
    if (is_numeric($boleta_cod_fac)) {
            // exprecion del numero de fatura
        $boleta_cod_fac++;
        $sucursal_nr = str_pad($cod_guias->serie_boleta, 3, "0", STR_PAD_LEFT);
        $boleta_nr=str_pad($boleta_cod_fac, 8, "0", STR_PAD_LEFT);
    }else{
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
        $ultima_boleta=Boleta::where('almacen_id',$sucursal->id)->latest()->first();
        $boleta_num=$ultima_boleta->codigo_boleta;
        $boleta_num_string_porcion= explode("-", $boleta_num);
        $boleta_num_string=$boleta_num_string_porcion[1];
        $boleta_num=(int)$boleta_num_string;
            //CONDICIONAL PARA SERIE BOLETA
        $almacen_codigo = Codigo_guia_almacen::orderBy('serie_boleta','DESC')->latest()->first();
        if($boleta_num == 99999999){
            $ultima_boleta = $almacen_codigo->serie_boleta+1;
            $boleta_num = 00000000;
        }else{
            $ultima_boleta = $cod_guias->serie_boleta;
        }
        $boleta_num++;
        $sucursal_nr = str_pad($ultima_boleta, 3, "0", STR_PAD_LEFT);
        $boleta_nr=str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
    }
    $boleta_numero="B".$sucursal_nr."-".$boleta_nr;

    $fecha_hoy = Carbon::now()->add(1,'day');;
    $fecha_1 = $fecha_hoy->format('Y-m-d');
    return view('transaccion.venta.boleta.create',compact('forma_pagos','clientes','personales','igv','moneda','p_venta','empresa','sucursal','boleta_numero','tipo_operacion','fecha_1'));

}

public function create_ms(Request $request)
{
    $inventario_inicial=Kardex_entrada::first();
    if (isset($inventario_inicial)) {
        if ( $inventario_inicial->estado==1) {
            return redirect()->route('kardex-entrada.show',$inventario_inicial->id);
        }
    }

    $almacen_p=$request->get('almacen');
    $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen_p)->get();
    $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen_p)->count();


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
        //validar almacen con prodcutos vacios
    if(!isset($prod)){
        return redirect()->route('boleta.index')->with('repite', 'No hay productos en el almacen seleccionado');
    }

    $lista=array_values(array_unique($prod));
    $lista_count=count($lista);

    for($x=0;$x<$lista_count;$x++){
     $validacion[$x]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
     if(!$validacion[$x]==NULL){
        $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
    }
            // $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
}
$moneda=Moneda::where('principal','0')->first();
$igv=Igv::first();
$tipo_cambio=TipoCambio::latest('created_at')->first();
if ($moneda->tipo == 'extranjera') {
    foreach ($productos as $index => $producto) {
        $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
        $igv_p[]=(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad[$index]);
        $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad[$index])/$tipo_cambio->paralelo,2);
        $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen_p)->sum('stock');
        $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')/$tipo_cambio->paralelo,2);
    }
}else{
    foreach ($productos as $index => $producto) {
        $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
        $igv_p[]=(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad[$index]);
        $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad[$index])*$tipo_cambio->paralelo,2);
        $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen_p)->sum('stock');
        $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*$tipo_cambio->paralelo,2);
    }
}
        //servicio
$servicios=Servicios::where('estado_anular',0)->get();
$igv=Igv::where('id','1')->first();
$igv_proceso=Igv::first();
$igv_total=$igv_proceso->igv_total;

if($moneda->tipo =='nacional'){
    foreach ($servicios as $index2 => $servicio) {
        $utilidad2[]=$servicio->precio_nacional*($servicio->utilidad)/100;
        $igv_precio[]=$servicio->precio_nacional;
        $igv2[]=$igv_precio[$index2]*$igv_total/100;
        $array2[]=round(($servicio->precio_nacional+$utilidad2[$index2]),2);

    }
}else{
    foreach ($servicios as $index2 => $servicio) {
        $utilidad2[]=$servicio->precio_extranjero*($servicio->utilidad)/100;
        $igv_precio[]=$servicio->precio_extranjero;
        $igv2[]=$igv_precio[$index2]*$igv_total/100;
        $array2[]=round($servicio->precio_extranjero+$utilidad2[$index2],2);

    }
}
$forma_pagos=Forma_pago::all();
$clientes=Cliente::where('documento_identificacion', '!=' ,'ruc')->where('documento_identificacion', '!=' ,'RUC')->get();

$personales=Personal::all();
$p_venta=Personal_venta::where('estado','0')->get();
$tipo_operacion = Tipo_operacion_f::all();

$empresa=Empresa::first();

        // obtencion de la sucursal
$almacen=$request->get('almacen');
        //obtencion del almacen
$sucursal=Almacen::where('id', $almacen)->first();
$cod_guias = Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
$boleta_cod_fac=$cod_guias->cod_boleta;
if (is_numeric($boleta_cod_fac)) {
            // exprecion del numero de fatura
    $boleta_cod_fac++;
    $sucursal_nr = str_pad($cod_guias->serie_boleta, 3, "0", STR_PAD_LEFT);
    $boleta_nr=str_pad($boleta_cod_fac, 8, "0", STR_PAD_LEFT);
}else{
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
    $ultima_factura=Boleta::where('almacen_id',$sucursal->id)->latest()->first();
    $boleta_num=$ultima_factura->codigo_boleta;
    $boleta_num_string_porcion= explode("-", $boleta_num);
    $boleta_num_string=$boleta_num_string_porcion[1];
    $boleta_num=(int)$boleta_num_string;
            //CONDICIONAL PARA SERIE BOLETA
    $almacen_codigo = Codigo_guia_almacen::orderBy('serie_boleta','DESC')->latest()->first();
    if($boleta_num == 99999999){
        $ultima_boleta = $almacen_codigo->serie_boleta+1;
        $boleta_num = 00000000;
    }else{
        $ultima_boleta = $cod_guias->serie_boleta;
    }
    $boleta_num++;
    $sucursal_nr = str_pad($ultima_boleta, 3, "0", STR_PAD_LEFT);
    $boleta_nr=str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
}
$boleta_numero="B".$sucursal_nr."-".$boleta_nr;

return view('transaccion.venta.boleta.create_ms',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','boleta_numero','sucursal','tipo_operacion','servicios','array2','igv_precio'));

}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id_moneda)
    {
        // $nuevafechas = Carbon::createFromFormat('d/m/Y', $request->fecha_vencimiento);
        // return $request;
        $print=$request->get('print');

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
        //                 return redirect()->route('boleta.create')->with('repite', 'Datos repetidos - No permitidos!');
        //             }
        //         }

        //     }
        // }
        // Comisionista cobnvertir id

        $comisionista = $request->get('comisionista');
        if($comisionista == "" || $comisionista == "Sin Comisión - 0 %"){
           $comi = 0;
        }else{

            // $numero = $request->get('comisionista');
            $numero = strstr($comisionista, '-',true);
            // return $numero;
            // return $numero;
            // $numero_doc=personal::where('numero_documento',$numero)->first();
            // $id_personal=$numero_doc->id;

            $comisionista_buscador=Personal_venta::where('cod_vendedor',$numero)->first();
            // return $comisionista_buscador;
            // $id_personal=$cod_vendedor->id;

            // $comisionista_buscador=Personal_venta::where('id',$id_personal)->first();
            //Comision segun comisionista
            // $personal_venta=Personal_venta::where('id_personal',$comisionista_buscador->id)->first();
            $comi=$comisionista_buscador->comision;
            $comision_id = $comisionista_buscador->id;

        }



        //Convertir nombre del cliente a id
        $cliente_nombre=$request->get('cliente');
        // $nombre = strstr($cliente_nombre, '-',true);

        $cliente_buscador=Cliente::where('id',$cliente_nombre)->first();
        // return $cliente_buscador->id;
        $forma_pago_id = $request->get('forma_pago');
        //fecha de vencimiento
        if($forma_pago_id == 1){
            $val = $request->get('fecha_vencimiento');
            // $nuevafechas = Carbon::createFromFormat('d/m/Y', $val);
            // return $nuevafechas->format('d-m-Y');
            $nuevafechas = date('d-m-Y', strtotime(($val)));
        }else{
            $fecha_pago_forma = $request->input('fecha_pago');
            $contador_for_1 = count($fecha_pago_forma);
            for($c = 0; $c<$contador_for_1;$c++ ){
                $val = $fecha_pago_forma[$c];
            }
            $nuevafechas = date('d-m-Y', strtotime(($val)));
        }




        //buscador al cambio
        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }

        // obtencion de la sucursal
        $almacen=$request->get('almacen');
        //obtencion del almacen
        $sucursal=Almacen::where('id', $almacen)->first();
        $cod_guias = Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
        $boleta_cod_fac=$cod_guias->cod_boleta;
        if (is_numeric($boleta_cod_fac)) {
            // exprecion del numero de fatura
            $boleta_cod_fac++;
            $sucursal_nr = str_pad($cod_guias->serie_boleta, 3, "0", STR_PAD_LEFT);
            $boleta_nr=str_pad($boleta_cod_fac, 8, "0", STR_PAD_LEFT);
        }else{
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
            $ultima_boleta=Boleta::where('almacen_id',$sucursal->id)->latest()->first();
            $boleta_num=$ultima_boleta->codigo_boleta;
            $boleta_num_string_porcion= explode("-", $boleta_num);
            $boleta_num_string=$boleta_num_string_porcion[1];
            $boleta_num=(int)$boleta_num_string;
            //CONDICIONAL PARA SERIE BOLETA
            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_boleta','DESC')->latest()->first();
            if($boleta_num == 99999999){
                $ultima_boleta = $almacen_codigo->serie_boleta+1;
                $almacen_save_last = Codigo_guia_almacen::find($cod_guias->id);
                $almacen_save_last->serie_boleta = $almacen_codigo->serie_boleta+1;
                $almacen_save_last->save();
                $boleta_num = 00000000;
            }else{
                $ultima_boleta = $cod_guias->serie_boleta;
            }
            $boleta_num++;
            $sucursal_nr = str_pad($ultima_boleta, 3, "0", STR_PAD_LEFT);
            $boleta_nr=str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
        }
        $boleta_numero="B".$sucursal_nr."-".$boleta_nr;


        //calculo para el stock del producto
        $almacen_producto_validacion=$request->get('almacen');
        for($i=0;$i<$count_articulo;$i++){
            $producto_servicio = Producto::where('codigo_producto',$producto_id[$i])->first();
            if(isset($producto_servicio->id)){
                $kardex_entrada_v=Kardex_entrada::where('almacen_id',$almacen_producto_validacion)->get();
                $kardex_entrada_count_v=Kardex_entrada::where('almacen_id',$almacen_producto_validacion)->count();

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
                $cantidad_entrada=$request->get('cantidad')[$i];
                if($cantidad_v<$cantidad_entrada){
                 return "cantidad mayor al stock";
             }
         }else{

         }

     }
    $nombre_moneda = $request->get('moneda');
    $id_moneda = Moneda::where('nombre', $nombre_moneda)->first();
    //  return $nombre_moneda;
        // return $request->get('cantidad');
     $tipo_cambio=TipoCambio::latest('created_at')->first();
        // CODIGO PARA BUSCAR EL ID DEL TIPO DE DOCUMENTO
     $operacion=$request->get('tipo_operacion');
     $nombre = strstr($operacion, '-',true);
     $busca_ope=Tipo_operacion_f::where('codigo',$nombre)->first();
     $boleta=new Boleta;
     $boleta->codigo_boleta=$boleta_numero;
     $boleta->almacen_id =$request->get('almacen');
     $boleta->orden_compra=$request->get('orden_compra');
     $boleta->guia_remision=$request->get('guia_r');
     $boleta->cliente_id=$cliente_buscador->id;
     $boleta->moneda_id=$id_moneda->id;
     $boleta->forma_pago_id=$request->get('forma_pago');
     $boleta->fecha_emision=$request->get('fecha_emision');
     $boleta->fecha_vencimiento=$nuevafechas;
     $boleta->cambio=$cambio->paralelo;
     $boleta->observacion=$request->get('observacion');
    //  if($comisionista != "" || $comisionista != "Sin Comisión - 0 %"){
        $boleta->comisionista= $comisionista_buscador->id ?? null;
    // }
    $boleta->user_id =auth()->user()->id;
    $boleta->estado='0';
    $boleta->tipo='producto';
    $boleta->tipo_documento_id = 3;
    $boleta->tipo_operacion_id = $busca_ope->id;
    $boleta->save();

    if($boleta->forma_pago_id == 2){

        $fecha_pago = $request->input('fecha_pago');
        $contador_for = count($fecha_pago);
        $monto_pago = $request->input('monto_pago');
            // foreach($contador_for as $cuotas => $index ){
        for($c = 0; $c<$contador_for;$c++ ){
            $cuota_cred = new Cuotas_credito;
            $cuota_cred->boleta_id = $boleta->id;
            $cuota_cred->numero_cuota = $c+1;
            $cuota_cred->monto = $monto_pago[$c];
            $cuota_cred->fecha_pago = $fecha_pago[$c];
            $cuota_cred->save();
        }
    }
    $total_comi=$request->get('total_comi');

    $igv = Igv::first();
    if(isset($comision_id)){
        $comisionista_porcentaje=Personal_venta::where('id',$comision_id)->first();
        $comisionista=new Ventas_registro;
        $comisionista->comisionista=$comision_id;
        $comisionista->tipo_moneda=$id_moneda->id;
        $comisionista->estado_aprobado='0';
        $comisionista->estado_pagado='0';
        $comisionista->estado_anular_fac_bol='0';
        $comisionista->monto_final_fac_bol=$total_comi;
        $porcentaje_igv=100+$igv->igv_total;
        $porcentaje=100+$comisionista_porcentaje->comision;
        $comisionista->monto_comision=((100*$total_comi/$porcentaje_igv)*100/$porcentaje)*$comisionista_porcentaje->comision/100;
            // $comisionista->id_coti_produc=$cotizador;
        $comisionista->id_bol=$boleta->id;
        $comisionista->observacion='Boleta';
        $comisionista->save();
    }
        // modificacion para que se cierre el codigo en almacen
        // obtencion de la sucursal
        // $sucursal=auth()->user()->almacen->serie_boleta;
        //obtencion del almacen
    $boleta_primera=Codigo_guia_almacen::where('almacen_id', $sucursal->id)->first();
    if(is_numeric($boleta_primera->cod_boleta)){
        $boleta_primera->cod_boleta='NN';
        $boleta_primera->save();
    }



        //contador de valores de cantidad
    $cantidad = $request->input('cantidad');
    $count_cantidad=count($cantidad);

        //contador de valores del check descuento
    $check = $request->input('check_descuento');
    $count_check=count($check);



    $moneda=Moneda::where('principal',1)->first();
    $moneda_registrada=$boleta->moneda_id;

    if($count_articulo = $count_cantidad  = $count_check){
        for($i=0;$i<$count_articulo;$i++){
            $producto_servicio = Producto::where('codigo_producto',$producto_id[$i])->first();
            if(isset($producto_servicio)){

                $boleta_registro=new Boleta_registro;
                $boleta_registro->boleta_id=$boleta->id;
                $boleta_registro->producto_id=$producto_servicio->id;
                $boleta_registro->numero_serie=$request->get('numero_serie')[$i];
                if($request->get('descripcion_item')[$i] == null){
                    $boleta_registro->descripcion_item = null;
                }else{
                    $boleta_registro->descripcion_item = $request->get('descripcion_item')[$i];
                }

                //producto
                $producto=Producto::where('id',$producto_servicio->id)->where('estado_id',1)->where('estado_anular',1)->first();

                //stock --------------------------------------------------------
                $stock=Stock_almacen::where('producto_id',$producto_servicio->id)->sum('stock');
                $boleta_registro->stock=$stock;
                // precio
                if($moneda->id == $moneda_registrada){
                    if ($moneda->tipo == 'nacional'){
                        //promedio original revisar que es  promedio nacional--------------------------------------------------------
                        $array2=Stock_producto::where('producto_id',$producto_servicio->id)->avg('precio_nacional');
                        $boleta_registro->promedio_original=$array2;

                        $utilidad=Stock_producto::where('producto_id',$producto_servicio->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                        $igv_p=(Stock_producto::where('producto_id',$producto_servicio->id)->avg('precio_nacional')+$utilidad);
                        $array=(Stock_producto::where('producto_id',$producto_servicio->id)->avg('precio_nacional')+$utilidad);
                        $boleta_registro->precio=$array;
                    }else{
                        //promedio original revisar que es  promedio nacional--------------------------------------------------------
                        $array2=Stock_producto::where('producto_id',$producto_servicio->id)->avg('precio_extranjero');
                        $boleta_registro->promedio_original=$array2;

                        $utilidad=Stock_producto::where('producto_id',$producto_servicio->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                        $igv_p=(Stock_producto::where('producto_id',$producto_servicio->id)->avg('precio_extranjero')+$utilidad);
                        $array=(Stock_producto::where('producto_id',$producto_servicio->id)->avg('precio_extranjero')+$utilidad);
                        $boleta_registro->precio=$array;
                    }
                }else{
                    if ($moneda->tipo == 'extranjera'){
                        //promedio original revisar que es  promedio nacional--------------------------------------------------------
                        $array2=round(Stock_producto::where('producto_id',$producto_servicio->id)->avg('precio_extranjero')*$cambio->paralelo,2);
                        $boleta_registro->promedio_original=$array2;

                        $utilidad=Stock_producto::where('producto_id',$producto_servicio->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                        $igv_p=(Stock_producto::where('producto_id',$producto_servicio->id)->avg('precio_extranjero')+$utilidad);
                        $array=round((Stock_producto::where('producto_id',$producto_servicio->id)->avg('precio_extranjero'))*$cambio->paralelo+$utilidad,2);
                        $boleta_registro->precio=$array;
                    }else{
                        //promedio original revisar que es  promedio nacional--------------------------------------------------------
                        $array2=round(Stock_producto::where('producto_id',$producto_servicio->id)->avg('precio_nacional')/$cambio->paralelo,2);
                        $boleta_registro->promedio_original=$array2;

                        $utilidad=Stock_producto::where('producto_id',$producto_servicio->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                        $igv_p=(Stock_producto::where('producto_id',$producto_servicio->id)->avg('precio_nacional')+$utilidad);
                        $array=round((Stock_producto::where('producto_id',$producto_servicio->id)->avg('precio_nacional')+$utilidad)/$cambio->paralelo,2);
                        $boleta_registro->precio=$array;
                    }
                }

                $boleta_registro->cantidad=$request->get('cantidad')[$i];
                $boleta_registro->descuento=$request->get('check_descuento')[$i];
                $boleta_registro->comision=$comi;
                    //precio unitario descuento ----------------------------------------
                $desc_comprobacion=$request->get('check_descuento')[$i];
                if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                    $igv=Igv::first();
                    $igv_ac = 0;
                }else{
                    $igv_ac = 0;
                }

                if($desc_comprobacion <> 0){
                    $precio_uni = $array - ($array2*$desc_comprobacion/100);
                    $boleta_registro->precio_unitario_desc=$precio_uni+($precio_uni*($igv_ac/100));
                    // return $array*($igv->igv_total/100);
                }else{
                    $boleta_registro->precio_unitario_desc=$array+($array*($igv_ac/100));
                    // return $array_pre_prom;
                }
                    //precio unitario comision ----------------------------------------
                if($desc_comprobacion <> 0){
                   $precio_uni = $array - ($array2*$desc_comprobacion/100);
                   $precio_comi = $precio_uni+($precio_uni*($comi/100));
                   $boleta_registro->precio_unitario_comi=round($precio_comi+($precio_comi*($igv_ac/100)),2);
               }else{
                $precio_comi = $array+($array*($comi/100));
                $boleta_registro->precio_unitario_comi=round(($precio_comi)+($precio_comi*($igv_ac/100)),2);
            }
             //TIPO DE AFECTACION
            $boleta_2=Boleta::find($boleta->id);
            if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                $boleta_2->op_gravada += ($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad);
            }
            if(strpos($producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                $boleta_2->op_exonerada += ($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad);
            }
            if(strpos($producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                $boleta_2->op_inafecta += ($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad);
            }
            $boleta_2->save();
            $boleta_registro->save();
                // return $array;

            $almacen=$boleta->almacen_id;
            $nueva=Kardex_entrada_registro::where('producto_id',$boleta_registro->producto_id)->where('almacen_id',$almacen)->where('estado',1)->get();

            $comparacion=$nueva;
                //buble para la cantidad
            $cantidad=0;
            foreach($comparacion as $comparaciones){
                $cantidad=$comparaciones->cantidad+$cantidad;
            }
            if(isset($comparacion)){
                $var_cantidad_entrada=$boleta_registro->cantidad;
                $contador=0;
                foreach ($comparacion as $p) {
                    if($p->cantidad>$var_cantidad_entrada){
                        $cantidad_mayor=$p->cantidad;
                        $cantidad_final=$cantidad_mayor-$var_cantidad_entrada;
                        $p->cantidad=$cantidad_final;
                        if($cantidad_final==0){
                            $p->estado=0;
                            $p->save();
                            break;
                        }else{
                            $p->save();
                            break;
                        }
                    }elseif($p->cantidad==$var_cantidad_entrada){
                        $p->cantidad=0;
                        $p->estado=0;
                        $p->save();
                        break;
                    }
                    else{
                        $var_cantidad_entrada=$var_cantidad_entrada-$p->cantidad;
                        $p->cantidad=0;
                        $p->estado=0;
                        $p->save();
                    }
                }
            }
            Stock_almacen::egreso($boleta->almacen_id,$producto_servicio->id,$boleta_registro->cantidad);
                    //resta de cantidades de productos para la tabla stock productos
            $stock_productos=Stock_producto::where('producto_id',$boleta_registro->producto_id)->first();
            $stock_productos->stock=$stock_productos->stock-$boleta_registro->cantidad;
            $stock_productos->save();
        }else{
            $servicio=Servicios::where('codigo_servicio',$producto_id[$i])->where('estado_anular',0)->first();

            $boleta_registro=new Boleta_registro();
            $boleta_registro->boleta_id=$boleta->id;
            $boleta_registro->servicio_id=$servicio->id;
            if($request->get('descripcion_item')[$i] == null){
                $boleta_registro->descripcion_item = null;
            }else{
                $boleta_registro->descripcion_item = $request->get('descripcion_item')[$i];
            }

                    //Precio -----------------------------------------------------------------------------------------
            if($moneda->id == $moneda_registrada){
                if ($moneda->tipo == 'nacional'){
                    $utilidad=$servicio->precio_nacional*($servicio->utilidad)/100;
                    $pre_prome=$servicio->precio_nacional;
                    $boleta_registro->promedio_original=$pre_prome;
                            // $igv=$igv_precio*$igv_total/100;
                    $array_bol=$servicio->precio_nacional+$utilidad;
                    $boleta_registro->precio=$array_bol;
                            // return 1;
                }else{
                    $utilidad=$servicio->precio_extranjero*($servicio->utilidad)/100;
                    $pre_prome=$servicio->precio_extranjero;
                    $boleta_registro->promedio_original=$pre_prome;
                            // $igv=$igv_precio*$igv_total/100;
                    $array_bol=$servicio->precio_extranjero+$utilidad;
                    $boleta_registro->precio=$array_bol;
                            // return 2;
                }
            }else{
                if ($moneda->tipo == 'extranjera'){
                    $utilidad=$servicio->precio_extranjero*($servicio->utilidad)/100;
                    $pre_prome=round(($servicio->precio_extranjero+$utilidad)*$tipo_cambio->paralelo,2);
                    $boleta_registro->promedio_original=$pre_prome;
                            // $igv=$igv_precio*$igv_total/100;
                    $array_bol=round(($servicio->precio_extranjero+$utilidad)*$tipo_cambio->paralelo,2);
                    $boleta_registro->precio=$array_bol;
                            // return 3;

                }else{

                    $utilidad=$servicio->precio_nacional*($servicio->utilidad)/100;
                    $pre_prome=round($servicio->precio_nacional/$tipo_cambio->paralelo,2);
                    $boleta_registro->promedio_original=$pre_prome;
                            // $igv=$igv_precio*$igv_total/100;
                    $array_bol=round((($servicio->precio_nacional+$utilidad)/$tipo_cambio->paralelo),2);
                    $boleta_registro->precio=$array_bol;
                            // return 4;

                }
            }
            $boleta_registro->cantidad=$request->get('cantidad')[$i];
            $boleta_registro->descuento=$request->get('check_descuento')[$i];
            $boleta_registro->comision=$comi;
                    //precio unitario descuento ----------------------------------------
            $desc_comprobacion=$request->get('check_descuento')[$i];

            if(strpos($servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                $igv=Igv::first();
                $igv_ac = 0;
            }else{
                $igv_ac = 0;
            }

            if($desc_comprobacion <> 0){
                $precio_uni = $array_bol - ($pre_prome*$desc_comprobacion/100);
                $boleta_registro->precio_unitario_desc=$precio_uni+($precio_uni*($igv_ac/100));
                    // return $array*($igv->igv_total/100);
            }else{
                $precio_uni = $array_bol + ($array_bol*($igv_ac/100));
                $boleta_registro->precio_unitario_desc=$precio_uni;
                    // return $array_pre_prom;
            }
                // return $precio_uni;
                    //precio unitario comision ----------------------------------------
            if($desc_comprobacion <> 0){
             $precio_uni = $array_bol - ($pre_prome*$desc_comprobacion/100);
             $precio_comi = $precio_uni+($precio_uni*($comi/100));
             $boleta_registro->precio_unitario_comi=round($precio_comi+($precio_comi*($igv_ac/100)),2);
         }else{
            $precio_comi = $array_bol+($array_bol*($comi/100));
            $boleta_registro->precio_unitario_comi=round(($precio_comi)+($precio_comi*($igv_ac/100)),2);
        }
                     //TIPO DE AFECTACION
        $cotizacion_2=Boleta::find($boleta->id);
        if(strpos($servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
            $cotizacion_2->op_gravada += ($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad);
        }
        if(strpos($servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
            $cotizacion_2->op_exonerada += ($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad);
        }
        if(strpos($servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
            $cotizacion_2->op_inafecta += ($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad);
        }
        $cotizacion_2->save();

        $boleta_registro->save();
    }
}
if($boleta->forma_pago_id == 2){
    Boleta::revision_cuotas($boleta->id);
}
Kardex_entrada_registro::stock_producto_precio();
}else {
    return redirect()->route('boleta.create')->with('campo', 'Falto introducir un campo de la tabla productos');
}
return redirect()->route('boleta.show',$boleta->id);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        $existe_id=Boleta::where('id',$id)->first();
        if(empty($existe_id)){ return redirect()->route('boleta.index'); }
        $boleta=Boleta::find($id);
        $boleta_registro=Boleta_registro::where('boleta_id',$id)->get();
        //validar almacen con prodcutos vacios
        $inventario_inicial=Kardex_entrada::count();
        $servicios = Servicios::count();
        if($inventario_inicial == 0 && $servicios == 0){
            return back()->withErrors(['No hay Productos o Servicios Agregados: '.$boleta->almacen->nombre.'']);
        }

        //REDIRECCION PARA NO MOSTRAR ERROR LARAVEL DE ID SHOW



        $igv=Igv::first();
        $banco=Banco::where('estado',0)->get();
        $empresa=Empresa::first();
        $sub_total=0;

        return view('transaccion.venta.boleta.show', compact('boleta','empresa','banco','boleta_registro','igv','sub_total'));
    }

    public function print($id){
        //REDIRECCION PARA NO MOSTRAR ERROR LARAVEL DE ID SHOW
        $existe_id=Boleta::where('id',$id)->first();
        if(empty($existe_id)){ return redirect()->route('boleta.index'); }

        $boleta=Boleta::find($id);
        //validar almacen con prodcutos vacios
        $inventario_inicial=Kardex_entrada::count();
        $servicios = Servicios::count();
        if($inventario_inicial == 0 && $servicios == 0){
            return back()->withErrors(['No hay Productos o Servicios Agregados: '.$boleta->almacen->nombre.'']);
        }



        $boleta_registro=Boleta_registro::where('boleta_id',$id)->get();
        $igv=Igv::first();
        $banco=Banco::where('estado',0)->get();
        $empresa=Empresa::first();
        $sub_total=0;

        $textoQR = $this->generarTextoQRBoleta($boleta, $empresa, $igv);
        $qrCode  = $this->generarImagenQR($textoQR);

        return view('transaccion.venta.boleta.print', compact('boleta','empresa','banco','boleta_registro','igv','sub_total', 'qrCode','textoQR'));
    }
    public function pdf(Request $request,$id){
        $name = $request->get('name');
        // $regla=$cotizacion->tipo;
        $boleta_registro=Boleta_registro::where('boleta_id',$id)->get();
        $igv=Igv::first();
        $banco=Banco::where('estado',0)->get();
        $banco_count=Banco::where('estado','0')->count();
        $empresa=Empresa::first();
        $sub_total=0;
        $boleta=Boleta::find($id);
        $i=1;

        $textoQR = $this->generarTextoQRBoleta($boleta, $empresa, $igv);
        $qrCode  = $this->generarImagenQR($textoQR);

        $pdf=PDF::loadView('transaccion.venta.boleta.pdf', compact('boleta','empresa','banco','boleta_registro','igv','sub_total','banco_count','i','qrCode','textoQR'));
        return $pdf->download('Boleta - '.$boleta->codigo_boleta.'.pdf');

        // return view('transaccion.venta.facturacion.print', compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco'));
    }
    public function show_boleta(Request $request,$id)
    {

     return view('transaccion.venta.facturacion.boleta');
 }

 public function create_boleta()
 {

     return view('transaccion.venta.facturacion.create_boleta');
 }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $facturacion=Facturacion::find($id);
        return view('transaccion.venta.facturacion.edit', compact('facturacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $venta_registro=Ventas_registro::where('id_facturacion',$id)->first();
        $id_venta_r=$venta_registro->id;

        $venta=Ventas_registro::where('id',$id_venta_r)->first();
        $venta->estado_fac=1;
        $venta->save();

        $fac=Facturacion::where('id',$id)->first();
        $fac->estado=1;
        $fac->save();

        return redirect()->route('facturacion.index');
    }
    public function ticket(Request $request,$id){

        $boleta=Boleta::find($id);
        $boleta_registro= Boleta_registro::where('boleta_id',$id)->get();
        $empresa=Empresa::first();
        $moneda = Moneda::where('id',$boleta->moneda_id)->first();
        $igv=Igv::first();
        return view('transaccion.venta.boleta.ticket',compact('boleta','boleta_registro','empresa','igv','moneda'));
    }
    public function index3(){
        return view('transaccion.venta.boleta.index3');
    }
    public function create2(){
        return view ('transaccion.venta.boleta.create2');
    }

    public function exportarBoletas(Request $request)
    {
        $ids = $request->json('boleta_ids');

        if (!empty($ids)) {
            $export = new BoletasExport($ids);
        } else {
            $request->validate([
                'daterange' => 'required|string'
            ]);

            [$start, $end] = explode(' - ', $request->daterange);

            $export = new BoletasExport(null, [
                'start'  => Carbon::createFromFormat('d/m/Y', $start)->startOfDay(),
                'end'    => Carbon::createFromFormat('d/m/Y', $end)->endOfDay(),
                'filter' => $request->input('value'),
                'tipo'   => $request->input('tipo_coti'),
            ]);
        }

        return Excel::download(
            $export,
            'Boletas_' . now('America/Lima')->format('Y-m-d') . '.xlsx'
        );
    }

    public function printMultiple(Request $request)
    {
        try {
            $boletaIds = $request->input('boleta_ids', []);

            if (empty($boletaIds) || !is_array($boletaIds)) {
                return back()->withErrors(['No se seleccionaron boletas para imprimir.']);
            }

            $boletas = Boleta::whereIn('id', $boletaIds)->get();

            if ($boletas->count() !== count($boletaIds)) {
                return back()->withErrors(['Algunas boletas seleccionadas no existen.']);
            }

            $inventario_inicial = Kardex_entrada::count();
            $servicios = Servicios::count();
            if ($inventario_inicial == 0 && $servicios == 0) {
                return back()->withErrors(['No hay Productos o Servicios Agregados']);
            }

            $empresa = Empresa::first();
            $igv = Igv::first();

            $boletasData = [];

            foreach ($boletas as $boleta) {
                $boleta_registro = Boleta_registro::where('boleta_id', $boleta->id)->get();
                $textoQR = $this->generarTextoQRBoleta($boleta, $empresa, $igv);
                $qrCode  = $this->generarImagenQR($textoQR);

                $boletasData[] = [
                    'boleta' => $boleta,
                    'boleta_registro' => $boleta_registro,
                    'sub_total' => $boleta->op_gravada + $boleta->op_inafecta + $boleta->op_exonerada,
                    'qrCode' => $qrCode,
                    'textoQR'=> $textoQR,
                ];
            }

            $banco = Banco::where('estado', 0)->get();


            return view('transaccion.venta.boleta.print_multiple', compact(
                'boletasData',
                'empresa',
                'banco',
                'igv'
            ));

        } catch (\Exception $e) {
            return back()->withErrors(['Error al procesar la impresión múltiple: ' . $e->getMessage()]);
        }
    }

    public function downloadMultiplePDFs(Request $request)
    {
        try {
            $boletaIds = $request->input('boleta_ids', []);

            if (empty($boletaIds) || !is_array($boletaIds)) {
                return back()->with('error', 'No se seleccionaron boletas para descargar.');
            }

            if (count($boletaIds) === 1) {
                return $this->downloadSinglePDF($boletaIds[0]);
            }

            $boletas = Boleta::whereIn('id', $boletaIds)->get();

            if ($boletas->count() !== count($boletaIds)) {
                return back()->with('error', 'Algunas boletas seleccionadas no existen.');
            }

            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            $zipName = 'Boletas_' . date('Y-m-d_H-i-s') . '.zip';
            $tempZip = $tempDir . DIRECTORY_SEPARATOR . $zipName;

            if (file_exists($tempZip)) {
                @unlink($tempZip);
            }

            $zip = new ZipArchive();

            if ($zip->open($tempZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                return back()->with('error', 'Error al crear el archivo ZIP');
            }

            $igv = Igv::first();
            $banco = Banco::where('estado', 0)->get();
            $banco_count = Banco::where('estado', '0')->count();
            $empresa = Empresa::first();

            foreach ($boletas as $boleta) {
                try {
                    $boleta_registro = Boleta_registro::where('boleta_id', $boleta->id)->get();
                    $sub_total = 0;
                    $i = 1;
                    $textoQR = $this->generarTextoQRBoleta($boleta, $empresa, $igv);
                    $qrCode  = $this->generarImagenQR($textoQR);

                    $pdf = PDF::loadView('transaccion.venta.boleta.pdf', compact(
                        'boleta',
                        'empresa',
                        'banco',
                        'boleta_registro',
                        'igv',
                        'sub_total',
                        'banco_count',
                        'i',
                        'qrCode',
                        'textoQR'
                    ));

                    $pdfContent = $pdf->output();

                    $codigoBoleta = preg_replace('/[^a-zA-Z0-9_-]/', '_', $boleta->codigo_boleta);
                    $fileName = 'Boleta_' . $codigoBoleta . '.pdf';
                    $zip->addFromString($fileName, $pdfContent);

                } catch (\Exception $e) {
                    continue;
                }
            }

            $zip->close();
            unset($zip);
            clearstatcache(true, $tempZip);
            usleep(100000);

            if (!file_exists($tempZip) || filesize($tempZip) == 0) {
                @unlink($tempZip);
                return back()->with('error', 'El archivo ZIP no se creó correctamente');
            }

            while (ob_get_level()) {
                ob_end_clean();
            }

            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipName . '"');
            header('Content-Length: ' . filesize($tempZip));
            header('Cache-Control: no-cache, must-revalidate');
            header('Pragma: public');

            readfile($tempZip);
            @unlink($tempZip);

            exit;

        } catch (\Exception $e) {
            return back()->with('error', 'Error al descargar boletas: ' . $e->getMessage());
        }
    }

    private function downloadSinglePDF($id)
    {
        try {
            $boleta = Boleta::find($id);
            if (!$boleta) {
                return back()->with('error', 'Boleta no encontrada.');
            }

            $boleta_registro = Boleta_registro::where('boleta_id', $id)->get();
            $igv = Igv::first();
            $banco = Banco::where('estado', 0)->get();
            $banco_count = Banco::where('estado', '0')->count();
            $empresa = Empresa::first();
            $sub_total = 0;
            $i = 1;
            $textoQR = $this->generarTextoQRBoleta($boleta, $empresa, $igv);
            $qrCode  = $this->generarImagenQR($textoQR);

            $pdf = PDF::loadView('transaccion.venta.boleta.pdf', compact(
                'boleta',
                'empresa',
                'banco',
                'boleta_registro',
                'igv',
                'sub_total',
                'banco_count',
                'i',
                'textoQR',
                'qrCode'
            ));

            return $pdf->download('Boleta_' . $boleta->codigo_boleta . '.pdf');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    /**
     * Genera el texto del código QR según los requisitos de SUNAT para boletas
     *
     * @param \App\Boleta $boleta
     * @param \App\Empresa $empresa
     * @param \App\Igv $igv
     * @return string
     */
    private function generarTextoQRBoleta($boleta, $empresa, $igv)
    {
        try {
            $ruc = $empresa->ruc ?? '';

            $tipoDocumento = '03';

            $codBoleta = $boleta->codigo_boleta ?? '';
            $partes = explode('-', $codBoleta);
            $serie = $partes[0] ?? '';
            $numero = $partes[1] ?? '';

            $sub_total_gravado = $boleta->op_gravada ?? 0;
            $igv_monto = round($sub_total_gravado * ($igv->igv_total / 100), 2);

            $sub_total = ($boleta->op_gravada ?? 0) + ($boleta->op_inafecta ?? 0) + ($boleta->op_exonerada ?? 0);
            $montoTotal = number_format(round($sub_total + $igv_monto, 2), 2, '.', '');
            $igv_formato = number_format($igv_monto, 2, '.', '');

            $fechaEmision = $boleta->fecha_emision ?? date('Y-m-d');

            $tipoDocCliente = '';
            $numDocCliente = '';

            if (isset($boleta->cliente_id) && $boleta->cliente) {
                $numDocCliente = $boleta->cliente->numero_documento ?? '';

                if (isset($boleta->cliente->tipo_documento)) {
                    $tipoDocCliente = $boleta->cliente->tipo_documento;
                } else {
                    $longitud = strlen($numDocCliente);
                    if ($longitud === 11) {
                        $tipoDocCliente = '6';
                    } elseif ($longitud === 8) {
                        $tipoDocCliente = '1';
                    } else {
                        $tipoDocCliente = '0';
                    }
                }
            } elseif (isset($boleta->cotizacion) && $boleta->cotizacion->cliente) {
                $numDocCliente = $boleta->cotizacion->cliente->numero_documento ?? '';

                if (isset($boleta->cotizacion->cliente->tipo_documento)) {
                    $tipoDocCliente = $boleta->cotizacion->cliente->tipo_documento;
                } else {
                    $longitud = strlen($numDocCliente);
                    if ($longitud === 11) {
                        $tipoDocCliente = '6';
                    } elseif ($longitud === 8) {
                        $tipoDocCliente = '1';
                    } else {
                        $tipoDocCliente = '0';
                    }
                }
            }

            $valorResumen = $boleta->hash_cpe ?? '';

            $textoQR = implode('|', [
                $ruc,
                $tipoDocumento,
                $serie,
                $numero,
                $igv_formato,
                $montoTotal,
                $fechaEmision,
                $tipoDocCliente,
                $numDocCliente,
                $valorResumen
            ]);

            return $textoQR;

        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * Genera la imagen QR en formato base64
     *
     * @param string $texto
     * @return string|null
     */
    private function generarImagenQR($texto)
    {
        try {
            if (empty($texto)) {
                return null;
            }

            $qr = QrCode::format('svg')
                        ->size(200)
                        ->errorCorrection('Q')
                        ->margin(1)
                        ->encoding('UTF-8')
                        ->generate($texto);

            if (empty($qr)) {
                return null;
            }

            $base64 = base64_encode($qr);

            return 'data:image/svg+xml;base64,' . $base64;

        } catch (\Exception $e) {
            return null;
        }
    }

    public function whatsappSendMultiple(Request $request)
    {
        $numero = $request->numero;
        $boletaIds = $request->boleta_ids;

        $mensaje = "";

        foreach ($boletaIds as $id) {
            $boleta = Boleta::find($id);
            if ($boleta) {
                $codigo = substr(md5($id . env('APP_KEY') . 'boleta'), 0, 22);

                $pdfUrl = url("boleta/share/{$codigo}");

                $mensaje .= "{$pdfUrl}\n";
            }
        }

        $mensajeCodificado = urlencode($mensaje);
        $whatsappUrl = "https://wa.me/{$numero}?text={$mensajeCodificado}";

        return redirect()->away($whatsappUrl);
    }

    public function descargarPorCodigo($codigo)
    {
        $boletas = Boleta::all();

        foreach ($boletas as $bol) {
            if (substr(md5($bol->id . env('APP_KEY') . 'boleta'), 0, 22) === $codigo) {
                return redirect()->route('pdf_bol', $bol->id);
            }
        }

        abort(404);
    }

    public function enviarCorreoDirecto(Request $request, $id)
    {
        try {
            $id_usuario = auth()->user()->id;
            $config_email = EmailConfiguraciones::where('id_usuario', $id_usuario)->first();

            if (!$config_email) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes configuración de email. Ve a configuración.'
                ], 400);
            }

            $fecha = Carbon::now();
            $data_g = str_replace(' ', '_', $fecha);
            $date = str_replace(':', '-', $data_g);

            $boleta = Boleta::find($id);
            $boleta_registro = Boleta_registro::where('boleta_id', $id)->get();
            $igv = Igv::first();
            $banco = Banco::all();
            $banco_count = Banco::where('estado', '0')->count();
            $empresa = Empresa::first();

            $textoQR = $this->generarTextoQRBoleta($boleta, $empresa, $igv);
            $qrCode  = $this->generarImagenQR($textoQR);

            $sub_total = 0;
            $i = 1;

            // Generar PDF
            $archivo = 'PDF-DOC-' . $boleta->codigo_boleta . '-' . $empresa->ruc . ".pdf";
            $pdf = PDF::loadView('transaccion.venta.boleta.pdf', compact('boleta', 'empresa', 'banco', 'boleta_registro', 'igv', 'sub_total', 'banco_count', 'i','textoQR','qrCode'));
            $content = $pdf->download();
            $especif = $date . $archivo;
            Storage::disk('mailbox')->put($especif, $content);

            // XML si aplica
            $xml_file = null;
            if ($boleta->b_electronica == 1) {
                $xml_file = $empresa->ruc . '-03-' . $boleta->codigo_boleta . '.xml';
            }

            // Preparar correos
            $emails = $request->get('emails', []);
            $emails = array_filter($emails);

            if (empty($emails)) {
                Storage::disk('mailbox')->delete($especif);
                return response()->json([
                    'success' => false,
                    'message' => 'Debes ingresar al menos un correo.'
                ], 400);
            }

            // Configuración de email
            $yourEmail = $config_email->email;
            $firma = $config_email->firma;
            $alto = $config_email->alto_firma;
            $ancho = $config_email->ancho_firma;

            $titulo = "Boleta Electrónica - " . $boleta->codigo_boleta;
            $mensaje_html = "Estimado cliente, adjuntamos la boleta electrónica " . $boleta->codigo_boleta;
            $mensaje = view('email_html.email_send_layout', compact('empresa', 'mensaje_html', 'firma', 'alto', 'ancho'));

            // Agregar email backup si existe
            $correos_envios = array_merge($emails, [$config_email->email_backup]);
            $mails_array = array_filter($correos_envios);

            // Preparar archivos
            $pdfile = public_path() . '/archivos/' . $especif;

            // Configurar transporte de email
            $transport = (new \Swift_SmtpTransport($config_email->smtp, $config_email->port, $config_email->encryption))
                ->setUsername($config_email->email)
                ->setPassword($config_email->password);
            $mailer = new \Swift_Mailer($transport);
            $mailer->getTransport()->start();

            $message = (new \Swift_Message($yourEmail))
                ->setFrom([$yourEmail => $titulo])
                ->setTo($mails_array)
                ->setBody($mensaje, 'text/html');

            // Adjuntar PDF
            $message->attach(\Swift_Attachment::fromPath($pdfile));

            // Adjuntar XML si existe
            if ($xml_file && file_exists(public_path() . '/facturas_electronicas/' . $xml_file)) {
                $xml_path = public_path() . '/facturas_electronicas/' . $xml_file;
                $message->attach(\Swift_Attachment::fromPath($xml_path));
            }

            // Enviar correo
            if ($mailer->send($message)) {
                $texto = strip_tags($mensaje_html);

                // Guardar en bandeja de envíos
                $mail = new EmailBandejaEnvios;
                $mail->id_usuario = auth()->user()->id;
                $mail->destinatario = $yourEmail;
                $mail->remitente = implode(', ', $emails);
                $mail->asunto = $titulo;
                $mail->mensaje = $mensaje_html;
                $mail->mensaje_sin_html = $texto;
                $mail->estado = '0';
                $mail->fecha_hora = Carbon::now();
                $mail->save();

                // Guardar PDF en archivos
                $archivo_pdf = new EmailBandejaEnviosArchivos;
                $archivo_pdf->id_bandeja_envios = $mail->id;
                $archivo_pdf->archivo = $archivo;
                $archivo_pdf->fecha_hora = $date;
                $archivo_pdf->save();

                // Guardar XML en archivos si existe
                if ($xml_file) {
                    $guardar_email_archivo = new EmailBandejaEnviosArchivos;
                    $guardar_email_archivo->id_bandeja_envios = $mail->id;
                    $guardar_email_archivo->archivo = $xml_file;
                    $guardar_email_archivo->fecha_hora = $date;
                    $guardar_email_archivo->save();
                }

                // ⭐ LIMPIAR ARCHIVOS VIEJOS (más de 5 minutos)
                $this->limpiarArchivosViejos(2880);

                return response()->json([
                    'success' => true,
                    'message' => 'Correo enviado exitosamente a: ' . implode(', ', $emails)
                ]);
            }

            // Si falla el envío
            Storage::disk('mailbox')->delete($especif);
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el correo. Verifica tu configuración.'
            ], 500);

        } catch (\Exception $e) {
            if (isset($especif)) {
                Storage::disk('mailbox')->delete($especif);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function enviarCorreoMultiple(Request $request)
    {
        try {
            $email = $request->get('email');
            $boleta_ids = $request->get('boleta_ids', []);

            if (empty($boleta_ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se seleccionaron boletas para enviar.'
                ], 400);
            }

            if (empty($email)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El correo electrónico es requerido.'
                ], 400);
            }

            $id_usuario = auth()->user()->id;
            $config_email = EmailConfiguraciones::where('id_usuario', $id_usuario)->first();

            if (!$config_email) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes configuración de email. Ve a configuración.'
                ], 400);
            }

            $fecha = Carbon::now();
            $data_g = str_replace(' ', '_', $fecha);
            $date = str_replace(':', '-', $data_g);

            $empresa = Empresa::first();
            $igv = Igv::first();
            $banco = Banco::all();
            $banco_count = Banco::where('estado', '0')->count();

            // Configuración de email
            $yourEmail = $config_email->email;
            $firma = $config_email->firma;
            $alto = $config_email->alto_firma;
            $ancho = $config_email->ancho_firma;

            $titulo = "Boletas Electrónicas - " . count($boleta_ids) . " documento(s)";
            $mensaje_html = "Estimado cliente, adjuntamos las boletas electrónicas solicitadas.";
            $mensaje = view('email_html.email_send_layout', compact('empresa', 'mensaje_html', 'firma', 'alto', 'ancho'));

            // Agregar email backup si existe
            $correos_envios = [$email, $config_email->email_backup];
            $mails_array = array_filter($correos_envios);

            // Configurar transporte de email
            $transport = (new \Swift_SmtpTransport($config_email->smtp, $config_email->port, $config_email->encryption))
                ->setUsername($config_email->email)
                ->setPassword($config_email->password);
            $mailer = new \Swift_Mailer($transport);
            $mailer->getTransport()->start();

            $message = (new \Swift_Message($yourEmail))
                ->setFrom([$yourEmail => $titulo])
                ->setTo($mails_array)
                ->setBody($mensaje, 'text/html');

            // Array para guardar archivos temporales
            $archivos_temporales = [];
            $archivos_xml = [];

            // Generar y adjuntar cada PDF
            foreach ($boleta_ids as $boleta_id) {
                $boleta = Boleta::find($boleta_id);
                if (!$boleta) continue;

                $boleta_registro = Boleta_registro::where('boleta_id', $boleta_id)->get();
                $sub_total = 0;
                $i = 1;

                $textoQR = $this->generarTextoQRBoleta($boleta, $empresa, $igv);
                $qrCode  = $this->generarImagenQR($textoQR);

                // Generar PDF
                $archivo = 'PDF-DOC-' . $boleta->codigo_boleta . '-' . $empresa->ruc . ".pdf";
                $pdf = PDF::loadView('transaccion.venta.boleta.pdf', compact('boleta', 'empresa', 'banco', 'boleta_registro', 'igv', 'sub_total', 'banco_count', 'i','textoQR','qrCode'));
                $content = $pdf->download();
                $especif = $date . $archivo;
                Storage::disk('mailbox')->put($especif, $content);

                $pdfile = public_path() . '/archivos/' . $especif;
                $message->attach(\Swift_Attachment::fromPath($pdfile));

                $archivos_temporales[] = $especif;

                // Adjuntar XML si existe
                if ($boleta->b_electronica == 1) {
                    $xml_file = $empresa->ruc . '-03-' . $boleta->codigo_boleta . '.xml';
                    $xml_path = public_path() . '/facturas_electronicas/' . $xml_file;
                    if (file_exists($xml_path)) {
                        $message->attach(\Swift_Attachment::fromPath($xml_path));
                        $archivos_xml[] = $xml_file;
                    }
                }
            }

            // Enviar correo
            if ($mailer->send($message)) {
                $texto = strip_tags($mensaje_html);

                // Guardar en bandeja de envíos
                $mail = new EmailBandejaEnvios;
                $mail->id_usuario = auth()->user()->id;
                $mail->destinatario = $yourEmail;
                $mail->remitente = $email;
                $mail->asunto = $titulo;
                $mail->mensaje = $mensaje_html;
                $mail->mensaje_sin_html = $texto;
                $mail->estado = '0';
                $mail->fecha_hora = Carbon::now();
                $mail->save();

                // Guardar archivos PDF en bandeja (CON LA FECHA para que coincida con el archivo físico)
                foreach ($archivos_temporales as $archivo_temp) {
                    $archivo_pdf = new EmailBandejaEnviosArchivos;
                    $archivo_pdf->id_bandeja_envios = $mail->id;
                    $archivo_pdf->archivo = $archivo_temp;
                    $archivo_pdf->fecha_hora = $date;
                    $archivo_pdf->save();
                }

                // Guardar archivos XML en bandeja
                foreach ($archivos_xml as $xml_file) {
                    $archivo_xml = new EmailBandejaEnviosArchivos;
                    $archivo_xml->id_bandeja_envios = $mail->id;
                    $archivo_xml->archivo = $xml_file;
                    $archivo_xml->fecha_hora = $date;
                    $archivo_xml->save();
                }

                $this->limpiarArchivosViejos(2880);

                return response()->json([
                    'success' => true,
                    'message' => 'Se enviaron ' . count($boleta_ids) . ' boleta(s) exitosamente a: ' . $email
                ]);
            }

            // Si falla el envío, limpiar archivos
            foreach ($archivos_temporales as $archivo_temp) {
                Storage::disk('mailbox')->delete($archivo_temp);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el correo. Verifica tu configuración.'
            ], 500);

        } catch (\Exception $e) {
            if (isset($archivos_temporales) && !empty($archivos_temporales)) {
                foreach ($archivos_temporales as $archivo_temp) {
                    Storage::disk('mailbox')->delete($archivo_temp);
                }
            }
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function limpiarArchivosViejos($minutos = 2880)
    {
        try {
            $disk = Storage::disk('mailbox');
            $archivos = $disk->allFiles();

            foreach ($archivos as $file) {
                if (preg_match('/^\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}/', $file)) {
                    $lastModified = $disk->lastModified($file);
                    $tiempoTranscurrido = now()->timestamp - $lastModified;

                    if ($tiempoTranscurrido > ($minutos * 60)) {
                        $disk->delete($file);
                    }
                }
            }

        } catch (\Exception $e) {
        }
    }
}
