<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Codigo_guia_almacen;
use App\Banco;
use App\Cliente;
use App\Empresa;
use App\Forma_pago;
use App\Garantia;
use App\Igv;
use App\Kardex_entrada;
use App\CotizacionManual;
use App\CotizacionManual_registros;
use App\Moneda;
use App\Personal;
use App\Producto;
use App\Servicios;
use App\TipoCambio;
use App\Unidad_medida;
use App\Tipo_operacion_f;
use App\Validez;
use App\kardex_entrada_registro;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CotizacionManualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $cotizacion = CotizacionManual::get();

        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        $existe_id=Kardex_entrada::where('estado',2)->first();
        if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

        return view('transaccion.venta.cotizacion.manual.index', compact('cotizacion'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        // Migracion nueva
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        // * CAMBIAR POR VERIFICACION DE CANTIDAD DE PRODUCTOS Y SERVICIOS PRODUCTOS??
        $existe_id=Kardex_entrada::where('estado',2)->first();
        if(empty($existe_id)){ 
            return redirect()->route('kardex-entrada.index'); 
        }
        // Sucursal
        $sucursal_1=1;
        $sucursal=Almacen::where('id',$sucursal_1)->first();
        
        $almacen = Almacen::where('estado','!=',1)->get();
        $clientes=Cliente::all();
        $moneda=Moneda::where('principal','1')->first();

        $forma_pagos= Forma_pago::all();
        $igv=Igv::first();
        $servicios = Servicios::all();
        $productos=Producto::all();
        $empresa=Empresa::first();
        $tipo_operacion=Tipo_operacion_f::get();
        return view('transaccion.venta.cotizacion.manual.create',compact('garantia','validez','igv','empresa','clientes','forma_pagos','moneda','productos','servicios','almacen','tipo_operacion','sucursal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
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
        $forma_pago = Forma_Pago::where('nombre', $id_forma_pago)->first();

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
            $cotizacion_numero="CMF".$sucursal_nr."-".$correlativo;

        }else{
            $tipo_cotizacion = "boleta";
            $tipo_doc = 3;

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
            $cotizacion_numero="CMB".$sucursal_nr."-".$correlativo;
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

        // CODIGO GUIA ALMACEN
        $coti_manual=Codigo_guia_almacen::where('id', $sucursal->id)->first();
        if($tipo_cotizacion == 'factura'){
            if(is_numeric($coti_manual->cod_coti_fact_m)){
                $coti_manual->cod_coti_fact_m='NN';
                $coti_manual->save();
            }
        }else{
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

        return redirect()->route('manual.show',$cotizacion_manual->id);
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
        $existe_id=CotizacionManual::where('id',$id)->first();
        if(empty($existe_id)){ return redirect()->route('manual.index'); }

        $empresa=Empresa::first();
        $cotizacion=CotizacionManual::find($id);
        $cotizacion_m_reg=CotizacionManual_registros::where('cotizacion_m_id',$id)->get();
        $sum=0;
        $igv_t=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $banco_count = count($banco);
        $j = 1;

        //SUBTOTAL
        $sub_total = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
        //IGV
        $igv = round( $cotizacion->op_gravada ,2) * $igv_t->igv_total/100;
        //TOTAL 
        $end = round($sub_total, 2) + round($igv,2);
        $end2 = number_format(round($sub_total,2) + round($igv ,2),2);
    
        return view('transaccion.venta.cotizacion.manual.show', compact('j','cotizacion','empresa','cotizacion_m_reg','sum','igv','sub_total','banco','banco_count','sub_total','igv','end','end2','igv_t'));
        //a
    }
    public function print($id){
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
        
        return view('transaccion.venta.cotizacion.manual.print', compact('j','cotizacion_m','empresa','cotizacion_m_reg','sum','igv','sub_total','banco','banco_count','sub_total','igv','end','end2'));
    }
    public function pdf(Request $request,$id){

        $name = $request->get('name');
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
        
        $archivo=$name.'_'.$id;
        
        $pdf=PDF::loadView('transaccion.venta.cotizacion.manual.pdf', compact('j','cotizacion_m','empresa','cotizacion_m_reg','sum','igv','sub_total','banco','banco_count','sub_total','igv','end','end2'));
        return $pdf->download('CotizacionManual - '.$archivo.'.pdf');

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
    public function update(Request $request, $id)
    {
        // return $request;
        $cotizacion = CotizacionManual::find($id);
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
        // return $articulo_cod;

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
        return back();
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
}
