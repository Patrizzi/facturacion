<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config_fe;
use App\config_acceso_sunat;
use App\Facturacion_m;
use App\Facturacion_registro_m;
use App\Forma_pago;
use App\Cliente;
use App\Personal;
use App\Personal_venta;
use App\Igv;
use App\Producto;
use App\Servicios;
use App\Almacen;
use App\TipoCambio;
use App\Moneda;
use App\Empresa;
use App\Tipo_operacion_f;
use App\Banco;  
use App\Cuotas_credito;
use App\Codigo_guia_almacen;

use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class FacturacionMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facturacion=Facturacion_m::all();
        $igv = Igv::first();
        return view('transaccion.venta.facturacion.facturacion_manual.index', compact('facturacion','igv'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        // Forma de pago
        $forma_pagos=Forma_pago::all();

        // Cliente
        $clientes=Cliente::where('documento_identificacion','ruc')->get();

        // Personal
        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();

        // Igv
        $igv=Igv::first();

        // Categoria
        $categoria='producto';
        
        // Productos
        $productos=Producto::where('estado_anular',1)->get();

        // Sucursal
        $sucursal=1;
        $sucursal=Almacen::where('id',$sucursal)->first();

        // Servicios
        $servicios=Servicios::where('estado_anular',0)->get();

        // Tipo de cambio
        $tipo_cambio=TipoCambio::latest('created_at')->first();

        // Moneda
        $moneda=Moneda::where('principal','1')->first();

        // Número de factura
        $factura_numero="FA01-000001";

        // Empresa
        $empresa=Empresa::first();

        // Tipo de operación
        $tipo_operacion = Tipo_operacion_f::all();

        //Almacen
        $almacenes = Almacen::all();
        //cODIGO
        $sucursal =Almacen::where('id', '1')->first();
            // return $sucursal;
        $cod_guia= Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
        $factura_cod_fac=$cod_guia->cod_factura_m;
        if (is_numeric($factura_cod_fac)) {
            // expresión del numero de factura
            $factura_cod_fac++;
            $sucursal_nr = str_pad($cod_guia->serie_factura_m, 2, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);
        }else{
                // expresión del numero de factura
                // GENERACIÓN DE NUMERO DE FACTURA
            $ultima_factura=Facturacion_m::where('almacen_id',$sucursal->id)->latest()->first();
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

        return view('transaccion.venta.facturacion.facturacion_manual.create',compact('productos','servicios','forma_pagos','clientes','personales','igv','moneda','p_venta','empresa','categoria','factura_numero','empresa','tipo_operacion','almacenes','sucursal','factura_numero'));
    }

    public function change_almacen_tipo(Request $request){
        // return $request;
        $almacen = $request->get('almacen');
        $sucursal =Almacen::where('id', $almacen)->first();
            // return $sucursal;
        $cod_guia= Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
        $cod_guia_all = Codigo_guia_almacen::where('almacen_id', '!=' ,$sucursal->id)->get();

        $last_numb=Facturacion_m::where('almacen_id',$sucursal->id)->latest()->first();
        if(!isset($last_numb)){
            $almacen_igual = Codigo_guia_almacen::find($sucursal->id);
            $almacen_igual->cod_factura_m = 0;
            $almacen_igual->save();
        }
        foreach($cod_guia_all as $cod_gui){
            $serie_fac_m = $cod_gui->serie_factura_m;
            if($cod_guia->serie_factura_m == $serie_fac_m ){
                // $var[] = $cod_guia->serie_factura_m+1;
                $almacen_igual = Codigo_guia_almacen::find($sucursal->id);
                $almacen_igual->serie_factura_m = $cod_guia->serie_factura_m+1;
                $almacen_igual->save();
            }else{
                // $var[] = 0;
            }
        }

        $factura_cod_fac=$cod_guia->cod_factura_m;
        if (is_numeric($factura_cod_fac)) {
            // expresión del numero de factura
            $factura_cod_fac++;
            $sucursal_nr = str_pad($cod_guia->serie_factura_m, 2, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);
        }else{
                // expresión del numero de factura
                // GENERACIÓN DE NUMERO DE FACTURA
            $ultima_factura=Facturacion_m::where('almacen_id',$sucursal->id)->latest()->first();
            $factura_num=$ultima_factura->codigo_fac;
            $factura_num_string_porcion= explode("-", $factura_num);
            $factura_num_string=$factura_num_string_porcion[1];
            $factura_num=(int)$factura_num_string;

            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_factura_m','DESC')->latest()->first();
                //CONDICIONAL PARA QUE EMPIECE DE NUEVO EN 0001 PARA EL NUMERO DE SERIE Y EL CORRELATIVO -> FALTA PULIR/IDEA GENERAL
            if($factura_num == 99999999){
                $ultima_factura = $almacen_codigo->serie_factura_m+1;
                // $almacen_save_last = Codigo_guia_almacen::find($sucursal->id);
                // $almacen_save_last->serie_factura_m = $almacen_codigo->serie_factura_m+1;
                // $almacen_save_last->save();
                $factura_num = 00000000;

            }else{
                $ultima_factura = $cod_guia->serie_factura_m;
            }
            $factura_num++;
            $sucursal_nr = str_pad($ultima_factura, 2, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_num, 8, "0", STR_PAD_LEFT);
        }

        $factura_numero="FA".$sucursal_nr."-".$factura_nr;
        return $factura_numero;
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
        //código para convertir nombre a producto
        $cantidad_p = $request->input('cantidad');
        $count_cantidad_p=count($cantidad_p);

        for($i=0 ; $i<$count_cantidad_p;$i++){
            $articulos[$i]= $request->input('articulo')[$i];
            $producto_id_name[$i]=strstr($articulos[$i], '|');
            $producto_id_2[$i]=strstr($producto_id_name[$i], ' ');
            $producto_id_3[$i]=substr(strstr($producto_id_2[$i], ' '),1);
            $producto_id[$i]=strstr($producto_id_3[$i], ' ', true);
            
        }

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
        
        // obtención de Cliente
        $cliente_nombre=$request->get('cliente');
        // $nombre = strstr($cliente_nombre, '-',true);
        $cliente_buscador=Cliente::where('id',$cliente_nombre)->first();

        // obtención de Código de factura
        // $factura_numero="F001-000001";
        $almacen=$request->get('almacen_id_selec');
        $sucursal =Almacen::where('id', $almacen)->first();
        
        $cod_guia= Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
            // return $sucursal;
        $factura_cod_fac=$cod_guia->cod_factura_m;
        if (is_numeric($factura_cod_fac)) {
                // expresión del numero de factura
            $factura_cod_fac++;
            $sucursal_nr = str_pad($cod_guia->serie_factura_m, 2, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);
        }else{
                // expresión del numero de factura
                // GENERACIÓN DE NUMERO DE FACTURA
            $ultima_factura=Facturacion_m::where('almacen_id',$sucursal->id)->latest()->first();
            $factura_num=$ultima_factura->codigo_fac;
            $factura_num_string_porcion= explode("-", $factura_num);
            $factura_num_string=$factura_num_string_porcion[1];
            $factura_num=(int)$factura_num_string;
    
            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_factura_m','DESC')->latest()->first();
                //CONDICIONAL PARA QUE EMPIECE DE NUEVO EN 0001 PARA EL NUMERO DE SERIE Y EL CORRELATIVO -> FALTA PULIR/IDEA GENERAL
            if($factura_num == 99999999){
                $ultima_factura = $almacen_codigo->serie_factura_m+1;
                $almacen_save_last = Codigo_guia_almacen::find($sucursal->id);
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



        // obtención de buscador al cambio
        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }

        // obtención de Tipo de operación
        $operacion=$request->get('tipo_operacion');
        $nombre = strstr($operacion, '-',true);
        $busca_ope=Tipo_operacion_f::where('codigo',$nombre)->first();

        //obtención de moneda
        $moneda_get=Moneda::where('nombre',$request->moneda)->first();

        // Guardado de facturación manual
        $facturacion=new facturacion_m;
        $facturacion->codigo_fac=$factura_numero;
        $facturacion->almacen_id =$request->get('almacen_id_selec');
        $facturacion->orden_compra=$request->get('orden_compra');
        $facturacion->guia_remision=$request->get('guia_r');
        $facturacion->cliente_id=$cliente_buscador->id;
        $facturacion->moneda_id=$moneda_get->id;
        $facturacion->forma_pago_id=$request->get('forma_pago');
        $facturacion->fecha_emision=$request->get('fecha_emision');
        $facturacion->fecha_vencimiento=$nuevafechas;
        $facturacion->cambio=$cambio->paralelo;
        $facturacion->observacion=$request->get('observacion');
        $facturacion->user_id =auth()->user()->id;
        $facturacion->estado='0';
        $facturacion->tipo_operacion_id= $busca_ope->id;
        $facturacion->tipo_documento_id = 2;

        $facturacion->save();

        // modificación para que se cierre el codigo en almacen
        $factura_primera=Codigo_guia_almacen::where('id', $sucursal->id)->first();
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

        //contador de valores de cantidad
        $cantidad = $request->input('cantidad');
        $count_cantidad=count($cantidad);

        //contador de valores de articulo
        $articulo = $request->input('articulo');
        $count_articulo=count($articulo);

        // Registro de artículos
        if($count_articulo = $count_cantidad){

            // Bucle para registro de productos o servicios 
            for($i=0;$i<$count_articulo;$i++){

                // Llamado de producto y servicio para su diferenciación y registro propio
                $producto = Producto::where('codigo_producto',$producto_id[$i])->first();
                $servicio=Servicios::where('codigo_servicio',$producto_id[$i])->where('estado_anular',0)->first();
                // return $producto_id[$i];
                if(isset($producto)){ //Guardado de facturación registro solo para productos 

                    $facturacion_registro= new Facturacion_registro_m();
                    $facturacion_registro->facturacion_m_id=$facturacion->id;
                    $facturacion_registro->producto_id=$producto->id;
                    $facturacion_registro->numero_serie=$request->get('numero_serie')[$i];
                    if($request->get('descripcion_item')[$i] == null){ 
                        $facturacion_registro->descripcion_item = null;
                    }else{ 
                        $facturacion_registro->descripcion_item = $request->get('descripcion_item')[$i];
                    }
                    $facturacion_registro->precio=$request->get('precio')[$i];
                    $facturacion_registro->cantidad=$request->get('cantidad')[$i];
                    $facturacion_registro->save();

                    //modificación para los tipos de afectación al producto y guardado a facturación
                    $facturacion_2=Facturacion_m::find($facturacion->id);
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                        $facturacion_2->op_gravada += round($facturacion_registro->precio*$facturacion_registro->cantidad,2);
                    }
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                        $facturacion_2->op_exonerada += round($facturacion_registro->precio*$facturacion_registro->cantidad,2);
                    }
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                        $facturacion_2->op_inafecta += round($facturacion_registro->precio*$facturacion_registro->cantidad,2);
                    }
                    $facturacion_2->save();

                }else{ //Guardado de facturación registro solo para servicios 
                    
                    $facturacion_registro=new Facturacion_registro_m();
                    $facturacion_registro->facturacion_m_id=$facturacion->id;
                    $facturacion_registro->servicio_id=$servicio->id;
                    $facturacion_registro->numero_serie=$request->get('numero_serie')[$i];
                    if($request->get('descripcion_item')[$i] == null){ 
                        $facturacion_registro->descripcion_item = null;
                    }else{ 
                        $facturacion_registro->descripcion_item = $request->get('descripcion_item')[$i];
                    }
                    $facturacion_registro->precio=$request->get('precio')[$i];
                    $facturacion_registro->cantidad=$request->get('cantidad')[$i];
                    $facturacion_registro->save(); 

                    //modificación para los tipos de afectación al servicio y guardado a facturación
                    $facturacion_2=Facturacion_m::find($facturacion->id);
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                        $facturacion_2->op_gravada += round($facturacion_registro->precio*$facturacion_registro->cantidad,2);
                    }
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                        $facturacion_2->op_exonerada += round($facturacion_registro->precio*$facturacion_registro->cantidad,2);
                    }
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                        $facturacion_2->op_inafecta += round($facturacion_registro->precio*$facturacion_registro->cantidad,2);
                    }
                    $facturacion_2->save();

                } // Final de guardado de facturación registro solo para productos 

            }// Final de bucle para registro de productos o servicios 

        } // Final de registro de artículos
        



        return redirect()->route('facturacion_manual.show',$facturacion->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Redirección para mostrar el inventario inicial
        
        $existe_id=Facturacion_m::where('id',$id)->first();
        if(empty($existe_id)){ return redirect()->route('facturacion_manual.index'); }

        $empresa=Empresa::first();
        $facturacion=Facturacion_m::find($id);
        $facturacion_registro=Facturacion_registro_m::where('facturacion_m_id',$id)->get();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $j = 1;
        
        return view('transaccion.venta.facturacion.facturacion_manual.show', compact('j','facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco'));

    }

    public function pdf(Request $request,$id){
        $name = $request->get('name');
        $empresa=Empresa::first();
        $facturacion=Facturacion_m::find($id);
        $facturacion_registro=Facturacion_registro_m::where('facturacion_m_id',$id)->get();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $banco_count=Banco::where('estado','0')->count();
        $i = 1;

        $archivo=$name.'_'.$id;
        
        $pdf=PDF::loadView('transaccion.venta.facturacion.facturacion_manual.pdf',compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco','banco_count','i'));
        return $pdf->download('Facturacion - '.$archivo.'.pdf');
    }

    public function facturacion_e(Request $request){

        // Obtención de facturación y facturacion registro
        $factura=Facturacion_m::find($request->id);
        $factura_registro=Facturacion_registro_m::where('facturacion_m_id',$request->id)->get();

        if($factura->guia_remision=="0"){
            $guia=0;
        }else{
            $guia=1;
        }

        $facturacion_manual=1;

        foreach($factura_registro as $facturas_registros){
            $facturas_registros->precio_unitario_comi=$facturas_registros->precio;
        }

        
        //configuración de conexión
        $see=config_acceso_sunat::facturacion_electronica();

        $invoice=Config_fe::factura($factura, $factura_registro,$guia,$facturacion_manual);

        $result=config_acceso_sunat::send($see, $invoice);

        //lectura CDR
        $mensaje=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

        // $mensaje="La factura fue enviada exitosamente";

        //cambio de factura electronica - en caso sea todo exitoso
        $factura->f_electronica=1;
        $factura->save();

        return redirect()->route('facturacion_electronica.index')->with('successMsg',$mensaje);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function print($id){
        $existe_id=Facturacion_m::where('id',$id)->first();
        if(empty($existe_id)){ return redirect()->route('facturacion_manual.index'); }

        $empresa=Empresa::first();
        $facturacion=Facturacion_m::find($id);
        $facturacion_registro=Facturacion_registro_m::where('facturacion_m_id',$id)->get();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $j = 1;
        
        return view('transaccion.venta.facturacion.facturacion_manual.print', compact('j','facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco'));
    }

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
        //
    }
}
