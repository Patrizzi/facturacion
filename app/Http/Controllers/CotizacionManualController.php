<?php

namespace App\Http\Controllers;

use App\RenovacionVentas;
use App\Almacen;
use App\Codigo_guia_almacen;
use App\Banco;
use App\Boleta_m;
use App\Boleta_registros_m;
use App\Cliente;
use App\ComprobantesVentas;
use App\Cotizacion;
use App\Empresa;
use App\Forma_pago;
use App\Garantia;
use App\Igv;
use App\Facturacion_m;
use App\Facturacion_registro_m;
use App\Kardex_entrada;
use App\CotizacionManual;
use App\CotizacionManual_registros;
use App\Moneda;
use App\Personal;
use App\Producto;
use App\Servicios;
use App\TipoCambio;
use App\Cuotas_credito;
use App\Unidad_medida;
use App\Tipo_operacion_f;
use App\Validez;
use App\kardex_entrada_registro;
use App\NotaVenta;
use App\NotaVentaRegistro;
use App\ServicioGuia;
use App\ServicioGuiaEgreso;
use App\ServicioGuiaIngreso;
use App\Ventas_registro;
use PDF;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class CotizacionManualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $cotizacion = CotizacionManual::whereNull('guia_id')->get();
        $igv = Igv::first();

        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        $existe_id=Kardex_entrada::where('estado',2)->first();
        // if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

        return view('transaccion.venta.cotizacion.manual.index', compact('cotizacion','igv'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $garantia=Garantia::where('estado',0)->get();
        $validez=Validez::where('estado',0)->get();
        if (count($garantia)==0) {
            $garantia_new=new Garantia;
            $garantia_new->descripcion='Sin Garantia';
            $garantia_new->estado='0';
            $garantia_new->save();
        }
        if (count($validez)==0) {
            $validez_new=new Validez;
            $validez_new->descripcion='1 dia';
            $validez_new->estado='0';
            $validez_new->save();
        }

        // para cotizacion manual duplicar
        $cotiDuplicada = null;
        if ($request->has('id') && !empty($request->id)) {
            $cotiDuplicada = $this->duplicateCotiM($request->id);
        }

        // return $cotiDuplicada;

        // Migracion nueva
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        // * CAMBIAR POR VERIFICACION DE CANTIDAD DE PRODUCTOS Y SERVICIOS PRODUCTOS??
        $existe_id=Kardex_entrada::where('estado',2)->first();
        // if(empty($existe_id)){
        //     return redirect()->route('kardex-entrada.index');
        // }
        // Sucursal
        $sucursal_1=1;
        $sucursal=Almacen::where('id',$sucursal_1)->first();

        // Validador de contador en productos y servicios
        $inventario_inicial=Producto::count();
        $servicios = Servicios::count();
        if($inventario_inicial == 0 && $servicios == 0){
            return back()->withErrors(['No hay Productos o Servicios Agregados ']);
        }

        $almacen = Almacen::where('estado','!=',1)->get();
        //Numero de factura
        $cotizacion_fact=CotizacionManual::where('almacen_id',$sucursal->id)->where('tipo','factura')->latest()->first();
        if (empty($cotizacion_fact)) {
            $numero_serie_fac=$sucursal->id;
            $correlativo_fac=1;
        } else{
            $numero_serie_busqueda_fac=$cotizacion_fact->cod_cotizacion;
            $numero_serie_1_fac=strstr($numero_serie_busqueda_fac,'0',false);
            $numero_serie_fac=strstr($numero_serie_1_fac,'-',true);
            $correlativo_ultimo_fac=substr(strrchr($numero_serie_busqueda_fac, "-"),1);
            $correlativo_fac = $correlativo_ultimo_fac+1;

            if($correlativo_ultimo_fac == 99999999){
                $correlativo_fac = 1;
                $numero_serie_fac = $numero_serie_fac+1;
            }
        }
        $sucursal_nr_fac = str_pad($numero_serie_fac, 3, "0", STR_PAD_LEFT);
        $correlativo_fac=str_pad($correlativo_fac, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero_fac="CMF ".$sucursal_nr_fac."-".$correlativo_fac;

        $clientes=Cliente::all();
        //$moneda=Moneda::where('principal','1')->first();
        $moneda=Moneda::get();
        $forma_pagos= Forma_pago::all();
        $igv=Igv::first();
        $servicios = Servicios::all();
        $productos=Producto::all();
        $empresa=Empresa::first();
        $tipo_operacion=Tipo_operacion_f::get();
        return view('transaccion.venta.cotizacion.manual.create',compact('garantia','validez','igv','empresa','clientes','forma_pagos','moneda','productos','servicios','almacen','tipo_operacion','sucursal','cotizacion_numero_fac', 'cotiDuplicada'));
    }

    private function duplicateCotiM($cotizacion_m_id) {
        try {

            $cotizacion_m = CotizacionManual::with([
                'cliente',
                'forma_pago',
                'moneda',
                'almacen',
                'comisionista',
                'tipo_operacion',
                'tipo_documento',
                'coti_manual_registros.producto',
                'coti_manual_registros.servicio'
            ])->findOrFail($cotizacion_m_id);

            return $cotizacion_m;

        } catch (Exception $e) {

            return null;

        }
    }

    public function change_almacen_tipo(Request $request){
        // return $request;
        $almacen = $request->get('almacen');
        $tipo = $request->get('tipo');
        if($tipo == "1"){
            $tipo = "factura";
        }elseif($tipo == "0"){
            $tipo = "boleta";
        }else{
            $tipo = "nota_venta";
        }

        $cotizacion_manual = CotizacionManual::where('almacen_id',$almacen)->where('tipo', $tipo)->latest()->first();
        if (empty($cotizacion_manual)) {
            $numero_serie=$almacen;
            $correlativo=1;
        } else{
            $numero_serie_busqueda=$cotizacion_manual->cod_cotizacion;
            $numero_serie_1=strstr($numero_serie_busqueda,'0',false);
            $numero_serie=strstr($numero_serie_1,'-',true);
            $correlativo_ultimo=substr(strrchr($numero_serie_busqueda, "-"),1);
            $correlativo = $correlativo_ultimo+1;

            if($correlativo_ultimo == 99999999){
                $correlativo = 1;
                $numero_serie = $numero_serie+1;
            }
        }
        $sucursal_nr = str_pad($numero_serie, 3, "0", STR_PAD_LEFT);
        $correlativo=str_pad($correlativo, 8, "0", STR_PAD_LEFT);

        if($tipo == "factura"){
            $cotizacion_numero="CMF ".$sucursal_nr."-".$correlativo;
        }elseif($tipo == "boleta"){
            $cotizacion_numero="CMB ".$sucursal_nr."-".$correlativo;
        }else{
            $cotizacion_numero="CMV ".$sucursal_nr."-".$correlativo;
        }
        return $cotizacion_numero;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;

        $cantidad_p = $request->input('cantidad');
        $count_cantidad_p=count($cantidad_p);

        // PARA BUSCAR POR ITEM
        for($i=0 ; $i<$count_cantidad_p;$i++){
            $articulos[$i]= $request->input('articulo')[$i];
            $producto_id_name[$i]=strstr($articulos[$i], '|');
            $producto_id_2[$i]=strstr($producto_id_name[$i], ' ');
            $producto_id_3[$i]=substr(strstr($producto_id_2[$i], ' '),1);
            $producto_id[$i]=strstr($producto_id_3[$i], ' ', true);

        }

        // ALMACEN Y CODIGO PARA ALMACEN
        $almacen_req = $request->get('almacen_form');
        $sucursal =Almacen::where('id', $almacen_req)->first();

        // return $request;

        // CLIENTE
        $cliente_id=$request->get('cliente');
        $cliente=Cliente::where('id',$cliente_id)->first();

        //FORMA DE PAGO
        $id_forma_pago = $request->get('forma_pago');
        $forma_pago = Forma_Pago::where('id', $id_forma_pago)->first();

        //TIPO DE CAMBIO
        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }
        //TIPO DE COTIZACION
        $tipo_coti = $request->get('tipo_coti');
        if($tipo_coti == 1){
            $tipo_cotizacion = "factura";
            $tipo_doc = 2;

            $cotizacion=CotizacionManual::where('almacen_id',$sucursal->id)->where('tipo','factura')->latest()->first();
            if (empty($cotizacion)) {
                $numero_serie=$sucursal->id;
                $correlativo=1;
            } else{
                $numero_serie_busqueda=$cotizacion->cod_cotizacion;
                $numero_serie_1=strstr($numero_serie_busqueda,'0',false);
                $numero_serie=strstr($numero_serie_1,'-',true);
                $correlativo_ultimo=substr(strrchr($numero_serie_busqueda, "-"),1);
                $correlativo = $correlativo_ultimo+1;

                if($correlativo_ultimo == 99999999){
                    $correlativo = 1;
                    $numero_serie = $numero_serie+1;
                }
            }

            $sucursal_nr = str_pad($numero_serie, 3, "0", STR_PAD_LEFT);
            $correlativo=str_pad($correlativo, 8, "0", STR_PAD_LEFT);
            $cotizacion_numero="CMF ".$sucursal_nr."-".$correlativo;

        }elseif($tipo_coti == 0){
            $tipo_cotizacion = "boleta";
            $tipo_doc = 0;

            $cotizacion = CotizacionManual::where('almacen_id',$sucursal->id)->where('tipo','boleta')->latest()->first();
            if(empty($cotizacion)){
                $numero_serie = $sucursal->id;
                $correlativo = 1;
            }else{
                $numero_serie_busqueda =$cotizacion->cod_cotizacion;
                $numero_serie_1=strstr($numero_serie_busqueda,'0',false);
                $numero_serie=strstr($numero_serie_1,'-',true);
                $correlativo_ultimo = substr(strstr($numero_serie_busqueda, "-"),1);
                $correlativo = $correlativo_ultimo+1;
                if($correlativo_ultimo == 99999999){
                    $correlativo = 1;
                    $numero_serie = $numero_serie+1;
                }
            }

            $sucursal_nr = str_pad($numero_serie, 3, "0", STR_PAD_LEFT);
            $correlativo=str_pad($correlativo, 8, "0", STR_PAD_LEFT);
            $cotizacion_numero="CMB ".$sucursal_nr."-".$correlativo;
        }else{
            $tipo_cotizacion = "nota_venta";
            $tipo_doc = 3;

            $cotizacion = CotizacionManual::where('almacen_id',$sucursal->id)->where('tipo','nota_venta')->latest()->first();
            if(empty($cotizacion)){
                $numero_serie = $sucursal->id;
                $correlativo = 1;
            }else{
                $numero_serie_busqueda =$cotizacion->cod_cotizacion;
                $numero_serie_1=strstr($numero_serie_busqueda,'0',false);
                $numero_serie=strstr($numero_serie_1,'-',true);
                $correlativo_ultimo = substr(strstr($numero_serie_busqueda, "-"),1);
                $correlativo = $correlativo_ultimo+1;
                if($correlativo_ultimo == 99999999){
                    $correlativo = 1;
                    $numero_serie = $numero_serie+1;
                }
            }

            $sucursal_nr = str_pad($numero_serie, 3, "0", STR_PAD_LEFT);
            $correlativo=str_pad($correlativo, 8, "0", STR_PAD_LEFT);
            $cotizacion_numero="CMV ".$sucursal_nr."-".$correlativo;
        }
         // obtención de Tipo de operación
         $operacion=$request->get('tipo_operacion');
         $nombre = strstr($operacion, '-',true);
         $busca_ope=Tipo_operacion_f::where('codigo',$nombre)->first();
        // return $request;

        //MONEDA
        $moneda = $request->get('moneda');
        $moneda_search = Moneda::where('nombre', $moneda)->first();
        $submit = $request->get('submit');
    //    return $moneda_search;

        $cotizacion_manual = new CotizacionManual;
        // verificar si es una guia
        if ($request->has('guia_id')) {
            $cotizacion_manual->guia_id = $request->guia_id;
            $servicio_guia = ServicioGuia::find($request->guia_id);
            if ($servicio_guia) {
                $servicio_guia->cotizado = 1;
                $servicio_guia->save();
                // Marcar todos los productos de la guía como cotizados
                if ($request->has('productos_incluidos_ids')) {
                    $productosIds = json_decode($request->productos_incluidos_ids);

                    // Actualizar solo los productos incluidos en la cotización
                    if (!empty($productosIds) && $servicio_guia->servicio_guia_ingreso) {
                        foreach ($servicio_guia->servicio_guia_ingreso->detalle_guia_ingreso as $detalle) {
                            if (in_array($detalle->id, $productosIds)) {
                                $detalle->cotizado = 1;
                                $detalle->save();
                            }
                        }
                    }
                }
            }
        }
        $cotizacion_manual->cod_cotizacion = $cotizacion_numero;
        $cotizacion_manual->almacen_id = $sucursal->id;
        $cotizacion_manual->cliente_id = $cliente->id;
        $cotizacion_manual->moneda_id = $moneda_search->id;
        $cotizacion_manual->forma_pago_id = $forma_pago->id;
        $cotizacion_manual->garantia = $request->get('garantia');
        $cotizacion_manual->validez =  $request->get('validez');
        $cotizacion_manual->fecha_emision = $request->get('fecha_emision');
        $cotizacion_manual->cambio = $cambio->paralelo;
        $cotizacion_manual->observacion = $request->get('observacion');
        $cotizacion_manual->user_id = auth()->user()->id;
        $cotizacion_manual->estado = '0';
        if($submit == 2){
            $cotizacion_manual->estado_vigente = '1';
        }else{
            $cotizacion_manual->estado_vigente = '0';
        }
        $cotizacion_manual->tipo = $tipo_cotizacion;
        $cotizacion_manual->tipo_operacion_id = $busca_ope->id;
        $cotizacion_manual->tipo_documento_id = $tipo_doc;
        $cotizacion_manual->save();

        // NUEVO: Guardar información de renovación
        if ($request->has('estado_renovacion') && $request->estado_renovacion == 1) {
        $renovacion = new RenovacionVentas();
        $renovacion->cotizacion_manual_id = $cotizacion_manual->id;
        $renovacion->frecuencia = $request->select_fecha;

        if ($request->select_fecha == 'Mensual') {
            $renovacion->dia_mensual = $request->dia_mensual; // Este valor ahora es 1-31
            $renovacion->dia_anual = null;
            $renovacion->mes_anual = null;
            $renovacion->anio_anual = null;

        } elseif ($request->select_fecha == 'Anual') {
            $renovacion->dia_mensual = null;
            $renovacion->dia_anual = $request->dia_anual;   // Día del mes (1-31)
            $renovacion->mes_anual = $request->mes_anual;   // Mes (1-12)
            $renovacion->anio_anual = $request->anio_anual; // Año completo
        }

        $renovacion->estado = 1;
        $renovacion->save();
    }

        // CODIGO GUIA ALMACEN
        $coti_manual=Codigo_guia_almacen::where('id', $sucursal->id)->first();
        if($tipo_cotizacion == 'factura'){
            if(is_numeric($coti_manual->cod_coti_fact_m)){
                $coti_manual->cod_coti_fact_m='NN';
                $coti_manual->save();
            }
        }elseif($tipo_cotizacion == 'boleta'){
            if(is_numeric($coti_manual->cod_coti_bol_m)){
                $coti_manual->cod_coti_bol_m='NN';
                $coti_manual->save();
            }
        }
        //INSERCION DE REGISTROS EN PRODUCTOS

        //contador de valores de cantidad
        $cantidad_articulo = $request->input('cantidad');
        $count_cantidad=count($cantidad_articulo);

        //contador de valores de articulo
        $articulo = $request->input('articulo');
        $count_articulo=count($articulo);

        if($count_articulo = $count_cantidad){
            // Bucle para registro de productos o servicios
            for($i=0;$i<$count_articulo;$i++){
                // Llamado de producto y servicio para su diferenciación y registro propio
                $producto = Producto::where('codigo_producto',$producto_id[$i])->first();
                $servicio=Servicios::where('codigo_servicio',$producto_id[$i])->where('estado_anular',0)->first();

                if(isset($producto)){
                    $cotizacion_reg_manual = new CotizacionManual_registros;
                    $cotizacion_reg_manual->cotizacion_m_id = $cotizacion_manual->id;
                    $cotizacion_reg_manual->producto_id = $producto->id;
                    if($request->get('descripcion_item')[$i] == null){
                        $cotizacion_reg_manual->descripcion_item = null;
                    }else{
                        $cotizacion_reg_manual->descripcion_item = $request->get('descripcion_item')[$i];
                    }
                    $cotizacion_reg_manual->cantidad=$request->get('cantidad')[$i];
                    $cotizacion_reg_manual->precio=$request->get('precio_s_igv')[$i];
                    $cotizacion_reg_manual->save();

                    $cotizacion_m_2=CotizacionManual::find($cotizacion_manual->id);
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                        $cotizacion_m_2->op_gravada += round($cotizacion_reg_manual->precio*$cotizacion_reg_manual->cantidad,2);
                    }
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                        $cotizacion_m_2->op_exonerada += round($cotizacion_reg_manual->precio*$cotizacion_reg_manual->cantidad,2);
                    }
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                        $cotizacion_m_2->op_inafecta += round($cotizacion_reg_manual->precio*$cotizacion_reg_manual->cantidad,2);
                    }
                    $cotizacion_m_2->save();
                }else{
                    $cotizacion_reg_manual = new CotizacionManual_registros;
                    $cotizacion_reg_manual->cotizacion_m_id = $cotizacion_manual->id;
                    $cotizacion_reg_manual->servicio_id = $servicio->id;
                    if($request->get('descripcion_item')[$i] == null){
                        $cotizacion_reg_manual->descripcion_item = null;
                    }else{
                        $cotizacion_reg_manual->descripcion_item = $request->get('descripcion_item')[$i];
                    }
                    $cotizacion_reg_manual->cantidad=$request->get('cantidad')[$i];
                    $cotizacion_reg_manual->precio=$request->get('precio_s_igv')[$i];
                    $cotizacion_reg_manual->save();

                    $cotizacion_m_2=CotizacionManual::find($cotizacion_manual->id);
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                        $cotizacion_m_2->op_gravada += round($cotizacion_reg_manual->precio*$cotizacion_reg_manual->cantidad,2);
                    }
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                        $cotizacion_m_2->op_exonerada += round($cotizacion_reg_manual->precio*$cotizacion_reg_manual->cantidad,2);
                    }
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                        $cotizacion_m_2->op_inafecta += round($cotizacion_reg_manual->precio*$cotizacion_reg_manual->cantidad,2);
                    }
                    $cotizacion_m_2->save();
                }
            }
        }
        if($request->servicio_g_id && $request->has('equipo_ids')){
            ServicioGuiaIngreso::whereIn('id', $request->equipo_ids)->update(['estado' => 1]);
            $servicioGuia = ServicioGuia::findOrFail($request->servicio_g_id);
            $servicioGuia->update([
                'estado' => 2
            ]);
        }

        // si recibe la peticion de servicioGuia, cambiar estados
        if($request->servicio_g_id && $request->has('equipo_ids')){
            // encontrar el servicioGuia
            $servicioGuia = ServicioGuia::findOrFail($request->servicio_g_id);

            // equipos captados del front para cambiar de estado a 1(cotizado)
            ServicioGuiaIngreso::whereIn('id', $request->equipo_ids)->update(['estado' => 1]);
            // traer equipos no cotizados
            $equiposNoCotizados = ServicioGuiaIngreso::where('servicio_guia_id', $servicioGuia->id)->whereNotIn('id', $request->equipo_ids)->pluck('id');

            // si la cantidad de equipos no cotizados es a partir de 1
            // cambiar esos equipos a estado 3(rechazado)
            if($equiposNoCotizados->count() > 0) {
                ServicioGuiaEgreso::whereIn('servicio_g_ingreso_id', $equiposNoCotizados)->update(['estado' => 2]);
            }

            // cambiar el estado de servicio Guia a 2(cotizado)
            $servicioGuia->update([
                'estado' => 2
            ]);

            // si es del servicio tecnico,
            $cotizacion_manual->es_serv_tec = 1;
            // relacionarlo con el servicio guia
            $cotizacion_manual->servicio_g_id = $servicioGuia->id;
            $cotizacion_manual->save();
        }



        return redirect()->route('cotizacion_manual.show',$cotizacion_manual->id);
    //     /*IMPRENSION*/
    //    //  if($print==1){
    //     $name = $request->get('name');

    //     $banco=Banco::where('estado','0')->get();
    //     $banco_count=Banco::where('estado','0')->count();
    //     $empresa=Empresa::first();

    //      //Convertir nombre del cliente a id
    //     $cliente_id=$request->get('cliente');
    //     $nombre = strstr($cliente_id, '-',true);
    //     $cliente_id=Cliente::where('numero_documento',$nombre)->first();

    //     $user_login =auth()->user();
    //     $personal=Personal::where('id',$user_login->personal_id)->first();

    //     $codigo=$request->get('codigo');
    //     $fecha_emision=$request->get('fecha_emision');
    //     $forma_pago_id=$request->get('forma_pago');

    //     $moneda=$request->get('moneda');
    //     $moneda_id=Moneda::where('id',$moneda)->first();

    //     $validez=$request->get('validez');
    //     $garantia=$request->get('garantia');
    //     $observacion=$request->get('observacion');
    //     $articulo = $request->input('articulo');
    //     $count_articulo=count($articulo);
    //     $cantidad_p = $request->input('cantidad');


    //     $count_cantidad_p=count($cantidad_p);

    //     // $igv=Igv::first();

    //     for($i=0 ; $i<$count_cantidad_p;$i++){
    //         $articulos[$i]= $request->input('articulo')[$i];
    //         $producto_id[$i]=strstr($articulos[$i], ' ', true);
    //         $producto_codigo[$i]=Producto::where('id',$producto_id[$i])->first();
    //     }

    //     for($i=0;$i<$count_articulo;$i++){
    //         $cantidad[]=$request->input('cantidad')[$i];
    //         $precio[]=$request->input('precio_s_igv')[$i];
    //         $precio_igv[]=$request->input('precio_c_igv')[$i];
    //     }
    //     $sub_total = $request->input('subtotal');
    //     $igv = $request->input('igv');
    //     $total_final = $request->input('total_final');
    //     //Numeor a letras vartiables
    //     $igv_p=round($total_final,2);
    //     $end=round($total_final,2);
    //     $end2=number_format(round($total_final,2),2);

    //     if ($name=='print') {
    //        return view('transaccion.venta.cotizacion.manual.print',compact('tipo_coti','producto_codigo','cliente_id','forma_pago_id','validez','observacion','producto_id','cantidad','precio','precio_igv','codigo','fecha_emision','moneda_id','garantia','empresa','banco','banco_count','articulos','personal','sub_total','igv','total_final','igv_p','end','end2'));
    //     }elseif ($name=='pdf'){
    //         $pdf=PDF::loadView('transaccion.venta.cotizacion.manual.pdf',compact('tipo_coti','producto_codigo','cliente_id','forma_pago_id','validez','observacion','producto_id','cantidad','precio','precio_igv','codigo','fecha_emision','moneda_id','garantia','empresa','banco','banco_count','articulos','personal','sub_total','igv','total_final','igv_p','end','end2'));
    //         return $pdf->download('COTPF 001-0000000'.$codigo.'.pdf');
    //     }elseif ($name=='correo'){
    //         $date_sp = Carbon::now();
    //         $data_g = str_replace(' ', '_',$date_sp);
    //         $carbon_sp = str_replace(':','-',$data_g);
    //         $date = $carbon_sp;
    //         $redic='mailbox';
    //         $clientes=$cliente_id->email;
    //         $rutapdf = 'transaccion.venta.cotizacion.pdf';
    //         $name = 'COTPF 001-0000000';

    //         // return $cotizacion;
    //         $archivo=$name.$codigo.".pdf";
    //         $pdf=PDF::loadView('transaccion.venta.cotizacion.manual.pdf',compact('producto_codigo','cliente_id','forma_pago_id','validez','observacion','producto_id','cantidad','precio','codigo','fecha_emision','moneda_id','garantia','empresa','banco','banco_count','articulos','personal','sub_total','igv','total_final','igv_p','end','end2'));
    //         $especif = $carbon_sp.$archivo;
    //         $contenido=$pdf->download();
    //         Storage::disk($redic)->put($especif,$contenido);
    //         return view('mailbox.create',compact('archivo','clientes','redic','date'));
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // Redirección para mostrar el inventario inicial
        $existe_id = CotizacionManual::where('id', $id)->first();
        if(empty($existe_id)) {
            return redirect()->route('cotizacion_manual.index');
        }

        $empresa = Empresa::first();
        $cotizacion = CotizacionManual::find($id);
        $cotizacion_m_reg = CotizacionManual_registros::where('cotizacion_m_id', $id)->get();
        $garantia = Garantia::where('estado', 0)->get();
        $validez = Validez::where('estado', 0)->get();
        $forma_pagos = Forma_pago::get();
        $igv_t = Igv::first();
        $banco = Banco::where('estado', 0)->get();
        $banco_count = count($banco);
        $j = 1;
        $sum = 0;

        // SUBTOTAL
        $sub_total = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;

        // IGV
        $igv = round($cotizacion->op_gravada, 2) * $igv_t->igv_total / 100;

        // TOTAL
        $end = round($sub_total, 2) + round($igv, 2);
        $end2 = number_format(round($sub_total, 2) + round($igv, 2), 2);

        $factura = Facturacion_m::where('cotizador_id', $id)->first();
        $boleta = Boleta_m::where('cotizador_id', $id)->first();
        $nota_venta = NotaVenta::where('id_cotizacion_m', $id)->first();

        // VERIFICAR SI EXISTE RENOVACIÓN
        $renovacion = RenovacionVentas::where('cotizacion_manual_id', $id)
            ->where('estado', 1)
            ->with('cotizacionManual')
            ->first();

        $fecha_vencimiento = null;
        $dias_restantes_texto = null;
        $dias_restantes_numero = null;

        if ($renovacion && $renovacion->cotizacionManual) {
            $fecha_actual = Carbon::now()->startOfDay();
            $fecha_emision = Carbon::parse($renovacion->cotizacionManual->fecha_emision)->startOfDay();

            if ($renovacion->frecuencia == 'Mensual' && $renovacion->dia_mensual) {
                $dia_renovacion = (int) $renovacion->dia_mensual;

                $fecha_vencimiento = Carbon::create(
                    $fecha_emision->year,
                    $fecha_emision->month,
                    min($dia_renovacion, $fecha_emision->daysInMonth)
                )->startOfDay();

                if ($fecha_vencimiento->lt($fecha_emision)) {
                    $fecha_vencimiento->addMonth();
                    $fecha_vencimiento->day = min($dia_renovacion, $fecha_vencimiento->daysInMonth);
                }

                while ($fecha_vencimiento->lte($fecha_actual)) {
                    $fecha_vencimiento->addMonth();
                    $fecha_vencimiento->day = min($dia_renovacion, $fecha_vencimiento->daysInMonth);
                }
            }
            elseif ($renovacion->frecuencia == 'Anual' && $renovacion->dia_anual && $renovacion->mes_anual) {
                $dia_vencimiento = (int) $renovacion->dia_anual;
                $mes_vencimiento = (int) $renovacion->mes_anual;
                $anio_base = $renovacion->anio_anual ?? $fecha_actual->year;

                try {
                    $fecha_vencimiento = Carbon::create($anio_base, $mes_vencimiento, $dia_vencimiento)->startOfDay();
                } catch (\Exception $e) {
                    $fecha_vencimiento = Carbon::create($anio_base, $mes_vencimiento, 1)
                        ->endOfMonth()
                        ->startOfDay();
                }

                while ($fecha_vencimiento->lte($fecha_actual)) {
                    $fecha_vencimiento->addYear();
                }
            }

            if ($fecha_vencimiento) {
                $dias_diferencia = $fecha_actual->diffInDays($fecha_vencimiento, false);
                $dias_restantes_numero = $dias_diferencia;

                if ($dias_diferencia < 0) {
                    $dias_restantes_texto = abs($dias_diferencia) . ' días vencido';
                } elseif ($dias_diferencia == 0) {
                    $dias_restantes_texto = 'Vence hoy';
                } elseif ($dias_diferencia == 1) {
                    $dias_restantes_texto = '1 día';
                } else {
                    $dias_restantes_texto = $dias_diferencia . ' días';
                }
            }
        }

        return view('transaccion.venta.cotizacion.manual.show', compact(
            'j', 'cotizacion', 'empresa', 'cotizacion_m_reg', 'sum', 'igv',
            'sub_total', 'banco', 'banco_count', 'igv_t', 'factura', 'boleta',
            'nota_venta', 'garantia', 'validez', 'forma_pagos', 'end', 'end2',
            'renovacion', 'fecha_vencimiento', 'dias_restantes_texto', 'dias_restantes_numero'
        ));
    }
    public function print($id){
        $empresa=Empresa::first();
        $cotizacion=CotizacionManual::find($id);
        $cotizacion_m_reg=CotizacionManual_registros::where('cotizacion_m_id',$id)->get();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $banco_count = count($banco);
        $j = 1;

        //SUBTOTAL
        $sub_total = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
        //IGV
        $igv = round( $cotizacion->op_gravada ,2) * $igv->igv_total/100;
        //TOTAL
        $end = round($sub_total, 2) + round($igv,2);
        $end2 = number_format(round($sub_total,2) + round($igv ,2),2);

        // VERIFICAR SI EXISTE RENOVACIÓN
        $renovacion = RenovacionVentas::where('cotizacion_manual_id', $id)
            ->with('cotizacionManual')
            ->first();

        $fecha_vencimiento = null;
        $dias_restantes_texto = null;
        $dias_restantes_numero = null;

        if ($renovacion && $renovacion->cotizacionManual) {
            $fecha_actual = Carbon::now();
            $fecha_emision = Carbon::parse($renovacion->cotizacionManual->fecha_emision);

        // CALCULAR FECHA DE VENCIMIENTO
        if ($renovacion->frecuencia == 'Mensual' && $renovacion->dia_mensual) {
            $dias_acumulados = (int) $renovacion->dia_mensual;

            $fecha_vencimiento = $fecha_emision->copy()->addDays($dias_acumulados);

            while ($fecha_vencimiento->isPast()) {
                $fecha_vencimiento->addDays($dias_acumulados);
            }

        } elseif ($renovacion->frecuencia == 'Anual' && $renovacion->dia_anual) {
            $dias_acumulados = (int) $renovacion->dia_anual;

            $fecha_vencimiento = $fecha_emision->copy()->addDays($dias_acumulados);

            while ($fecha_vencimiento->isPast()) {
                $fecha_vencimiento->addYear();
            }
        }

            // CALCULAR DÍAS RESTANTES
            if ($fecha_vencimiento) {
                $dias_diferencia = $fecha_actual->diffInDays($fecha_vencimiento, false);
                $dias_restantes_numero = $dias_diferencia;

                if ($dias_diferencia < 0) {
                    $dias_restantes_texto = abs($dias_diferencia) . ' días vencido';
                } elseif ($dias_diferencia == 0) {
                    $dias_restantes_texto = 'Vence hoy';
                } elseif ($dias_diferencia == 1) {
                    $dias_restantes_texto = $dias_diferencia . ' día';
                } else {
                    $dias_restantes_texto = $dias_diferencia . ' días';
                }
            }
        }

        return view('transaccion.venta.cotizacion.manual.print', compact('j','cotizacion','empresa','cotizacion_m_reg','sum','igv','sub_total','banco','banco_count','sub_total','igv','end','end2','renovacion', 'fecha_vencimiento', 'dias_restantes_texto', 'dias_restantes_numero'));
    }
    public function pdf(Request $request,$id){

        $name = $request->get('name');
        $empresa=Empresa::first();
        $cotizacion=CotizacionManual::find($id);
        $cotizacion_m_reg=CotizacionManual_registros::where('cotizacion_m_id',$id)->get();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        // $banco_registros=Banco::where('estado',0)->get();
        // $
        // $banco_count = count($banco_registros);
        $j = 1;

        //SUBTOTAL
        $sub_total = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
        //IGV
        $igv = round( $cotizacion->op_gravada ,2) * $igv->igv_total/100;
        //TOTAL
        $end = round($sub_total, 2) + round($igv,2);
        $end2 = number_format(round($sub_total,2) + round($igv ,2),2);

        // $archivo=$name.'_'.$id;

        // VERIFICAR SI EXISTE RENOVACIÓN
        $renovacion = RenovacionVentas::where('cotizacion_manual_id', $id)
            ->with('cotizacionManual')
            ->first();

        $fecha_vencimiento = null;
        $dias_restantes_texto = null;
        $dias_restantes_numero = null;

        if ($renovacion && $renovacion->cotizacionManual) {
            $fecha_actual = Carbon::now();
            $fecha_emision = Carbon::parse($renovacion->cotizacionManual->fecha_emision);

        // CALCULAR FECHA DE VENCIMIENTO
        if ($renovacion->frecuencia == 'Mensual' && $renovacion->dia_mensual) {
            $dias_acumulados = (int) $renovacion->dia_mensual;

            $fecha_vencimiento = $fecha_emision->copy()->addDays($dias_acumulados);

            while ($fecha_vencimiento->isPast()) {
                $fecha_vencimiento->addDays($dias_acumulados);
            }

        } elseif ($renovacion->frecuencia == 'Anual' && $renovacion->dia_anual && $renovacion->mes_anual) {
            // ✅ AHORA USA EL DÍA ESPECÍFICO GUARDADO
            $dia_vencimiento = (int) $renovacion->dia_anual;
            $mes_vencimiento = (int) $renovacion->mes_anual;
            $anio_vencimiento = $renovacion->anio_anual ?? $fecha_actual->year;

            // Crear fecha con el día específico seleccionado
            try {
                $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, $dia_vencimiento);
            } catch (\Exception $e) {
                // Si el día no existe en ese mes (ej: 31 de febrero), usar último día del mes
                $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, 1)->endOfMonth();
            }

            // Si ya pasó, agregar un año
            if ($fecha_vencimiento->isPast()) {
                $fecha_vencimiento->addYear();
            }
        }

            // CALCULAR DÍAS RESTANTES
            if ($fecha_vencimiento) {
                $dias_diferencia = $fecha_actual->diffInDays($fecha_vencimiento, false);
                $dias_restantes_numero = $dias_diferencia;

                if ($dias_diferencia < 0) {
                    $dias_restantes_texto = abs($dias_diferencia) . ' días vencido';
                } elseif ($dias_diferencia == 0) {
                    $dias_restantes_texto = 'Vence hoy';
                } elseif ($dias_diferencia == 1) {
                    $dias_restantes_texto = $dias_diferencia . ' día';
                } else {
                    $dias_restantes_texto = $dias_diferencia . ' días';
                }
            }
        }

        $pdf=PDF::loadView('transaccion.venta.cotizacion.manual.pdf', compact('j','cotizacion','empresa','cotizacion_m_reg','sum','igv','sub_total','sub_total','igv','end','end2', 'renovacion',
                'fecha_vencimiento',
                'dias_restantes_texto',
                'dias_restantes_numero'));

        return $pdf->download($cotizacion->cod_cotizacion.'.pdf');

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // agregar la funcion del checkbox apra q se mande a la bd
public function update(Request $request, $id)
{
    $cotizacion = CotizacionManual::find($id);
    $cotizacion->cliente_id = $request->get('cliente');
    $cotizacion->forma_pago_id = $request->get('forma_pago');
    $cotizacion->garantia = $request->get('garantia');
    $cotizacion->validez = $request->get('validez');
    $cotizacion->observacion = $request->get('observacion');
    $cotizacion->save();
    $cotizacion_reg = CotizacionManual_registros::where('cotizacion_m_id',$cotizacion->id)->get();

    //PRODUCTOS POR CODIGOS
    $art = $request->input('articulo');
    $count_cantidad_p = count($art);
    for($i=0 ; $i<$count_cantidad_p;$i++){
        $articulos[$i]= $request->input('articulo')[$i];
        $producto_id_name[$i]=strstr($articulos[$i], '|');
        $producto_id_2[$i]=strstr($producto_id_name[$i], ' ');
        $producto_id_3[$i]=substr(strstr($producto_id_2[$i], ' '),1);
        $articulo_cod[$i]=strstr($producto_id_3[$i], ' ', true);
    }

    //UPDATE
    if($cotizacion->estado == 0 && $cotizacion->estado_vigente == 0 ){
        // REGISTROS EXISTENTES
        $n_registros_ori = $request->get('n_registros_ori');
        $n_r_ori_c = count($n_registros_ori);

        $var =$request->get('elem_delete');
        // ELIMINAR LOS QUE ESTAN DELETE
        if( isset( $var )){
            $cotizacion_m_reg_delete = CotizacionManual_registros::where('cotizacion_m_id',$cotizacion->id) ->whereNotIn('id', $request->get('elem_delete'))->get();
        }else{
            $cotizacion_m_reg_delete = CotizacionManual_registros::where('cotizacion_m_id',$cotizacion->id)->get();
        }
        for ($i=0; $i < count($cotizacion_m_reg_delete) ; $i++) {
            CotizacionManual_registros::Destroy($cotizacion_m_reg_delete[$i]->id);
        }
        $cotizacion_m_est_v=CotizacionManual::find($cotizacion->id);
        $cotizacion_m_est_v->op_gravada = 0;
        $cotizacion_m_est_v->op_inafecta = 0;
        $cotizacion_m_est_v->op_exonerada = 0;
        $cotizacion_m_est_v->fecha_emision = Carbon::now()->format('d-m-Y');
        $cotizacion_m_est_v->save();

        //nuevos registros
        for ($h=0; $h < $n_r_ori_c ; $h++) {
            $producto = Producto::where('codigo_producto', $articulo_cod[$h])->first();
            $servicio = Servicios::where('codigo_servicio', $articulo_cod[$h])->first();
            if($request->get('n_registros_ori')[$h] == "existente"){
                $cotizacion_r_upd_new = CotizacionManual_registros::find($request->get('elem_delete')[$h]);
                if(isset($producto)){
                    $cotizacion_r_upd_new->producto_id= $producto->id;
                    $cotizacion_r_upd_new->descripcion_item = $request->get('descripcion_item')[$h];
                    $cotizacion_r_upd_new->cantidad= $request->get('cantidad')[$h];
                    $cotizacion_r_upd_new->precio= $request->get('precio_s_igv')[$h];
                    $cotizacion_r_upd_new->save();
                    //operaciones para SUNAT
                    $cotizacion_m = CotizacionManual::find($cotizacion->id);
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                        $cotizacion_m->op_gravada += round($cotizacion_r_upd_new->precio * $cotizacion_r_upd_new->cantidad,2 );
                    }
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                        $cotizacion_m->op_inafecta += round($cotizacion_r_upd_new->precio * $cotizacion_r_upd_new->cantidad,2 );
                    }
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                        $cotizacion_m->op_exonerada += round($cotizacion_r_upd_new->precio * $cotizacion_r_upd_new->cantidad,2 );
                    }
                    $cotizacion_m->save();
                }else{
                    $cotizacion_r_upd_new->servicio_id = $servicio->id;
                    $cotizacion_r_upd_new->descripcion_item = $request->get('descripcion_item')[$h];
                    $cotizacion_r_upd_new->cantidad= $request->get('cantidad')[$h];
                    $cotizacion_r_upd_new->precio= $request->get('precio_s_igv')[$h];
                    $cotizacion_r_upd_new->save();
                    $cotizacion_m = CotizacionManual::find($cotizacion->id);
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                        $cotizacion_m->op_gravada += round($cotizacion_r_upd_new->precio * $cotizacion_r_upd_new->cantidad,2 );
                    }
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                        $cotizacion_m->op_inafecta += round($cotizacion_r_upd_new->precio * $cotizacion_r_upd_new->cantidad,2 );
                    }
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                        $cotizacion_m->op_exonerada += round($cotizacion_r_upd_new->precio * $cotizacion_r_upd_new->cantidad,2 );
                    }
                    $cotizacion_m->save();
                }

            }else{
                $cotizacion_r_upd_new = new CotizacionManual_registros;
                $cotizacion_r_upd_new->cotizacion_m_id = $cotizacion->id;
                if(isset($producto)){
                    $cotizacion_r_upd_new->producto_id= $producto->id;
                    $cotizacion_r_upd_new->descripcion_item = $request->get('descripcion_item')[$h];
                    $cotizacion_r_upd_new->cantidad= $request->get('cantidad')[$h];
                    $cotizacion_r_upd_new->precio= $request->get('precio_s_igv')[$h];
                    $cotizacion_r_upd_new->save();
                    $cotizacion_m = CotizacionManual::find($cotizacion->id);
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                        $cotizacion_m->op_gravada += round($cotizacion_r_upd_new->precio * $cotizacion_r_upd_new->cantidad,2 );
                    }
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                        $cotizacion_m->op_inafecta += round($cotizacion_r_upd_new->precio * $cotizacion_r_upd_new->cantidad,2 );
                    }
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                        $cotizacion_m->op_exonerada += round($cotizacion_r_upd_new->precio * $cotizacion_r_upd_new->cantidad,2 );
                    }
                    $cotizacion_m->save();
                }else{
                    $cotizacion_r_upd_new->servicio_id = $servicio->id;
                    $cotizacion_r_upd_new->descripcion_item = $request->get('descripcion_item')[$h];
                    $cotizacion_r_upd_new->cantidad= $request->get('cantidad')[$h];
                    $cotizacion_r_upd_new->precio= $request->get('precio_s_igv')[$h];
                    $cotizacion_r_upd_new->save();
                    $cotizacion_m = CotizacionManual::find($cotizacion->id);
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                        $cotizacion_m->op_gravada += round($cotizacion_r_upd_new->precio * $cotizacion_r_upd_new->cantidad,2 );
                    }
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                        $cotizacion_m->op_inafecta += round($cotizacion_r_upd_new->precio * $cotizacion_r_upd_new->cantidad,2 );
                    }
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                        $cotizacion_m->op_exonerada += round($cotizacion_r_upd_new->precio * $cotizacion_r_upd_new->cantidad,2 );
                    }
                    $cotizacion_m->save();
                }
            }
        }
        $submit=$request->get('submit');
        if($submit == 2){
            $cotizacion_m_est_v=CotizacionManual::find($cotizacion->id);
            $cotizacion_m_est_v->estado_vigente = 1;
            $cotizacion_m_est_v->save();
        }
    }

    if ($request->has('estado_renovacion') && $request->estado_renovacion == 1) {
    // Buscar o crear renovación
    $renovacion = RenovacionVentas::firstOrNew([
        'cotizacion_manual_id' => $cotizacion->id
    ]);

    $renovacion->frecuencia = $request->select_fecha;
    $renovacion->estado = 1;

    if ($request->select_fecha == 'Mensual') {
        $renovacion->dia_mensual = (int) $request->dia_mensual;
        $renovacion->dia_anual = null;
        $renovacion->mes_anual = null;
        $renovacion->anio_anual = null;

    } elseif ($request->select_fecha == 'Anual') {
        $renovacion->dia_mensual = null;
        $renovacion->dia_anual = (int) $request->dia_anual;
        $renovacion->mes_anual = (int) $request->mes_anual;
        $renovacion->anio_anual = (int) $request->anio_anual;
    }

    $renovacion->save();

} else {
    // Si se desmarcó el checkbox, desactivar renovación
    $renovacion = RenovacionVentas::where('cotizacion_manual_id', $cotizacion->id)->first();
    if ($renovacion) {
        $renovacion->estado = 0;
        $renovacion->save();
    }
}
    return back()->with('success', 'Cotización actualizada correctamente');
}

    public function facturar(Request $request,$id){


        //REDIRECCION PARA NO MOSTRAR ERROR LARAVEL DE ID SHOW
        $existe_id=CotizacionManual::where('id',$id)->first();
        if(empty($existe_id)){ return redirect()->route('cotizacion_manual.index'); }

        $cotizacion = CotizacionManual::where('id',$id)->first();
        $cotizacion_registros = CotizacionManual_registros::where('cotizacion_m_id',$cotizacion->id)->get();

        $cod_guia= Codigo_guia_almacen::where('almacen_id',$cotizacion->almacen_id)->first();
        $factura_cod_fac=$cod_guia->cod_factura_m;
        if (is_numeric($factura_cod_fac)) {
            // expresión del numero de factura
            $factura_cod_fac++;
            $sucursal_nr = str_pad($cod_guia->serie_factura_m, 2, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);
        }else{
                // expresión del numero de factura
                // GENERACIÓN DE NUMERO DE FACTURA
            $ultima_factura=Facturacion_m::where('almacen_id',$cotizacion->almacen_id)->latest()->first();
            $factura_num=$ultima_factura->codigo_fac;
            $factura_num_string_porcion= explode("-", $factura_num);
            $factura_num_string=$factura_num_string_porcion[1];
            $factura_num=(int)$factura_num_string;

            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_factura_m','DESC')->latest()->first();
                //CONDICIONAL PARA QUE EMPIECE DE NUEVO EN 0001 PARA EL NUMERO DE SERIE Y EL CORRELATIVO -> FALTA PULIR/IDEA GENERAL
            if($factura_num == 99999999){
                $ultima_factura = $almacen_codigo->serie_factura_m+1;
                $factura_num = 00000000;

            }else{
                $ultima_factura = $cod_guia->serie_factura_m;
            }
            $factura_num++;
            $sucursal_nr = str_pad($ultima_factura, 2, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_num, 8, "0", STR_PAD_LEFT);
        }

        $factura_numero="FA".$sucursal_nr."-".$factura_nr;
        $forma_pagos = Forma_pago::get();
        $empresa = Empresa::first();
        $igv = Igv::first();
        // $bancos = Bancos::all();
        $fecha_hoy = Carbon::now()->add(1,'day');
        $fecha_1 = $fecha_hoy->format('Y-m-d');
        return view('transaccion.venta.cotizacion.manual.facturar', compact('cotizacion','cotizacion_registros','empresa','factura_numero','forma_pagos','igv','fecha_1'));
    }

    public function facturar_store(Request $request){

        // return $request;
        $id = $request->get('id_cotizador');
        $cotizacion = CotizacionManual::where('id',$id)->first();
        $cotizacion_registros = CotizacionManual_registros::where('cotizacion_m_id',$cotizacion->id)->get();

        $cod_guia= Codigo_guia_almacen::where('almacen_id',$cotizacion->almacen_id)->first();
        $factura_cod_fac=$cod_guia->cod_factura_m;
        if (is_numeric($factura_cod_fac)) {
            // expresión del numero de factura
            $factura_cod_fac++;
            $sucursal_nr = str_pad($cod_guia->serie_factura_m, 2, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);
        }else{
                // expresión del numero de factura
                // GENERACIÓN DE NUMERO DE FACTURA
            $ultima_factura=Facturacion_m::where('almacen_id',$cotizacion->almacen_id)->latest()->first();
            $factura_num=$ultima_factura->codigo_fac;
            $factura_num_string_porcion= explode("-", $factura_num);
            $factura_num_string=$factura_num_string_porcion[1];
            $factura_num=(int)$factura_num_string;

            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_factura_m','DESC')->latest()->first();
                //CONDICIONAL PARA QUE EMPIECE DE NUEVO EN 0001 PARA EL NUMERO DE SERIE Y EL CORRELATIVO -> FALTA PULIR/IDEA GENERAL
            if($factura_num == 99999999){
                $ultima_factura = $almacen_codigo->serie_factura_m+1;
                $almacen_save_last = Codigo_guia_almacen::find($cotizacion->almacen_id);
                $almacen_save_last->serie_factura_m = $almacen_codigo->serie_factura_m+1;
                $almacen_save_last->save();
                $factura_num = 00000000;

            }else{
                $ultima_factura = $cod_guia->serie_factura_m;
            }
            $factura_num++;
            $sucursal_nr = str_pad($ultima_factura, 2, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_num, 8, "0", STR_PAD_LEFT);
        }

        $factura_numero="FA".$sucursal_nr."-".$factura_nr;

        // obtención de forma de pago
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

        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }


        //Store en FacturacionmMnual
        $facturacion=new Facturacion_m;
        $facturacion->codigo_fac=$factura_numero;
        $facturacion->almacen_id=$cotizacion->almacen_id;
        $facturacion->cotizador_id=$cotizacion->id;
        $facturacion->orden_compra=$request->get('orden_compra');
        $facturacion->guia_remision=$request->get('guia_remision');
        $facturacion->cliente_id=$cotizacion->cliente_id;
        $facturacion->moneda_id=$cotizacion->moneda_id;
        $facturacion->forma_pago_id=$request->get('forma_pago');
        $facturacion->fecha_emision=$request->get('fecha_emision');
        $facturacion->fecha_vencimiento=$nuevafechas;
        $facturacion->cambio=$cambio->paralelo;
        $facturacion->observacion=$request->get('observacion');
        $facturacion->user_id =auth()->user()->id;
        $facturacion->estado='0';
        $facturacion->tipo_operacion_id= $cotizacion->tipo_operacion_id;
        $facturacion->tipo_documento_id = $cotizacion->tipo_documento_id;
        $facturacion->save();

        //CAMBIAR EL ESTADO DE LA COTIZACION
        $cotizacion=CotizacionManual::where('id',$cotizacion->id)->first();
        $cotizacion->estado=1;
        $cotizacion->save();

        // modificación para que se cierre el codigo en almacen
        $factura_primera=Codigo_guia_almacen::where('id', $cotizacion->almacen_id)->first();
        if(is_numeric($factura_primera->cod_factura_m)){
            $factura_primera->cod_factura_m='NN';
            $factura_primera->save();
        }

         //Registro de forma de pago
        if($facturacion->forma_pago_id == 2){

            $fecha_pago = $request->input('fecha_pago');
            $contador_for = count($fecha_pago);
            $monto_pago = $request->input('monto_pago');
                    // foreach($contador_for as $cuotas => $index ){
            for($c = 0; $c<$contador_for;$c++ ){
                $cuota_cred = new Cuotas_credito;
                $cuota_cred->facturacion_m_id = $facturacion->id;
                $cuota_cred->numero_cuota = $c+1;
                $cuota_cred->monto = $monto_pago[$c];
                $cuota_cred->fecha_pago = $fecha_pago[$c];
                $cuota_cred->save();
            }
        }

        //GUARDADO DE REGISTROS
        foreach ($cotizacion_registros as $index_val => $cotizacion_registros2) {
            $producto = Producto::where('id',$cotizacion_registros2->producto_id)->first();

            if(isset($producto->id)){
                $factura_registro = new Facturacion_registro_m;
                $factura_registro->facturacion_m_id = $facturacion->id;
                $factura_registro->producto_id = $cotizacion_registros2->producto_id;
                $factura_registro->descripcion_item = $request->get('descripcion_item')[$index_val];
                $factura_registro->numero_serie = $request->get('numero_serie')[$index_val];
                $factura_registro->cantidad = $cotizacion_registros2->cantidad;
                $factura_registro->precio = $cotizacion_registros2->precio;
                $factura_registro->save();

                $facturacion_2=Facturacion_m::find($facturacion->id);
                if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                    $facturacion_2->op_gravada += round($factura_registro->precio*$factura_registro->cantidad,2);
                }
                if(strpos($producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                    $facturacion_2->op_exonerada += round($factura_registro->precio*$factura_registro->cantidad,2);
                }
                if(strpos($producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                    $facturacion_2->op_inafecta += round($factura_registro->precio*$factura_registro->cantidad,2);
                }
                $facturacion_2->save();
            }else{
                $servicio=Servicios::where('id',$cotizacion_registros2->servicio_id)->where('estado_anular',0)->first();
                $factura_registro = new Facturacion_registro_m;
                $factura_registro->facturacion_m_id = $facturacion->id;
                $factura_registro->servicio_id = $cotizacion_registros2->servicio_id;
                $factura_registro->descripcion_item = $request->get('descripcion_item')[$index_val];
                $factura_registro->numero_serie = $request->get('numero_serie')[$index_val];
                $factura_registro->cantidad = $cotizacion_registros2->cantidad;
                $factura_registro->precio = $cotizacion_registros2->precio;
                $factura_registro->save();

                $facturacion_2=Facturacion_m::find($facturacion->id);
                if(strpos($servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                    $facturacion_2->op_gravada += round($factura_registro->precio*$factura_registro->cantidad,2);
                }
                if(strpos($servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                    $facturacion_2->op_exonerada += round($factura_registro->precio*$factura_registro->cantidad,2);
                }
                if(strpos($servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                    $facturacion_2->op_inafecta += round($factura_registro->precio*$factura_registro->cantidad,2);
                }
                $facturacion_2->save();
            }
        }
        return redirect()->route('facturacion_manual.show',$facturacion->id);
    }
    public function boletear(Request $request,$id){
        // return $request;
        //REDIRECCION PARA NO MOSTRAR ERROR LARAVEL DE ID SHOW
        $existe_id=CotizacionManual::where('id',$id)->first();
        if(empty($existe_id)){ return redirect()->route('cotizacion_manual.index'); }

        $cotizacion = CotizacionManual::where('id',$id)->first();
        $cotizacion_registros = CotizacionManual_registros::where('cotizacion_m_id',$cotizacion->id)->get();

        $cod_guia= Codigo_guia_almacen::where('almacen_id',$cotizacion->almacen_id)->first();
        $boleta_cod_bol=$cod_guia->cod_boleta_m;
        if (is_numeric($boleta_cod_bol)) {
            // expresión del numero de factura
            $boleta_cod_bol++;
            $sucursal_nr = str_pad($cod_guia->serie_boleta_m, 2, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($boleta_cod_bol, 8, "0", STR_PAD_LEFT);
        }else{
                // expresión del numero de factura
                // GENERACIÓN DE NUMERO DE FACTURA
            $ultima_boleta=Boleta_m::where('almacen_id',$cotizacion->almacen_id)->latest()->first();
            $boleta_num=$ultima_boleta->codigo_boleta;
            $boleta_num_string_porcion= explode("-", $boleta_num);
            $boleta_num_string=$boleta_num_string_porcion[1];
            $boleta_num=(int)$boleta_num_string;

            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_boleta_m','DESC')->latest()->first();
                //CONDICIONAL PARA QUE EMPIECE DE NUEVO EN 0001 PARA EL NUMERO DE SERIE Y EL CORRELATIVO -> FALTA PULIR/IDEA GENERAL
            if($boleta_num == 99999999){
                $ultima_boleta = $almacen_codigo->serie_boleta_m+1;
                $boleta_num = 00000000;

            }else{
                $ultima_boleta = $cod_guia->serie_boleta_m;
            }
            $boleta_num++;
            $sucursal_nr = str_pad($ultima_boleta, 2, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
        }

        $boleta_numero="BA".$sucursal_nr."-".$factura_nr;
        $forma_pagos = Forma_pago::get();
        $empresa = Empresa::first();
        $igv = Igv::first();
        $fecha_hoy = Carbon::now()->add(1,'day');
        $fecha_1 = $fecha_hoy->format('Y-m-d');
        // return $cotizacion;
        return view('transaccion.venta.cotizacion.manual.boletear', compact('cotizacion','cotizacion_registros','empresa','boleta_numero','forma_pagos','igv','fecha_1'));
    }
    public function boletear_store(Request $request){
        // return $request;
        $id  = $request->get('id_cotizador');
        $cotizacion = CotizacionManual::where('id', $id)->first();
        $cotizacion_registros = CotizacionManual_registros::where('cotizacion_m_id', $cotizacion->id)->get();

        $cod_guia = Codigo_guia_almacen::where('almacen_id', $cotizacion->almacen_id)->first();
        $boleta_cod_bol = $cod_guia->cod_boleta_m;
        if(is_numeric($boleta_cod_bol)){
            $boleta_cod_bol++;
            $sucursal_nr = str_pad($cod_guia->serie_boleta_m, 2, "0", STR_PAD_LEFT);
            $boleta_nr = str_pad($boleta_cod_bol, 8, "0", STR_PAD_LEFT);
        }else{
                // expresión del numero de factura
            // GENERACIÓN DE NUMERO DE FACTURA
            $ultima_boleta=Boleta_m::where('almacen_id',$cotizacion->almacen_id)->latest()->first();
            $boleta_num=$ultima_boleta->codigo_boleta;
            $boleta_num_string_porcion= explode("-", $boleta_num);
            $boleta_num_string=$boleta_num_string_porcion[1];
            $boleta_num=(int)$boleta_num_string;

            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_boleta_m','DESC')->latest()->first();
                //CONDICIONAL PARA QUE EMPIECE DE NUEVO EN 0001 PARA EL NUMERO DE SERIE Y EL CORRELATIVO -> FALTA PULIR/IDEA GENERAL
            if($boleta_num == 99999999){

                $ultima_boleta = $almacen_codigo->serie_boleta_m+1;
                $almacen_save_last = Codigo_guia_almacen::find($cotizacion->almacen_id);
                $almacen_save_last->serie_boleta_m = $almacen_codigo->serie_boleta_m+1;
                $almacen_save_last->save();
                $boleta_num = 00000000;
            }else{
                $ultima_boleta = $cod_guia->serie_boleta_m;
            }
            $boleta_num++;
            $sucursal_nr = str_pad($ultima_boleta, 2, "0", STR_PAD_LEFT);
            $boleta_nr=str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
        }
        $boleta_numero="BA".$sucursal_nr."-".$boleta_nr;
        // obtención de forma de pago
        $forma_pago_id=$request->get('forma_pago');
        if($forma_pago_id == 1){
            $val = $request->get('fecha_vencimiento');
            $nuevafechas = date('d-m-Y', strtotime(($val)));
        }else{
            $fecha_pago_forma = $request->input('fecha_pago');
            $contador_for_1 = count($fecha_pago_forma);
            for($c = 0; $c < $contador_for_1;$c++ ){
                $val = $fecha_pago_forma[$c];
            }
            $nuevafechas = date('d-m-Y', strtotime(($val)));
        }

        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }
        $boleta = new Boleta_m;
        $boleta->codigo_boleta = $boleta_numero;
        $boleta->cotizador_id=$cotizacion->id;
        $boleta->almacen_id = $cotizacion->almacen_id;
        $boleta->cliente_id = $cotizacion->cliente_id;
        $boleta->orden_compra = $request->get('orden_compra');
        $boleta->guia_remision = $request->get('guia_remision');
        $boleta->moneda_id = $cotizacion->moneda_id;
        $boleta->forma_pago_id = $cotizacion->forma_pago_id;
        $boleta->fecha_emision = $request->get('fecha_emision');
        $boleta->fecha_vencimiento = $nuevafechas;
        $boleta->cambio = $cambio->paralelo;
        $boleta->observacion = $request->get('observacion');
        $boleta->user_id =auth()->user()->id;
        $boleta->estado='0';
        $boleta->tipo_operacion_id= $cotizacion->tipo_operacion_id;
        $boleta->tipo_documento_id = 3;
        $boleta->save();
        // modificación para que se cierre el codigo en almacen
        $boleta_primera=Codigo_guia_almacen::where('id', $cotizacion->almacen_id)->first();
        if(is_numeric($boleta_primera->cod_boleta_m)){
            $boleta_primera->cod_boleta_m='NN';
            $boleta_primera->save();
        }

         //Registro de forma de pago
        if($boleta->forma_pago_id == 2){

            $fecha_pago = $request->input('fecha_pago');
            $contador_for = count($fecha_pago);
            $monto_pago = $request->input('monto_pago');
                    // foreach($contador_for as $cuotas => $index ){
            for($c = 0; $c<$contador_for;$c++ ){
                $cuota_cred = new Cuotas_credito;
                $cuota_cred->boleta_m_id = $boleta->id;
                $cuota_cred->numero_cuota = $c+1;
                $cuota_cred->monto = $monto_pago[$c];
                $cuota_cred->fecha_pago = $fecha_pago[$c];
                $cuota_cred->save();
            }
        }

        //CAMBIAR EL ESTADO DE LA COTIZACION
        $cotizacion=CotizacionManual::where('id',$cotizacion->id)->first();
        $cotizacion->estado=1;
        $cotizacion->save();

        //GUARDADO DE REGISTROS
        foreach ($cotizacion_registros as $index_val => $cotizacion_registros2) {
            $producto = Producto::where('id',$cotizacion_registros2->producto_id)->first();

            if(isset($producto->id)){
                $boleta_registro = new Boleta_registros_m;
                $boleta_registro->boleta_m_id = $boleta->id;
                $boleta_registro->producto_id = $cotizacion_registros2->producto_id;
                $boleta_registro->descripcion_item = $request->get('descripcion_item')[$index_val];
                $boleta_registro->numero_serie = $request->get('numero_serie')[$index_val];
                $boleta_registro->cantidad = $cotizacion_registros2->cantidad;
                $boleta_registro->precio = $cotizacion_registros2->precio;
                $boleta_registro->save();

                $boleta_2=Boleta_m::find($boleta->id);
                if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                    $boleta_2->op_gravada += round($boleta_registro->precio*$boleta_registro->cantidad,2);
                }
                if(strpos($producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                    $boleta_2->op_exonerada += round($boleta_registro->precio*$boleta_registro->cantidad,2);
                }
                if(strpos($producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                    $boleta_2->op_inafecta += round($boleta_registro->precio*$boleta_registro->cantidad,2);
                }
                $boleta_2->save();
            }else{
                $servicio=Servicios::where('id',$cotizacion_registros2->servicio_id)->where('estado_anular',0)->first();
                $boleta_registro = new Boleta_registros_m;
                $boleta_registro->boleta_m_id = $boleta->id;
                $boleta_registro->servicio_id = $cotizacion_registros2->servicio_id;
                $boleta_registro->descripcion_item = $request->get('descripcion_item')[$index_val];
                $boleta_registro->numero_serie = $request->get('numero_serie')[$index_val];
                $boleta_registro->cantidad = $cotizacion_registros2->cantidad;
                $boleta_registro->precio = $cotizacion_registros2->precio;
                $boleta_registro->save();

                $boleta_2=Boleta_m::find($boleta->id);
                if(strpos($servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                    $boleta_2->op_gravada += round($boleta_registro->precio*$boleta_registro->cantidad,2);
                }
                if(strpos($servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                    $boleta_2->op_exonerada += round($boleta_registro->precio*$boleta_registro->cantidad,2);
                }
                if(strpos($servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                    $boleta_2->op_inafecta += round($boleta_registro->precio*$boleta_registro->cantidad,2);
                }
                $boleta_2->save();
            }
        }

        return redirect()->route('boleta_manual.show',$boleta->id);
    }

    public function gen_nota_venta(Request $request, $id){

        $empresa = Empresa::first();
        $forma_pagos = Forma_pago::get();
        $igv = Igv::first();
        $cotizacion = CotizacionManual::where('id', $id)->first();
        $cotizacion_registros = CotizacionManual_registros::where('cotizacion_m_id', $cotizacion->id)->get();

        // Numero de Nota de Venta
        $count_nota_venta=NotaVenta::where('almacen_id',$cotizacion->almacen_id)->count();
        $count_nota_venta++;
        $sucursal_nr = str_pad($cotizacion->almacen_id, 3, "0", STR_PAD_LEFT);
        $correlativo=str_pad($count_nota_venta, 8, "0", STR_PAD_LEFT);
        $cod_nota_venta="NV ".$sucursal_nr."-".$correlativo;
        // return $request;

        return view('transaccion.venta.cotizacion.manual.nota_venta',compact('empresa','forma_pagos','cotizacion','cotizacion_registros','cod_nota_venta','igv'));
    }
    public function nota_venta_store(Request $request){
        // return $request;

        $igv = Igv::first();
        $cotizacion = CotizacionManual::where('id', $request->get('id_cotizador'))->first();
        $registros = CotizacionManual_registros::where('cotizacion_m_id',$cotizacion->id)->get();

        // Numero de Nota de Venta
        $count_nota_venta=NotaVenta::where('almacen_id',$request->almacen_id)->count();
        $count_nota_venta++;
        $sucursal_nr = str_pad($request->almacen_id, 3, "0", STR_PAD_LEFT);
        $correlativo=str_pad($count_nota_venta, 8, "0", STR_PAD_LEFT);
        $cod_nota_venta="NV ".$sucursal_nr."-".$correlativo;


        // Guardado de Nota de Venta

        $nota_venta=new NotaVenta;
        $nota_venta->cod_nota_venta=$cod_nota_venta;
        $nota_venta->id_cotizacion_m=$cotizacion->id;
        $nota_venta->cliente_id=$cotizacion->cliente_id;
        $nota_venta->almacen_id=$cotizacion->almacen_id;
        $nota_venta->forma_pago=$request->forma_pago;
        $nota_venta->garantia=$request->garantia;
        $nota_venta->moneda_id=$cotizacion->moneda_id;
        $nota_venta->fecha_emision=$request->fecha_emision;
        $nota_venta->observacion=$request->observacion;
        $nota_venta->user_registrado=auth()->user()->id;
        $nota_venta->estado_vigente = 0;
        $nota_venta->save();

        $cotizacion=CotizacionManual::where('id',$cotizacion->id)->first();
        $cotizacion->estado=1;
        $cotizacion->save();


        foreach ($registros as $i => $new_reg) {
            $reg_nota_v= new NotaVentaRegistro();
            $reg_nota_v->nota_venta_id=$nota_venta->id;
            if(isset($new_reg->producto_id)){
                $reg_nota_v->producto=$new_reg->producto->nombre;
            }else{
                $reg_nota_v->producto=$new_reg->servicio->nombre;
            }
            $reg_nota_v->descripcion=$request->get('descripcion_item')[$i];
            $reg_nota_v->cantidad=$new_reg->cantidad;
            $reg_nota_v->precio_nacional=round($new_reg->precio + ( $new_reg->precio * $igv->igv_total/100),3);
            $reg_nota_v->save();
        }
        return redirect()->route('nota_venta.show',$nota_venta->id);

        // $nota_venta
        // $boleta->id  = 1;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function free_print($id){
        $empresa=Empresa::first();
        $cotizacion_m=CotizacionManual::find($id);
        $cotizacion_m_reg=CotizacionManual_registros::where('cotizacion_m_id',$id)->get();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $banco_count = count($banco);
        $j = 1;

        //SUBTOTAL
        $sub_total = $cotizacion_m->op_gravada + $cotizacion_m->op_inafecta + $cotizacion_m->op_exonerada;
        //IGV
        $igv = round( $cotizacion_m->op_gravada ,2) * $igv->igv_total/100;
        //TOTAL
        $end = round($sub_total, 2) + round($igv,2);
        $end2 = number_format(round($sub_total,2) + round($igv ,2),2);

        return view('transaccion.venta.cotizacion.manual.free_print', compact('j','cotizacion_m','empresa','cotizacion_m_reg','sum','igv','sub_total','banco','banco_count','sub_total','igv','end','end2'));
    }

    //  NUEVAS VISTAS
    public function index2(){
        $mes_año = Carbon::now()->format('d-m-Y');
        $cotizacion_mes = Cotizacion::count_mes($mes_año);
        $cotizacionM_mes = CotizacionManual::count_mes($mes_año);
        $nota_venta_mes = NotaVenta::count_mes($mes_año);

        $count_month_ventas = ComprobantesVentas::count_month_ventas($mes_año);

        $almacen = Almacen::get();

        $count_all_ventas = ComprobantesVentas::count_day_ventas();
        return view('transaccion.venta.cotizacion.manual.index2',compact('count_month_ventas', 'almacen','count_all_ventas'));

    }

    public function exportar_cotizacionesM(Request $request)
    {
        if (ob_get_contents()) {
            ob_end_clean();
        }

        if ($request->has('cotizacion_ids') && !empty($request->input('cotizacion_ids'))) {
            $cotizacionMIds = $request->input('cotizacion_ids');

            $cotizacionesM = CotizacionManual::with([
                'almacen',
                'cliente',
                'moneda',
                'forma_pago',
                'user_personal',
                'tipo_operacion',
                'tipo_documento'
            ])
            ->whereIn('id', $cotizacionMIds)
            ->orderBy('created_at', 'desc')
            ->get();
        } else {

            $filter = $request->get('value');

            $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();
            $tipo = $request->tipo_coti;

            $query = CotizacionManual::with([
                'almacen',
                'cliente',
                'moneda',
                'forma_pago',
                'user_personal',
                'tipo_operacion',
                'tipo_documento'
            ])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc');

            if (!empty($filter)) {
                $query->where(function ($q) use ($filter) {
                    $q->where('cod_cotizacion', 'like', '%' . $filter . '%');
                    $q->orWhereHas('cliente', function ($q) use ($filter) {
                        $q->where('nombre', 'like', '%' . $filter . '%')
                            ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                    });
                    $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');
                    $q->orWhereHas('forma_pago', function ($q) use ($filter) {
                        $q->where('nombre', 'like', '%' . $filter . '%');
                    });
                });
            }

            if ($tipo !== null) {
                $query->where('tipo', $tipo);
            }

            $cotizacionesM = $query->get();
        }

        $headers = [
            'Código cotizacion',
            'Almacén',
            'Cliente',
            'Moneda',
            'Forma de pago',
            'Garantia',
            'Validez',
            'Fecha de emision',
            'Cambio',
            'Observacion',
            'Personal',
            'Estado',
            'Estado vigente',
            'Tipo',
            'Operacion gravada',
            'Operacion inafecta',
            'Operacion Exonerada',
            'Operacion gratuita',
            'Tipo de Operacion',
            'Tipo de Documento',
            'Subtotal',
            'IGV',
            'Importe Total',
            'Tiene Renovación',
            'Frecuencia Renovación',
            'Fecha Vencimiento',
            'Días Restantes'
        ];

        $rows = [$headers];

        $fecha_actual = Carbon::now();

        foreach ($cotizacionesM as $cotizacionM) {
            $almacen = optional($cotizacionM->almacen)->nombre;
            $cliente = optional($cotizacionM->cliente)->nombre;
            $moneda = optional($cotizacionM->moneda)->nombre;
            $formaPago = optional($cotizacionM->forma_pago)->nombre;
            $personal = '';

            if ($cotizacionM->user_personal && $cotizacionM->user_personal->personal) {
                $personal = trim($cotizacionM->user_personal->personal->nombres . ' ' . $cotizacionM->user_personal->personal->apellidos);
            }

            $estado = $cotizacionM->estado ? 'algo' : 'nada';
            $estadoVigente = $cotizacionM->estadoVigente ? 'algo' : 'nada';
            $infoOperacion = optional($cotizacionM->tipo_operacion)->informacion;
            $infoDocumento = optional($cotizacionM->tipo_documento)->informacion;
            $subtotal = ($cotizacionM->op_gravada ?? 0) + ($cotizacionM->op_inafecta ?? 0) + ($cotizacionM->op_exonerada ?? 0);
            $subtotalGravado = ($cotizacionM->op_gravada);
            $igv_p = round(($subtotalGravado ?? 0) * 0.18, 2);
            $importeTotal = round($subtotal + $igv_p, 2);

            // VERIFICAR SI TIENE RENOVACIÓN
            $renovacion = RenovacionVentas::where('cotizacion_manual_id', $cotizacionM->id)->first();

            $tiene_renovacion = 'No';
            $frecuencia_renovacion = '-';
            $fecha_vencimiento_texto = '-';
            $dias_restantes_texto = '-';

            if ($renovacion) {
                $tiene_renovacion = 'Sí';
                $frecuencia_renovacion = $renovacion->frecuencia;

                $fecha_emision = Carbon::parse($cotizacionM->fecha_emision);
                $fecha_vencimiento = null;

                // CALCULAR FECHA DE VENCIMIENTO
                if ($renovacion->frecuencia == 'Mensual' && $renovacion->dia_mensual) {
                    $dias_acumulados = (int) $renovacion->dia_mensual;
                    $fecha_vencimiento = $fecha_emision->copy()->addDays($dias_acumulados);

                    while ($fecha_vencimiento->isPast()) {
                        $fecha_vencimiento->addDays($dias_acumulados);
                    }

                } elseif ($renovacion->frecuencia == 'Anual' && $renovacion->dia_anual && $renovacion->mes_anual) {
                    $dia_vencimiento = (int) $renovacion->dia_anual;
                    $mes_vencimiento = (int) $renovacion->mes_anual;
                    $anio_vencimiento = $renovacion->anio_anual ?? $fecha_actual->year;

                    try {
                        $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, $dia_vencimiento);
                    } catch (\Exception $e) {
                        $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, 1)->endOfMonth();
                    }

                    if ($fecha_vencimiento->isPast()) {
                        $fecha_vencimiento->addYear();
                    }
                }

                // CALCULAR DÍAS RESTANTES
                if ($fecha_vencimiento) {
                    $fecha_vencimiento_texto = $fecha_vencimiento->format('d-m-Y');
                    $dias_diferencia = $fecha_actual->diffInDays($fecha_vencimiento, false);

                    if ($dias_diferencia < 0) {
                        $dias_restantes_texto = abs($dias_diferencia) . ' días vencido';
                    } elseif ($dias_diferencia == 0) {
                        $dias_restantes_texto = 'Vence hoy';
                    } elseif ($dias_diferencia == 1) {
                        $dias_restantes_texto = $dias_diferencia . ' día';
                    } else {
                        $dias_restantes_texto = $dias_diferencia . ' días';
                    }
                }
            }

            $row = [
                $cotizacionM->cod_cotizacion,
                $almacen,
                $cliente,
                $moneda,
                $formaPago,
                $cotizacionM->garantia,
                $cotizacionM->validez,
                $cotizacionM->fecha_emision,
                $cotizacionM->cambio,
                $cotizacionM->observacion,
                $personal,
                $estado,
                $estadoVigente,
                $cotizacionM->tipo,
                $cotizacionM->op_gravada,
                $cotizacionM->op_inafecta,
                $cotizacionM->op_exonerada,
                $cotizacionM->op_gratuita,
                $infoOperacion,
                $infoDocumento,
                $subtotal,
                $igv_p,
                $importeTotal,
                $tiene_renovacion,
                $frecuencia_renovacion,
                $fecha_vencimiento_texto,
                $dias_restantes_texto
            ];

            $rows[] = $row;
        }

        $export = new class($rows) implements FromArray, WithEvents {
            private $rows;

            public function __construct($rows) {
                $this->rows = $rows;
            }

            public function array(): array {
                return $this->rows;
            }

            public function registerEvents(): array {
                return [
                    AfterSheet::class => function(AfterSheet $event) {
                        foreach(range('A','Z') as $column) {
                            $event->sheet->getColumnDimension($column)->setAutoSize(true);
                        }
                        foreach(range('A','Z') as $letter1) {
                            foreach(range('A','Z') as $letter2) {
                                $event->sheet->getColumnDimension($letter1.$letter2)->setAutoSize(true);
                            }
                        }
                    },
                ];
            }
        };

        $fecha = now('America/Lima')->format('d-m-Y');
        return Excel::download($export, 'Cotizaciones Manuales' . $fecha . '.xlsx');
    }

    public function printMultiple(Request $request)
    {
        try {
            $cotizacionIds = $request->input('cotizacion_ids', []);

            if (empty($cotizacionIds) || !is_array($cotizacionIds)) {
                return back()->withErrors(['No se seleccionaron cotizaciones manuales para imprimir.']);
            }

            $cotizaciones = CotizacionManual::whereIn('id', $cotizacionIds)->get();

            if ($cotizaciones->count() !== count($cotizacionIds)) {
                return back()->withErrors(['Algunas cotizaciones manuales seleccionadas no existen.']);
            }

            // Recopilar datos para múltiples cotizaciones manuales
            $cotizacionesData = [];
            $igvModel = Igv::first();

            foreach ($cotizaciones as $cotizacion) {
                $cotizacion_m_reg = CotizacionManual_registros::where('cotizacion_m_id', $cotizacion->id)->get();

                // Calcular subtotales
                $sub_total = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;

                // IGV
                $igv = round($cotizacion->op_gravada, 2) * $igvModel->igv_total / 100;

                // TOTAL
                $end = round($sub_total, 2) + round($igv, 2);

                // VERIFICAR SI EXISTE RENOVACIÓN PARA ESTA COTIZACIÓN
                $renovacion = RenovacionVentas::where('cotizacion_manual_id', $cotizacion->id)
                    ->with('cotizacionManual')
                    ->first();

                $fecha_vencimiento = null;
                $dias_restantes_texto = null;
                $dias_restantes_numero = null;

                if ($renovacion && $renovacion->cotizacionManual) {
                    $fecha_actual = Carbon::now();
                    $fecha_emision = Carbon::parse($renovacion->cotizacionManual->fecha_emision);

                    // CALCULAR FECHA DE VENCIMIENTO
                    if ($renovacion->frecuencia == 'Mensual' && $renovacion->dia_mensual) {
                        $dias_acumulados = (int) $renovacion->dia_mensual;
                        $fecha_vencimiento = $fecha_emision->copy()->addDays($dias_acumulados);

                        while ($fecha_vencimiento->isPast()) {
                            $fecha_vencimiento->addDays($dias_acumulados);
                        }

                    } elseif ($renovacion->frecuencia == 'Anual' && $renovacion->dia_anual && $renovacion->mes_anual) {
                        $dia_vencimiento = (int) $renovacion->dia_anual;
                        $mes_vencimiento = (int) $renovacion->mes_anual;
                        $anio_vencimiento = $renovacion->anio_anual ?? $fecha_actual->year;

                        try {
                            $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, $dia_vencimiento);
                        } catch (\Exception $e) {
                            $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, 1)->endOfMonth();
                        }

                        if ($fecha_vencimiento->isPast()) {
                            $fecha_vencimiento->addYear();
                        }
                    }

                    // CALCULAR DÍAS RESTANTES
                    if ($fecha_vencimiento) {
                        $dias_diferencia = $fecha_actual->diffInDays($fecha_vencimiento, false);
                        $dias_restantes_numero = $dias_diferencia;

                        if ($dias_diferencia < 0) {
                            $dias_restantes_texto = abs($dias_diferencia) . ' días vencido';
                        } elseif ($dias_diferencia == 0) {
                            $dias_restantes_texto = 'Vence hoy';
                        } elseif ($dias_diferencia == 1) {
                            $dias_restantes_texto = $dias_diferencia . ' día';
                        } else {
                            $dias_restantes_texto = $dias_diferencia . ' días';
                        }
                    }
                }

                $cotizacionesData[] = [
                    'cotizacion' => $cotizacion,
                    'cotizacion_m_reg' => $cotizacion_m_reg,
                    'sub_total' => $sub_total,
                    'igv' => $igv,
                    'end' => $end,
                    'renovacion' => $renovacion,
                    'fecha_vencimiento' => $fecha_vencimiento,
                    'dias_restantes_texto' => $dias_restantes_texto,
                    'dias_restantes_numero' => $dias_restantes_numero
                ];
            }

            // Datos comunes
            $banco = Banco::where('estado', '0')->get();
            $banco_count = Banco::where('estado', '0')->count();
            $empresa = Empresa::first();
            $j = 1;

            return view('transaccion.venta.cotizacion.manual.print_multiple', compact(
                'cotizacionesData',
                'empresa',
                'banco',
                'banco_count',
                'j'
            ));

        } catch (\Exception $e) {
            return back()->withErrors(['Error al procesar la impresión múltiple: ' . $e->getMessage()]);
        }
    }

    public function downloadMultiplePDFs(Request $request)
    {
        try {
            $cotizacionIds = $request->input('cotizacion_ids', []);

            if (empty($cotizacionIds) || !is_array($cotizacionIds)) {
                return back()->with('error', 'No se seleccionaron cotizaciones para descargar.');
            }

            if (count($cotizacionIds) === 1) {
                return $this->downloadSinglePDF($cotizacionIds[0]);
            }

            $cotizaciones = CotizacionManual::whereIn('id', $cotizacionIds)->get();

            if ($cotizaciones->count() !== count($cotizacionIds)) {
                return back()->with('error', 'Algunas cotizaciones seleccionadas no existen.');
            }

            // Limpiar cualquier output previo
            if (ob_get_level()) {
                ob_end_clean();
            }

            // Crear ZIP temporal usando tempnam
            $tempZip = tempnam(sys_get_temp_dir(), 'cotizaciones_manual_');
            $zip = new ZipArchive();

            if ($zip->open($tempZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                return back()->with('error', 'Error al crear el archivo ZIP');
            }

            $igv_config = Igv::first();
            $empresa = Empresa::first();

            foreach ($cotizaciones as $cotizacion) {
                try {
                    $cotizacion_m_reg = CotizacionManual_registros::where('cotizacion_m_id', $cotizacion->id)->get();

                    $sum = 0;
                    $j = 1;
                    $sub_total = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
                    $igv = round($cotizacion->op_gravada, 2) * $igv_config->igv_total / 100;
                    $end = round($sub_total, 2) + round($igv, 2);
                    $end2 = number_format(round($sub_total, 2) + round($igv, 2), 2);

                    // VERIFICAR SI EXISTE RENOVACIÓN
                    $renovacion = RenovacionVentas::where('cotizacion_manual_id', $cotizacion->id)
                        ->with('cotizacionManual')
                        ->first();

                    $fecha_vencimiento = null;
                    $dias_restantes_texto = null;
                    $dias_restantes_numero = null;

                    if ($renovacion && $renovacion->cotizacionManual) {
                        $fecha_actual = Carbon::now();
                        $fecha_emision = Carbon::parse($renovacion->cotizacionManual->fecha_emision);

                        if ($renovacion->frecuencia == 'Mensual' && $renovacion->dia_mensual) {
                            $dias_acumulados = (int) $renovacion->dia_mensual;
                            $fecha_vencimiento = $fecha_emision->copy()->addDays($dias_acumulados);

                            while ($fecha_vencimiento->isPast()) {
                                $fecha_vencimiento->addDays($dias_acumulados);
                            }

                        } elseif ($renovacion->frecuencia == 'Anual' && $renovacion->dia_anual && $renovacion->mes_anual) {
                            $dia_vencimiento = (int) $renovacion->dia_anual;
                            $mes_vencimiento = (int) $renovacion->mes_anual;
                            $anio_vencimiento = $renovacion->anio_anual ?? $fecha_actual->year;

                            try {
                                $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, $dia_vencimiento);
                            } catch (\Exception $e) {
                                $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, 1)->endOfMonth();
                            }

                            if ($fecha_vencimiento->isPast()) {
                                $fecha_vencimiento->addYear();
                            }
                        }

                        if ($fecha_vencimiento) {
                            $dias_diferencia = $fecha_actual->diffInDays($fecha_vencimiento, false);
                            $dias_restantes_numero = $dias_diferencia;

                            if ($dias_diferencia < 0) {
                                $dias_restantes_texto = abs($dias_diferencia) . ' días vencido';
                            } elseif ($dias_diferencia == 0) {
                                $dias_restantes_texto = 'Vence hoy';
                            } elseif ($dias_diferencia == 1) {
                                $dias_restantes_texto = $dias_diferencia . ' día';
                            } else {
                                $dias_restantes_texto = $dias_diferencia . ' días';
                            }
                        }
                    }

                    // Generar PDF individual
                    $pdf = PDF::loadView('transaccion.venta.cotizacion.manual.pdf', compact(
                        'j',
                        'cotizacion',
                        'empresa',
                        'cotizacion_m_reg',
                        'sum',
                        'igv',
                        'sub_total',
                        'end',
                        'end2',
                        'renovacion',
                        'fecha_vencimiento',
                        'dias_restantes_texto',
                        'dias_restantes_numero'
                    ));

                    $pdfContent = $pdf->output();

                    $codigoCotizacion = preg_replace('/[^a-zA-Z0-9_-]/', '_', $cotizacion->cod_cotizacion);
                    $fileName = 'Cotizacion_' . $codigoCotizacion . '.pdf';
                    $zip->addFromString($fileName, $pdfContent);

                } catch (\Exception $e) {
                    continue;
                }
            }

            $zip->close();
            unset($zip);
            clearstatcache(true, $tempZip);
            usleep(100000);

            // Descargar ZIP usando streamDownload
            return response()->streamDownload(
                function () use ($tempZip) {
                    readfile($tempZip);
                    @unlink($tempZip);
                },
                'Cotizaciones_Manual_' . date('Y-m-d_H-i-s') . '.zip',
                ['Content-Type' => 'application/zip']
            )->send();

            exit(); // CRÍTICO: Detener la ejecución después de enviar

        } catch (\Exception $e) {
            return back()->with('error', 'Error al descargar cotizaciones: ' . $e->getMessage());
        }
    }
    private function downloadSinglePDF($cotizacionId)
    {
        try {
            $cotizacion = CotizacionManual::findOrFail($cotizacionId);
            $cotizacion_m_reg = CotizacionManual_registros::where('cotizacion_m_id', $cotizacion->id)->get();

            $empresa = Empresa::first();
            $igv_config = Igv::first();
            $sum = 0;
            $j = 1;

            // SUBTOTAL
            $sub_total = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;

            // IGV
            $igv = round($cotizacion->op_gravada, 2) * $igv_config->igv_total / 100;

            // TOTAL
            $end = round($sub_total, 2) + round($igv, 2);
            $end2 = number_format(round($sub_total, 2) + round($igv, 2), 2);

            // VERIFICAR SI EXISTE RENOVACIÓN
            $renovacion = RenovacionVentas::where('cotizacion_manual_id', $cotizacion->id)
                ->with('cotizacionManual')
                ->first();

            $fecha_vencimiento = null;
            $dias_restantes_texto = null;
            $dias_restantes_numero = null;

            if ($renovacion && $renovacion->cotizacionManual) {
                $fecha_actual = Carbon::now();
                $fecha_emision = Carbon::parse($renovacion->cotizacionManual->fecha_emision);

                // CALCULAR FECHA DE VENCIMIENTO
                if ($renovacion->frecuencia == 'Mensual' && $renovacion->dia_mensual) {
                    $dias_acumulados = (int) $renovacion->dia_mensual;
                    $fecha_vencimiento = $fecha_emision->copy()->addDays($dias_acumulados);

                    while ($fecha_vencimiento->isPast()) {
                        $fecha_vencimiento->addDays($dias_acumulados);
                    }

                } elseif ($renovacion->frecuencia == 'Anual' && $renovacion->dia_anual && $renovacion->mes_anual) {
                    $dia_vencimiento = (int) $renovacion->dia_anual;
                    $mes_vencimiento = (int) $renovacion->mes_anual;
                    $anio_vencimiento = $renovacion->anio_anual ?? $fecha_actual->year;

                    try {
                        $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, $dia_vencimiento);
                    } catch (\Exception $e) {
                        $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, 1)->endOfMonth();
                    }

                    if ($fecha_vencimiento->isPast()) {
                        $fecha_vencimiento->addYear();
                    }
                }

                // CALCULAR DÍAS RESTANTES
                if ($fecha_vencimiento) {
                    $dias_diferencia = $fecha_actual->diffInDays($fecha_vencimiento, false);
                    $dias_restantes_numero = $dias_diferencia;

                    if ($dias_diferencia < 0) {
                        $dias_restantes_texto = abs($dias_diferencia) . ' días vencido';
                    } elseif ($dias_diferencia == 0) {
                        $dias_restantes_texto = 'Vence hoy';
                    } elseif ($dias_diferencia == 1) {
                        $dias_restantes_texto = $dias_diferencia . ' día';
                    } else {
                        $dias_restantes_texto = $dias_diferencia . ' días';
                    }
                }
            }

            // Generar PDF
            $pdf = PDF::loadView('transaccion.venta.cotizacion.manual.pdf', compact(
                'j',
                'cotizacion',
                'empresa',
                'cotizacion_m_reg',
                'sum',
                'igv',
                'sub_total',
                'end',
                'end2',
                'renovacion',
                'fecha_vencimiento',
                'dias_restantes_texto',
                'dias_restantes_numero'
            ));

            return $pdf->download($cotizacion->cod_cotizacion . '.pdf');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al descargar el PDF: ' . $e->getMessage());
        }
    }
}
