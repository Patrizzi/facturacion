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
use App\Boleta_m as AppBoleta_m;
use App\Nota_Credito;
use App\Nota_Debito;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
use App\Exports\BoletasMExport;

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
        if(count($boleta) == 0){
            $nota_credito[0] = null;
            $nota_debito[0] = null;
        }else{
            foreach ($boleta as $key => $boletas) {
                $nota_credito[$key] = Nota_Credito::where('boleta_m_id', $boletas->id)->first();
                $nota_debito[$key] = Nota_Debito::where('boleta_m_id', $boletas->id)->first();
                if (!isset($nota_credito[$key])) {
                    $nota_credito[$key] = null;
                }
                if (!isset($nota_debito[$key])) {
                    $nota_debito[$key] = null;
                }
            }
        }
        // return $nota_credito;
        return view('transaccion.venta.boleta.boleta_manual.index', compact('boleta','igv','nota_credito','nota_debito'));
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
        $sucursal = Almacen::where('id', '1')->first();
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
        $fecha_hoy = Carbon::now()->add(1,'day');
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

            // $nuevafechas = Carbon::createFromFormat('d/m/Y', $val);
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
        if($request->get('button_submit') == 0){
            $boleta->estado='0';
        }else{
            $boleta->estado='1';
        }
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
                        $boleta_m->op_gravada += $boleta_registro->precio*$boleta_registro->cantidad;
                    }
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                        $boleta_m->op_exonerada += $boleta_registro->precio*$boleta_registro->cantidad;
                    }
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                        $boleta_m->op_inafecta += $boleta_registro->precio*$boleta_registro->cantidad;
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
                        $boleta_m->op_gravada += $boleta_registro->precio*$boleta_registro->cantidad;
                    }
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                        $boleta_m->op_exonerada += $boleta_registro->precio*$boleta_registro->cantidad;
                    }
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                        $boleta_m->op_inafecta += $boleta_registro->precio*$boleta_registro->cantidad;
                    }
                    $boleta_m->save();
                }
            }
        }

        if($boleta->forma_pago_id == 2){
            boleta_m::revision_cuotas($boleta->id);
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
        $almacen = Almacen::all(); // o tu filtro real

        // Para editar
        $forma_pagos=Forma_pago::all();
        $tipo_operacion = Tipo_operacion_f::all();
        $almacenes = Almacen::all();
        $moneda=Moneda::where('principal','1')->first();
        $sucursal =Almacen::where('id', '1')->first();
        return view('transaccion.venta.boleta.boleta_manual.show', compact('j','almacen','boleta','empresa','boleta_registro','sum','igv','sub_total','banco','forma_pagos','tipo_operacion','almacenes','moneda','sucursal'));
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
        // return $request;
        $boleta = Boleta_m::find($id);
        $forma_pago_id=$request->get('forma_pago');
        $create_cuotas = 0;
        if($boleta->forma_pago_id == 1){ //Si es contado
            if($request->get('forma_pago') == $boleta->forma_pago_id){
                $fecha_vencimiento = $request->get('fecha_vencimiento');
                $create_cuotas = 0;
            }else{
                // Si cambia a credito
                $fecha_pago_forma = $request->input('fecha_pago');
                $contador_for_1 = count($fecha_pago_forma);
                for ($c = 0; $c < $contador_for_1; $c++) {
                    $val = $fecha_pago_forma[$c];
                }
                $fecha_vencimiento = date('d-m-Y', strtotime(($val)));
                $create_cuotas = 1;
            }

        }else{ // Si el editado es credito
            if($request->get('forma_pago') == $boleta->forma_pago_id){ //Si sigue siendo credito
                $fecha_pago_forma = $request->input('fecha_pago');
                $contador_for_1 = count($fecha_pago_forma);
                for ($c = 0; $c < $contador_for_1; $c++) {
                    $val = $fecha_pago_forma[$c];
                }
                $fecha_vencimiento = date('d-m-Y', strtotime(($val)));
                $create_cuotas = 1;
            }else{ // Si cambia a contado
                // Eliminar cuotas anteriores
                $eliminar_cuotas = Cuotas_credito::where('boleta_m_id', $id)->delete();
                $fecha_vencimiento = $request->get('fecha_vencimiento');
                $create_cuotas = 0;
            }
        }


        $boleta->almacen_id = $request->get('almacen');
        $boleta->orden_compra =  $request->get('orden_compra');
        $boleta->guia_remision =  $request->get('guia_r');
        $boleta->cliente_id =  $request->get('cliente');
        $boleta->moneda_id =  $request->get('moneda_id');
        $boleta->forma_pago_id =  $forma_pago_id;
        $boleta->fecha_vencimiento =  $fecha_vencimiento;
        $boleta->observacion = $request->get('observacion');
        if($request->button_submit == 0){
            $boleta->estado = '0'; //! Si se puede seguir editando
        }else{
            $boleta->estado = '1'; //! Si ya no se puede editar
        }
        $boleta->tipo_operacion_id = $request->get('tipo_operacion');
        $boleta->op_gravada = 0;
        $boleta->op_inafecta = 0;
        $boleta->op_exonerada = 0;
        $boleta->op_gratuita = 0;
        $boleta->save();

        //! Crear o Editar cuotas dependiendo de la logica anterior
        if($create_cuotas == 1){
            $count_cuotas = Cuotas_credito::where('boleta_m_id', $id)->count();
            $new_count = count($request->get('fecha_pago'));
            if($count_cuotas == $new_count){
                // Se editan las cuotas existentes
                foreach($boleta->cuotas_credito as $index => $cuota){
                    $cuota->fecha_pago = $request->get('fecha_pago')[$index];
                    $cuota->monto = $request->get('monto_pago')[$index];
                    $cuota->save();
                }
            }else{
                // Eliminar cuotas anteriores
                $eliminar_cuotas = Cuotas_credito::where('boleta_m_id', $id)->delete();
                // Crear nuevas cuotas
                $fecha_pago_forma = $request->input('fecha_pago');
                $contador_for_1 = count($fecha_pago_forma);
                $monto_pago = $request->input('monto_pago');
                for ($c = 0; $c < $contador_for_1; $c++) {
                    $cuota_cred = new Cuotas_credito;
                    $cuota_cred->boleta_m_id = $id;
                    $cuota_cred->numero_cuota = $c + 1;
                    $cuota_cred->monto = $monto_pago[$c];
                    $cuota_cred->fecha_pago = $fecha_pago_forma[$c];
                    $cuota_cred->save();
                }
            }
        }

        $count_art = count($request->get('cantidad'));
        // OBTENCION DE PRODUCTOS O SERVICIOS
        // return $count_art;
        for ($i = 0; $i < $count_art; $i++) {
            $articulos[$i] = $request->input('articulo')[$i];
            $producto_id_name[$i] = strstr($articulos[$i], '|');
            $producto_id_2[$i] = strstr($producto_id_name[$i], ' ');
            $producto_id_3[$i] = substr(strstr($producto_id_2[$i], ' '), 1);
            $producto_id[$i] = strstr($producto_id_3[$i], ' ', true);
        }

        $boletas = Boleta_m::find($id);
        // Registros
        $registros_count = count($boleta->registros_m);
        $count_art = count($request->get('cantidad'));
        if($registros_count == $count_art){ //Si son iguales se editan
            foreach($boleta->registros_m as $key => $edit_reg) {
                // Llamado de producto y servicio para su diferenciación y registro propio
                $producto = Producto::where('codigo_producto', $producto_id[$key])->first();
                if(isset($producto)){
                    $edit_reg->producto_id = $producto->id;
                    $edit_reg->numero_serie = $request->get('numero_serie')[$key];
                    if($request->get('descripcion_item')[$key] == null){
                        $edit_reg->descripcion_item = null;
                    }else{
                        $edit_reg->descripcion_item = $request->get('descripcion_item')[$key];
                    }
                    $edit_reg->precio = $request->get('precio')[$key];
                    $edit_reg->cantidad = $request->get('cantidad')[$key];
                    $edit_reg->save();

                    // Modificacion para los tipos de afectación al producto y guardado a boleta
                    if (strpos($producto->tipo_afec_i_producto->informacion, 'Gravado') !== false) {
                        $boleta->op_gravada += $edit_reg->precio * $edit_reg->cantidad;
                    }
                    if (strpos($producto->tipo_afec_i_producto->informacion, 'Exonerado') !== false) {
                        $boleta->op_exonerada += $edit_reg->precio * $edit_reg->cantidad;
                    }
                    if (strpos($producto->tipo_afec_i_producto->informacion, 'Inafecto') !== false) {
                        $boleta->op_inafecta += $edit_reg->precio * $edit_reg->cantidad;
                    }
                    $boleta->save();
                    $edit_reg->save();
                }else{
                    $servicio = Servicios::where('codigo_servicio', $producto_id[$key])->where('estado_anular', 0)->first();
                    $edit_reg->producto_id = $servicio->id;
                    $edit_reg->numero_serie = $request->get('numero_serie')[$key];
                    if($request->get('descripcion_item')[$key] == null){
                        $edit_reg->descripcion_item = null;
                    }else{
                        $edit_reg->descripcion_item = $request->get('descripcion_item')[$key];
                    }
                    $edit_reg->precio = $request->get('precio')[$key];
                    $edit_reg->cantidad = $request->get('cantidad')[$key];
                    $edit_reg->save();

                    // Modificacion para los tipos de afectación al producto y guardado a boleta
                    if (strpos($servicio->tipo_afec_i_serv->informacion, 'Gravado') !== false) {
                        $boleta->op_gravada += $edit_reg->precio * $edit_reg->cantidad;
                    }
                    if (strpos($servicio->tipo_afec_i_serv->informacion, 'Exonerado') !== false) {
                        $boleta->op_exonerada += $edit_reg->precio * $edit_reg->cantidad;
                    }
                    if (strpos($servicio->tipo_afec_i_serv->informacion, 'Inafecto') !== false) {
                        $boleta->op_inafecta += $edit_reg->precio * $edit_reg->cantidad;
                    }
                    $boleta->save();
                    $edit_reg->save();
                }
            }
        }else{ //* Si no es la misma cantidad se eliminan y se vuelven a crear
            // Eliminar registros anteriores
            $eliminar_registros = Boleta_registros_m::where('boleta_m_id', $id)->delete();
            for ($i = 0; $i < $count_art ; $i++) {
                $producto = Producto::where('codigo_producto', $producto_id[$i])->first();
                if(isset($producto)){
                    $new_reg = new Boleta_registros_m();
                    $new_reg->boleta_m_id = $boleta->id;
                    $new_reg->producto_id = $producto->id;
                    $new_reg->numero_serie = $request->get('numero_serie')[$i];
                    if ($request->get('descripcion_item')[$i] == null) {
                        $new_reg->descripcion_item = null;
                    } else {
                        $new_reg->descripcion_item = $request->get('descripcion_item')[$i];
                    }
                    $new_reg->precio = $request->get('precio')[$i];
                    $new_reg->cantidad = $request->get('cantidad')[$i];
                    $new_reg->save();
                    // Modificacion para los tipos de afectación al producto y guardado a boleta
                    if (strpos($producto->tipo_afec_i_producto->informacion, 'Gravado') !== false) {
                        $boleta->op_gravada += $new_reg->precio * $new_reg->cantidad;
                    }
                    if (strpos($producto->tipo_afec_i_producto->informacion, 'Exonerado') !== false) {
                        $boleta->op_exonerada += $new_reg->precio * $new_reg->cantidad;
                    }
                    if (strpos($producto->tipo_afec_i_producto->informacion, 'Inafecto') !== false) {
                        $boleta->op_inafecta += $new_reg->precio * $new_reg->cantidad;
                    }
                    $boleta->save();
                }else{
                    $servicio = Servicios::where('codigo_servicio', $producto_id[$i])->where('estado_anular', 0)->first();
                    $new_reg = new Boleta_registros_m();
                    $new_reg->boleta_m_id = $boleta->id;
                    $new_reg->servicio_id = $servicio->id;
                    $new_reg->numero_serie = $request->get('numero_serie')[$i];
                    if ($request->get('descripcion_item')[$i] == null) {
                        $new_reg->descripcion_item = null;
                    } else {
                        $new_reg->descripcion_item = $request->get('descripcion_item')[$i];
                    }
                    $new_reg->precio = $request->get('precio')[$i];
                    $new_reg->cantidad = $request->get('cantidad')[$i];
                    $new_reg->save();
                    // Modificacion para los tipos de afectación al producto y guardado a boleta
                    if (strpos($servicio->tipo_afec_i_serv->informacion, 'Gravado') !== false) {
                        $boleta->op_gravada += $new_reg->precio * $new_reg->cantidad;
                    }
                    if (strpos($servicio->tipo_afec_i_serv->informacion, 'Exonerado') !== false) {
                        $boleta->op_exonerada += $new_reg->precio * $new_reg->cantidad;
                    }
                    if (strpos($servicio->tipo_afec_i_serv->informacion, 'Inafecto') !== false) {
                        $boleta->op_inafecta += $new_reg->precio * $new_reg->cantidad;
                    }
                    $boleta->save();
                }
            }
        }
        return redirect()->back()->with('success','Se editó la boleta correctamente');
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

        $textoQR = $this->generarTextoQRBoletaM($boleta, $empresa, $igv);
        $qrCode  = $this->generarImagenQR($textoQR);

        return view('transaccion.venta.boleta.boleta_manual.print', compact('j','boleta','empresa','boleta_registro','sum','igv','sub_total','banco','textoQR','qrCode'));
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
        $textoQR = $this->generarTextoQRBoletaM($boleta, $empresa, $igv);
        $qrCode  = $this->generarImagenQR($textoQR);

        // $archivo=$name.'_'.$boleta->codigo_boleta;
        // return View('transaccion.venta.boleta.boleta_manual.pdf', compact('j','boleta','empresa','boleta_registro','sum','igv','sub_total','banco'));
        $pdf=PDF::loadView('transaccion.venta.boleta.boleta_manual.pdf', compact('j','boleta','empresa','boleta_registro','sum','igv','sub_total','banco','textoQR','qrCode'));
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
        public function ticket(Request $request, $id)
    {
        $boleta          = Boleta_m::find($id);
        $boleta_registro = Boleta_registros_m::where('boleta_m_id', $id)->get();
        $empresa         = Empresa::first();
        $moneda          = Moneda::where('id', $boleta->moneda_id)->first();
        $igv             = Igv::first();
        $textoQR         = $this->generarTextoQRBoletaM($boleta, $empresa, $igv);
        $qrCode          = $this->generarImagenQR($textoQR);

        // Altura dinámica según cantidad de ítems
        $totalItems  = $boleta_registro->count();
        $anchoPapel  = 170;
        $alturaItem  = 18;
        $alturaPapel = 320 + ($totalItems * $alturaItem) + 220;

        $pdf = PDF::loadView(
            'transaccion.venta.boleta.boleta_manual.ticket',
            compact(
                'boleta',
                'boleta_registro',
                'empresa',
                'igv',
                'moneda',
                'qrCode',
                'textoQR'
            )
        )
            ->setPaper([0, 0, $anchoPapel, $alturaPapel], 'portrait')
            ->setOptions([
                'dpi'                  => 96,
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => true,
                'defaultFont'          => 'Courier',
                'isPhpEnabled'         => true,
            ]);

        return $pdf->stream('ticket-' . $boleta->codigo_boleta . '.pdf');
    }

    //FUNCION PARA COMPROBANTES
    public function exportarBoletasM(Request $request)
    {
        $ids = $request->json('boleta_ids');

        if (!empty($ids)) {
            $export = new BoletasMExport($ids);
        } else {
            $request->validate([
                'daterange' => 'required|string'
            ]);

            [$start, $end] = explode(' - ', $request->daterange);

            $export = new BoletasMExport(null, [
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

    public function printMultiple(Request $request) {
        try {
            // Cambiar de input() a query() para parámetros GET
            $boletaMIds = $request->query('boletaM_ids', []);

            if (empty($boletaMIds) || !is_array($boletaMIds)) {
                return back()->withErrors(['No se seleccionaron boletas manuales para imprimir.']);
            }

            $boletas = Boleta_m::whereIn('id', $boletaMIds)->get();

            if ($boletas->count() !== count($boletaMIds)) {
                return back()->withErrors(['Algunas boletas manuales seleccionadas no existen.']);
            }

            $inventario_inicial = Kardex_entrada::count();
            $servicios = Servicios::count();
            if ($inventario_inicial == 0 && $servicios == 0) {
                return back()->withErrors(['No hay Productos o Servicios Agregados']);
            }

            // Obtener datos comunes una sola vez
            $empresa = Empresa::first();
            $igv = Igv::first();

            // Recopilar datos para múltiples boletas manuales
            $boletasData = [];

            foreach ($boletas as $boleta) {
                $boleta_registro = Boleta_registros_m::where('boleta_m_id', $boleta->id)->get();

                $textoQR = $this->generarTextoQRBoletaM($boleta, $empresa, $igv);
                $qrCode = $this->generarImagenQR($textoQR);
                // ========================================================

                $boletasData[] = [
                    'boleta' => $boleta,
                    'boleta_registro' => $boleta_registro,
                    'sub_total' => $boleta->op_gravada + $boleta->op_inafecta + $boleta->op_exonerada,
                    'qrCode' => $qrCode,
                    'textoQR' => $textoQR,
                ];
            }

            $banco = Banco::where('estado', 0)->get();

            return view('transaccion.venta.boleta.boleta_manual.print_multiple', compact(
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
                return back()->with('error', 'No hay boletas manuales seleccionadas para descargar.');
            }

            if (count($boletaIds) === 1) {
                return $this->downloadSinglePDF($boletaIds[0]);
            }

            $boletas = Boleta_m::whereIn('id', $boletaIds)->get();

            if ($boletas->count() !== count($boletaIds)) {
                return back()->with('error', 'Algunas boletas manuales seleccionadas no existen.');
            }

            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            $zipName = 'BoletasManuales_' . date('Y-m-d_H-i-s') . '.zip';
            $tempZip = $tempDir . DIRECTORY_SEPARATOR . $zipName;

            if (file_exists($tempZip)) {
                @unlink($tempZip);
            }

            $zip = new ZipArchive();

            if ($zip->open($tempZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                return back()->with('error', 'Error al crear el archivo ZIP');
            }

            $empresa = Empresa::first();
            $igv = Igv::first();
            $banco = Banco::where('estado', 0)->get();

            foreach ($boletas as $boleta) {
                try {
                    $boleta_registro = Boleta_registros_m::where('boleta_m_id', $boleta->id)->get();
                    $sum = 0;
                    $sub_total = 0;
                    $j = 1;
                    $textoQR = $this->generarTextoQRBoletaM($boleta, $empresa, $igv);
                    $qrCode  = $this->generarImagenQR($textoQR);

                    $pdf = PDF::loadView('transaccion.venta.boleta.boleta_manual.pdf', compact(
                        'j',
                        'boleta',
                        'empresa',
                        'boleta_registro',
                        'sum',
                        'igv',
                        'sub_total',
                        'banco',
                        'textoQR',
                        'qrCode'
                    ));

                    $pdfContent = $pdf->output();

                    $codigoBoleta = preg_replace('/[^a-zA-Z0-9_-]/', '_', $boleta->codigo_boleta);
                    $fileName = 'BoletaM_' . $codigoBoleta . '.pdf';
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
            return back()->with('error', 'Error al descargar boletas manuales: ' . $e->getMessage());
        }
    }

    // Función para descargar un solo PDF
    private function downloadSinglePDF($id)
    {
        try {
            $boleta = Boleta_m::find($id);
            if (!$boleta) {
                return back()->with('error', 'Boleta manual no encontrada.');
            }

            $empresa = Empresa::first();
            $boleta_registro = Boleta_registros_m::where('boleta_m_id', $id)->get();
            $sum = 0;
            $igv = Igv::first();
            $sub_total = 0;
            $banco = Banco::where('estado', 0)->get();
            $j = 1;
            $textoQR = $this->generarTextoQRBoletaM($boleta, $empresa, $igv);
            $qrCode  = $this->generarImagenQR($textoQR);

            $pdf = PDF::loadView('transaccion.venta.boleta.boleta_manual.pdf', compact(
                'j',
                'boleta',
                'empresa',
                'boleta_registro',
                'sum',
                'igv',
                'sub_total',
                'banco',
                'textoQR'
                ,'qrCode'
            ));

            return $pdf->download('BoletaM_' . $boleta->codigo_boleta . '.pdf');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar el PDF.');
        }
    }

    /**
     * Genera el texto del código QR según los requisitos de SUNAT para boletas
     *
     * @param \App\Boleta_m $boleta
     * @param \App\Empresa $empresa
     * @param \App\Igv $igv
     * @return string
     */
    private function generarTextoQRBoletaM($boleta, $empresa, $igv)
    {
        try {
            $ruc = $empresa->ruc ?? '';

            $tipoDocumento = '03';

            $codBoleta = $boleta->codigo_boleta ?? '';
            $partes = explode('-', $codBoleta);
            $serie = $partes[0] ?? '';
            $numero = $partes[1] ?? '';

            $sub_total_gravado = $boleta->op_gravada ?? 0;
            $igv_monto = $sub_total_gravado * ($igv->igv_total / 100);

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
            $boleta = Boleta_m::find($id);
            if ($boleta) {
                $codigo = substr(md5($id . env('APP_KEY') . 'boleta_manual'), 0, 22);

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
        $boletas = Boleta_m::all();

        foreach ($boletas as $bol) {
            if (substr(md5($bol->id . env('APP_KEY') . 'boleta_manual'), 0, 22) === $codigo) {
                return redirect()->route('boleta_manual.pdf', $bol->id);
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

            $empresa = Empresa::first();
            $boleta = Boleta_m::find($id);
            $boleta_registro = Boleta_registros_m::where('boleta_m_id', $id)->get();
            $sum = 0;
            $igv = Igv::first();
            $sub_total = 0;
            $banco = Banco::where('estado', 0)->get();
            $j = 1;

            $textoQR = $this->generarTextoQRBoletaM($boleta, $empresa, $igv);
            $qrCode  = $this->generarImagenQR($textoQR);

            // Generar PDF
            $archivo = 'PDF-DOC-' . $boleta->codigo_boleta . '-' . $empresa->ruc . ".pdf";
            $pdf = PDF::loadView('transaccion.venta.boleta.boleta_manual.pdf', compact('j','boleta','empresa','boleta_registro','sum','igv','sub_total','banco','textoQR','qrCode'));
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

            $titulo = "Boleta Manual - " . $boleta->codigo_boleta;
            $mensaje_html = "Estimado cliente, adjuntamos la boleta " . $boleta->codigo_boleta;
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
            $banco = Banco::where('estado', 0)->get();

            // Configuración de email
            $yourEmail = $config_email->email;
            $firma = $config_email->firma;
            $alto = $config_email->alto_firma;
            $ancho = $config_email->ancho_firma;

            $titulo = "Boletas Manuales - " . count($boleta_ids) . " documento(s)";
            $mensaje_html = "Estimado cliente, adjuntamos las boletas solicitadas.";
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

            $archivos_temporales = [];
            $archivos_xml = [];

            // Generar y adjuntar cada PDF
            foreach ($boleta_ids as $boleta_id) {
                $boleta = Boleta_m::find($boleta_id);
                if (!$boleta) continue;

                $boleta_registro = Boleta_registros_m::where('boleta_m_id', $boleta_id)->get();
                $sum = 0;
                $sub_total = 0;
                $j = 1;

                $textoQR = $this->generarTextoQRBoletaM($boleta, $empresa, $igv);
                $qrCode  = $this->generarImagenQR($textoQR);

                // Generar PDF
                $archivo = 'PDF-DOC-' . $boleta->codigo_boleta . '-' . $empresa->ruc . ".pdf";
                $pdf = PDF::loadView('transaccion.venta.boleta.boleta_manual.pdf', compact('j','boleta','empresa','boleta_registro','sum','igv','sub_total','banco','textoQR','qrCode'));
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
