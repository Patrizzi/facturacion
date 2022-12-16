<?php

namespace App\Http\Controllers;

use App\boleta_m;
use App\Igv;
use App\Codigo_guia_almacen;
use App\Almacen;
use App\Personal;
use App\Personal_venta;
use App\Servicios;
use App\Forma_pago;
use App\Cliente;
use App\Producto;
use App\TipoCambio;
use App\Moneda;
use App\Empresa;
use App\Kardex_entrada;
use App\Tipo_operacion_f;
use App\Boleta_registros_m;
use App\Cuotas_credito;
use App\Banco;

use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BoletaMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boleta = Boleta_m::get();
        $igv = Igv::first();
        return view('transaccion.venta.boleta.boleta_manual.index', compact('boleta','igv'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inventario_inicial=Producto::count();
        $servicios = Servicios::count();
        if($inventario_inicial == 0 && $servicios == 0){
            return back()->withErrors(['No hay Productos o Servicios Agregados ']);
        }
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
        

        // Servicios
        $servicios=Servicios::where('estado_anular',0)->get();

        // Tipo de cambio
        $tipo_cambio=TipoCambio::latest('created_at')->first();

        // Moneda
        $moneda=Moneda::where('principal','1')->first();

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
        $cod_boleta_m = $cod_guia->cod_boleta_m;
        if(is_numeric($cod_boleta_m)){
            //expresion del numero de boleta
            $cod_boleta_m++;
            $sucursal_nr = str_pad($cod_guia->serie_boleta_m, 2, "0", STR_PAD_LEFT);
            $boleta_nr = str_pad($cod_boleta_m, 8, "0", STR_PAD_LEFT);
        }else {
            //expresion del numero de boleta
            //GENERACION DEL N BOLETA
            $ultima_boleta = Boleta_m::where('almacen_id',$sucursal->id)->latest()->first();
            // return $ultima_boleta;
            $boleta_num = $ultima_boleta->codigo_boleta;
            $boleta_num_string = explode("-", $boleta_num);
            $boleta_num_str = $boleta_num_string[1];
            $boleta_num = (int)$boleta_num_str;

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
            $boleta_nr = str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
        }
        $boleta_numero = "BA".$sucursal_nr."-".$boleta_nr;
        // return $boleta_numero;
        $fecha_hoy = Carbon::now();
        $fecha_1 = $fecha_hoy->format('Y-m-d');
        return view('transaccion.venta.boleta.boleta_manual.create',compact('productos','servicios','forma_pagos','clientes','personales','igv','moneda','p_venta','empresa','categoria','empresa','tipo_operacion','almacenes','sucursal','boleta_numero','fecha_1'));

    }

    public function change_almacen_tipo(Request $request){
        // return $request;
        $almacen = $request->get('almacen');
        $sucursal =Almacen::where('id', $almacen)->first();
            // return $sucursal;
        $cod_guia= Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
        $cod_guia_all = Codigo_guia_almacen::where('almacen_id', '!=' ,$sucursal->id)->get();

        $last_numb=Boleta_m::where('almacen_id',$sucursal->id)->latest()->first();
        if(!isset($last_numb) && !is_numeric($cod_guia->cod_boleta_m)){
            $almacen_igual = Codigo_guia_almacen::find($sucursal->id);
            $almacen_igual->cod_boleta_m = 0;
            $almacen_igual->save();
        }
        foreach($cod_guia_all as $cod_gui){
            $serie_bol_m = $cod_gui->serie_boleta_m;
            if($cod_guia->serie_boleta_m == $serie_bol_m ){
                $almacen_igual = Codigo_guia_almacen::find($sucursal->id);
                $almacen_igual->serie_boleta_m = $cod_guia->serie_boleta_m+1;
                $almacen_igual->save();
            }else{
                // $var[] = 0;
            }
        }

        $boleta_cod=$cod_guia->cod_boleta_m;
        if (is_numeric($boleta_cod)) {
            // expresión del numero de boleta
            $boleta_cod++;
            $sucursal_nr = str_pad($cod_guia->serie_boleta_m, 2, "0", STR_PAD_LEFT);
            $boleta_nr =str_pad($boleta_cod, 8, "0", STR_PAD_LEFT);
        }else{
                // expresión del numero de boleta
                // GENERACIÓN DE NUMERO DE boleta
            $ultima_boleta = Boleta_m::where('almacen_id',$sucursal->id)->latest()->first();
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
            $boleta_nr =str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
        }

        $boleta_numa="BA".$sucursal_nr."-".$boleta_nr ;
        return $boleta_numa;
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
            $producto_id[$i]=explode(" ",$articulos[$i]); //separador del articulo por espacio
            
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

        // obtención de buscador al cambio
        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }

        $almacen=$request->get('almacen_id_selec');
        $sucursal =Almacen::where('id', $almacen)->first();
        
        $cod_guia= Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();

        $boleta_cod=$cod_guia->cod_boleta_m;
        if (is_numeric($boleta_cod)) {
            // expresión del numero de boleta
            $boleta_cod++;
            $sucursal_nr = str_pad($cod_guia->serie_boleta_m, 2, "0", STR_PAD_LEFT);
            $boleta_nr =str_pad($boleta_cod, 8, "0", STR_PAD_LEFT);
        }else{
                // expresión del numero de boleta
                // GENERACIÓN DE NUMERO DE boleta
            $ultima_boleta = Boleta_m::where('almacen_id',$sucursal->id)->latest()->first();
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
            $boleta_nr =str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
        }

        $boleta_numa ="BA".$sucursal_nr."-".$boleta_nr ;

        // obtención de Tipo de operación
        $operacion=$request->get('tipo_operacion');
        $nombre = strstr($operacion, '-',true);
        $busca_ope=Tipo_operacion_f::where('codigo',$nombre)->first();

        //obtención de moneda
        $moneda_get=Moneda::where('nombre',$request->moneda)->first();

        $boleta = new Boleta_m;
        $boleta->codigo_boleta = $boleta_numa;
        $boleta->almacen_id = $almacen;
        $boleta->orden_compra=$request->get('orden_compra');
        $boleta->guia_remision=$request->get('guia_r');
        $boleta->cliente_id=$cliente_buscador->id;
        $boleta->moneda_id=$moneda_get->id;
        $boleta->forma_pago_id=$request->get('forma_pago');
        $boleta->fecha_emision=$request->get('fecha_emision');
        $boleta->fecha_vencimiento=$nuevafechas;
        $boleta->cambio=$cambio->paralelo;
        $boleta->observacion=$request->get('observacion');
        $boleta->user_id =auth()->user()->id;
        $boleta->estado='0';
        $boleta->tipo_operacion_id= $busca_ope->id;
        $boleta->tipo_documento_id = 2;
        $boleta->save();

        // modificación para que se cierre el codigo en almacen
        $boleta_primero=Codigo_guia_almacen::where('id', $sucursal->id)->first();
        if(is_numeric($boleta_primero->cod_boleta_m)){
            $boleta_primero->cod_boleta_m='NN';
            $boleta_primero->save();
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
        //contador de valores de cantidad
        $cantidad = $request->input('cantidad');
        $count_cantidad=count($cantidad);
        
        //contador de valores de articulo
        $articulo = $request->input('articulo');
        $count_articulo=count($articulo);
        
        if($count_articulo = $count_cantidad){
            // Bucle para registro de productos o servicios 
            for($i=0;$i<$count_articulo;$i++){
                // Llamado de producto y servicio para su diferenciación y registro propio
                $producto = Producto::where('codigo_producto',$producto_id[$i][2])->first();
                $servicio=Servicios::where('codigo_servicio',$producto_id[$i][2])->where('estado_anular',0)->first();
                if(isset($producto)){ //Guardado de facturación registro solo para productos 
                    $boleta_registro = new Boleta_registros_m();
                    $boleta_registro->boleta_m_id = $boleta->id;
                    $boleta_registro->producto_id=$producto->id;
                    $boleta_registro->numero_serie=$request->get('numero_serie')[$i];
                    if($request->get('descripcion_item')[$i] == null){ 
                        $boleta_registro->descripcion_item = null;
                    }else{ 
                        $boleta_registro->descripcion_item = $request->get('descripcion_item')[$i];
                    }
                    $boleta_registro->precio = $request->get('precio')[$i];
                    $boleta_registro->cantidad=$request->get('cantidad')[$i];
                    $boleta_registro->save();
                    //modificación para los tipos de afectación al producto y guardado a facturación
                    $boleta_m=Boleta_m::find($boleta->id);
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                        $boleta_m->op_gravada += round($boleta_registro->precio*$boleta_registro->cantidad,2);
                    }
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                        $boleta_m->op_exonerada += round($boleta_registro->precio*$boleta_registro->cantidad,2);
                    }
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                        $boleta_m->op_inafecta += round($boleta_registro->precio*$boleta_registro->cantidad,2);
                    }
                    $boleta_m->save();
                }else{ // Guardado para servicios
                    $boleta_registro = new Boleta_registros_m();
                    $boleta_registro->boleta_m_id = $boleta->id;
                    $boleta_registro->servicio_id= $servicio->id;
                    $boleta_registro->numero_serie=$request->get('numero_serie')[$i];
                    if($request->get('descripcion_item')[$i] == null){ 
                        $boleta_registro->descripcion_item = null;
                    }else{ 
                        $boleta_registro->descripcion_item = $request->get('descripcion_item')[$i];
                    }
                    $boleta_registro->precio = $request->get('precio')[$i];
                    $boleta_registro->cantidad=$request->get('cantidad')[$i];
                    $boleta_registro->save();
                    $boleta_m=Boleta_m::find($boleta->id);
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                        $boleta_m->op_gravada += round($boleta_registro->precio*$boleta_registro->cantidad,2);
                    }
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                        $boleta_m->op_exonerada += round($boleta_registro->precio*$boleta_registro->cantidad,2);
                    }
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                        $boleta_m->op_inafecta += round($boleta_registro->precio*$boleta_registro->cantidad,2);
                    }
                    $boleta_m->save();
                }
            }
        }

        return redirect()->route('boleta_manual.show',$boleta->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\boleta_manual  $boleta_manual
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $existe_id=Boleta_m::where('id',$id)->first();
        if(empty($existe_id)){ 
            return redirect()->route('boleta_manual.index'); 
        }

        $empresa=Empresa::first();
        $boleta=Boleta_m::find($id);
        $boleta_registro=Boleta_registros_m::where('boleta_m_id',$id)->get();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $j = 1;
        return view('transaccion.venta.boleta.boleta_manual.show', compact('j','boleta','empresa','boleta_registro','sum','igv','sub_total','banco'));        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\boleta_manual  $boleta_manual
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
     * @param  \App\boleta_manual  $boleta_manual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function print(Request $request,$id)
    {
        $existe_id=Boleta_m::where('id',$id)->first();
        if(empty($existe_id)){ 
            return redirect()->route('boleta_manual.index'); 
        }

        $empresa=Empresa::first();
        $boleta=Boleta_m::find($id);
        $boleta_registro=Boleta_registros_m::where('boleta_m_id',$id)->get();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $j = 1;

        return view('transaccion.venta.boleta.boleta_manual.print', compact('j','boleta','empresa','boleta_registro','sum','igv','sub_total','banco'));
    }

    public function pdf(Request $request,$id)
    {
        $name = $request->get('name');

        $existe_id=Boleta_m::where('id',$id)->first();
        if(empty($existe_id)){ 
            return redirect()->route('boleta_manual.index'); 
        }

        $empresa=Empresa::first();
        $boleta=Boleta_m::find($id);
        $boleta_registro=Boleta_registros_m::where('boleta_m_id',$id)->get();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $j = 1;

        // $archivo=$name.'_'.$boleta->codigo_boleta;
        // return View('transaccion.venta.boleta.boleta_manual.pdf', compact('j','boleta','empresa','boleta_registro','sum','igv','sub_total','banco'));
        $pdf=PDF::loadView('transaccion.venta.boleta.boleta_manual.pdf', compact('j','boleta','empresa','boleta_registro','sum','igv','sub_total','banco'));
        return $pdf->download('BoletaM - '.$boleta->codigo_boleta.'.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\boleta_manual  $boleta_manual
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        //
    }
    public function ticket(Request $request,$id){

        $boleta=Boleta_m::find($id);
        $boleta_registro= Boleta_registros_m::where('boleta_m_id',$id)->get();
        $empresa=Empresa::first();
        $moneda = Moneda::where('id',$boleta->moneda_id)->first();
        $igv=Igv::first();
        return view('transaccion.venta.boleta.boleta_manual.ticket',compact('boleta','boleta_registro','empresa','igv','moneda'));
    }
}
