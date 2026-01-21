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
use App\Kardex_entrada;
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
use App\Detracciones;
use App\Facturacion_registro;
use App\GuiaRemisionManual;
use App\MedioPagoDetraccion;
use App\Nota_Credito;
use App\Nota_Debito;
use App\TipoDetraccion;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use ZipArchive;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\Storage;
use App\EmailBandejaEnvios;
use App\EmailBandejaEnviosArchivos;
use App\EmailConfiguraciones;

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
        if(count($facturacion) == 0){
            $nota_credito[0] = null;
            $nota_debito[0] = null;
        }else{
            foreach ($facturacion as $key => $factura) {
                $nota_credito[$key] = Nota_Credito::where('facturacion_m_id', $factura->id)->first();
                $nota_debito[$key] = Nota_Debito::where('facturacion_m_id', $factura->id)->first();
                if (!isset($nota_credito[$key])) {
                    $nota_credito[$key] = null;
                }
                if (!isset($nota_debito[$key])) {
                    $nota_debito[$key] = null;
                }
            }
        }


        return view('transaccion.venta.facturacion.facturacion_manual.index', compact('facturacion','igv','nota_credito','nota_debito'));
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

        $inventario_inicial=Producto::count();
        $servicios = Servicios::count();
        if($inventario_inicial == 0 && $servicios == 0){
            return back()->withErrors(['No hay Productos o Servicios Agregados ']);
        }
        // Servicios
        $servicios=Servicios::where('estado_anular',0)->get();

        // Tipo de cambio
        $tipo_cambio=TipoCambio::latest('created_at')->first();

        // Moneda
        $moneda=Moneda::where('principal','1')->first();

        // Número de factura
        // $factura_numero="FA01-000001";

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

        $fecha_hoy = Carbon::now();
        $fecha_1 = $fecha_hoy->format('Y-m-d');
        $detraccion = TipoDetraccion::all();
        $medio_pago = MedioPagoDetraccion::all();
        $tipo_cambio = TipoCambio::latest()->first();

        return view('transaccion.venta.facturacion.facturacion_manual.create',compact('productos','servicios','forma_pagos','clientes','personales','igv','moneda','p_venta','empresa','categoria','factura_numero','empresa','tipo_operacion','almacenes','sucursal','factura_numero','fecha_1','detraccion','medio_pago','tipo_cambio'));
    }

    public function change_almacen_tipo(Request $request){
        // return $request;
        $almacen = $request->get('almacen');
        $sucursal =Almacen::where('id', $almacen)->first();
            // return $sucursal;
        $cod_guia= Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
        $cod_guia_all = Codigo_guia_almacen::where('almacen_id', '!=' ,$sucursal->id)->get();

        $last_numb=Facturacion_m::where('almacen_id',$sucursal->id)->latest()->first();
        if(!isset($last_numb) && !is_numeric($cod_guia->cod_factura_m)){
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

        $tipo_op = $request->get('tipo_operacion');
        $tipo_ex = explode(' ', $tipo_op);
        if($tipo_ex[0] == '1001' || $tipo_ex[0] == '1002' || $tipo_ex[0] == '1003' ||$tipo_ex[0] == '1004'){
            //
            // $detracciones = Tipo_operacion_f::where('codigo', $tipo_ex[0])->first();
            $fact_detra = new Detracciones();
            $fact_detra->factura_m_id = $facturacion->id;
            $fact_detra->id_cod_tipo_detraccion = $request->get('tipo_detraccion');
            $fact_detra->id_cod_medio_pago = $request->get('medio_pago_detraccion');
            $fact_detra->monto_total_factura = $request->get('costo_total');
            $fact_detra->porcentaje_detraccion = $request->get('porcentaje_detraccion');
            $fact_detra->monto_detraccion = $request->get('total_detraccion');
            $fact_detra->estado = 1;
            $fact_detra->save();
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
        if($facturacion->forma_pago_id == 2){
            Facturacion_m::revision_cuotas($facturacion->id);
        }



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
        if($facturacion->tipo_operacion_id == 12 || $facturacion->tipo_operacion_id == 13 || $facturacion->tipo_operacion_id == 14 ||$facturacion->tipo_operacion_id == 15 ){
            $detraccion = Detracciones::where('factura_m_id', $facturacion->id)->first();
            if ($facturacion->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('facturacion_id', $facturacion->id)->get();
            }else{
                $cuotas = "not";
            }
        }else{
            $detraccion = 'not';
            $cuotas = "not";
        }
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $j = 1;

        return view('transaccion.venta.facturacion.facturacion_manual.show', compact('j','facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco','detraccion'));

    }

    public function pdf(Request $request,$id){
        $name = $request->get('name');
        $empresa=Empresa::first();
        $facturacion=Facturacion_m::find($id);
        $facturacion_registro=Facturacion_registro_m::where('facturacion_m_id',$id)->get();
        if($facturacion->tipo_operacion_id == 12 || $facturacion->tipo_operacion_id == 13 || $facturacion->tipo_operacion_id == 14 ||$facturacion->tipo_operacion_id == 15 ){
            $detraccion = Detracciones::where('factura_m_id', $facturacion->id)->first();
            if ($facturacion->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('facturacion_m_id', $facturacion->id)->get();
            }else{
                $cuotas = "not";
            }

        }else{
            $detraccion = "not";
            $cuotas = "not";
        }

        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $banco_count=Banco::where('estado','0')->count();
        $i = 1;
        $textoQR = $this->generarTextoQRFacturaM($facturacion, $empresa, $igv);
        $qrCode = $this->generarImagenQR($textoQR);

        // $archivo=$name.'_'.$id;
        // return $detraccion;
        $pdf=PDF::loadView('transaccion.venta.facturacion.facturacion_manual.pdf',compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco','banco_count','i','detraccion','cuotas','textoQR','qrCode'));
        // return view('transaccion.venta.facturacion.facturacion_manual.pdf',compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco','banco_count','i','detraccion','cuotas','textoQR','qrCode'));
        return $pdf->download('FacturaM - '.$facturacion->codigo_fac.'.pdf');
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
        if($facturacion->tipo_operacion_id == 12 || $facturacion->tipo_operacion_id == 13 || $facturacion->tipo_operacion_id == 14 ||$facturacion->tipo_operacion_id == 15 ){
            $detraccion = Detracciones::where('factura_m_id', $facturacion->id)->first();
            if ($facturacion->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('facturacion_m_id', $facturacion->id)->get();
            }else{
                $cuotas = "not";
            }
        }else{
            $detraccion = 'not';
            $cuotas = "not";
        }
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $j = 1;
        $textoQR = $this->generarTextoQRFacturaM($facturacion, $empresa, $igv);
        $qrCode = $this->generarImagenQR($textoQR);
        // return $cuotas;
        return view('transaccion.venta.facturacion.facturacion_manual.print', compact('j','facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco','detraccion','cuotas','qrCode','textoQR' ));
    }
    public function ajax_remision(Request $request){
        $id_cli = $request->get('id_cliente');
        // buscar guias de remision por cliente que no este enviadas a la sunat

        $guias = GuiaRemisionManual::where('cliente_id', $id_cli)->where('g_electronica', 0)->get();
        // return count($guias);

        if(count($guias) != 0){
            foreach ($guias as $guias_r) {
                $guias_cod[] = $guias_r->cod_guia;
            }
            return $guias_cod;
        }else{
            $guias_cod = "vacio";
            return $guias_cod;
        }



    }
    public function ticket(Request $request,$id){

        $facturacion=Facturacion_m::find($id);
        $facturacion_registro=Facturacion_registro_m::where('facturacion_m_id',$id)->get();
        $empresa=Empresa::first();
        $moneda = Moneda::where('id',$facturacion->moneda_id)->first();
        $igv=Igv::first();
        return view('transaccion.venta.facturacion.facturacion_manual.ticket',compact('facturacion','facturacion_registro','empresa','igv','moneda'));
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

    //FUNCION PARA COMPROBANTES
    public function exportarFacturasM(Request $request){
        if (ob_get_contents()) {
            ob_end_clean();
        }

        if ($request->has('factura_ids') && !empty($request->input('factura_ids'))) {
            $facturaIds = $request->input('factura_ids');

            $facturasM = Facturacion_m::with([
                'cotizacionM',
                'almacen',
                'cliente',
                'moneda',
                'forma_pago',
                'user.personal',
                'tipo_operacion',
                'tipo_documento'
            ])
            ->whereIn('id', $facturaIds)
            ->orderBy('created_at', 'desc')
            ->get();
        } else {
            $daterange = $request->get('daterange', date('01/m/Y') . ' - ' . date('t/m/Y'));
            $filter = $request->get('value');
            $tipo = $request->get('tipo_coti');

            $starDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $daterange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $daterange)[1])->endOfDay();

            $query = Facturacion_m::with([
                'cotizacionM',
                'almacen',
                'cliente',
                'moneda',
                'forma_pago',
                'user.personal',
                'tipo_operacion',
                'tipo_documento'
            ])

            ->whereBetween('created_at', [$starDate, $endDate])
            ->orderBy('created_at', 'desc');

            if (!empty($filter)) {
                $query->where(function ($q) use ($filter) {
                    $q->where('codigo_fac', 'like', '%' . $filter . '%');
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
                $query->where('tipo' , $tipo);
            }

            $facturasM = $query->get();
        }

        // Definir encabezados
        $headers = [
            'Código Factura Manual',
            'Cotizacion',
            'Almacén',
            'Orden de compra',
            'Guia de Remision',
            'Cliente',
            'Moneda',
            'Forma de pago',
            'Fecha de emision',
            'Fecha de vencimiento',
            'Cambio',
            'Observacion',
            'Personal',
            'Estado',
            'SUNAT',
            'Estado de pago',
            'Operacion gravada',
            'Operacion inafecta',
            'Operacion Exonerada',
            'Operacion gratuita',
            'Nota Credito',
            'Nota Debito',
            'Tipo de Operacion',
            'Tipo de Documento',
            'Subtotal',
            'IGV',
            'Importe Total'

        ];

        // Iniciar array con los encabezados
        $rows = [$headers];

        // Agregar los datos de cada factura
        foreach ($facturasM as $facturaM) {
            // Obtener el nombre del almacén o 'N/A' si no existe
            $codigoCotizadorM =optional($facturaM->cotizacionM)->cod_cotizacion;
            $nombreAlmacen = optional($facturaM->almacen)->nombre;
            $nombreCliente= optional($facturaM->cliente)->nombre;
            $nombreMoneda= optional($facturaM->moneda)->nombre;
            $nombreFormaPago= optional($facturaM->forma_pago)->nombre;
            $nombreApellidoPersonal= '';

            if ($facturaM->user && $facturaM->user->personal) {
                $nombreApellidoPersonal = trim($facturaM->user->personal->nombres . ' ' . $facturaM->user->personal->apellidos);
            }

            $estado = $facturaM->estado ? 'Activo' : 'Inactivo';
            $sunat = $facturaM->f_electronica ? 'Emitido' : 'Pendiente';
            $estadoPago = $facturaM->estado_pago == 0 ? 'Sin pagar' : ($facturaM->estado_pago == 1 ? 'Pagado por adelantado' : 'Pagado');
            $infoOperacion = optional($facturaM->tipo_operacion)->informacion;
            $infoDocumento = optional($facturaM->tipo_documento)->informacion;
            $subtotal = ($facturaM->op_gravada ?? 0) + ($facturaM->op_inafecta ?? 0) + ($facturaM->op_exonerada ?? 0);
            $subtotalGravado = ($facturaM->op_gravada);
            $igv_p = round(($subtotalGravado ?? 0) * 0.18, 2);
            $importeTotal = round($subtotal + $igv_p ,2);

            $row = [
                $facturaM->codigo_fac,
                $codigoCotizadorM,
                $nombreAlmacen,
                $facturaM->orden_compra,
                $facturaM->guia_remision,
                $nombreCliente,
                $nombreMoneda,
                $nombreFormaPago,
                $facturaM->fecha_emision,
                $facturaM->fecha_vencimiento,
                $facturaM->cambio,
                $facturaM->observacion,
                $nombreApellidoPersonal,
                $estado,
                $sunat,
                $estadoPago,
                $facturaM->op_gravada,
                $facturaM->op_inafecta,
                $facturaM->op_exonerada,
                $facturaM->op_gratuita,
                $facturaM->nota_credito,
                $facturaM->nota_debito,
                $infoOperacion,
                $infoDocumento,
                $subtotal,
                $igv_p,
                $importeTotal

            ];

            $rows[] = $row;
        }

        // Crear la clase de exportación usando la misma estructura que tienes
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
                        // Ajustar ancho automático para todas las columnas
                        foreach(range('A','Z') as $column) {
                            $event->sheet->getColumnDimension($column)->setAutoSize(true);
                        }
                        // Para columnas dobles (AA, AB, etc.)
                        foreach(range('A','Z') as $letter1) {
                            foreach(range('A','Z') as $letter2) {
                                $event->sheet->getColumnDimension($letter1.$letter2)->setAutoSize(true);
                            }
                        }
                    },
                ];
            }
        };

        // Generar el archivo con fecha actual
        $fecha = now('America/Lima')->format('d-m-Y');
        return Excel::download($export, 'Facturas Manuales ' . $fecha . '.xlsx');
    }

    public function printMultiple(Request $request) {
        try {
            $facturaMIds = $request->query('facturaM_ids', []);

            if (empty($facturaMIds) || !is_array($facturaMIds)) {
                return back()->withErrors(['No se seleccionaron facturas manuales para imprimir.']);
            }

            $facturas = Facturacion_m::whereIn('id', $facturaMIds)->get();

            if ($facturas->count() !== count($facturaMIds)) {
                return back()->withErrors(['Algunas facturas manuales seleccionadas no existen.']);
            }

            $inventario_inicial = Kardex_entrada::count();
            $servicios = Servicios::count();
            if ($inventario_inicial == 0 && $servicios == 0) {
                return back()->withErrors(['No hay Productos o Servicios Agregados']);
            }

            $empresa = Empresa::first();
            $igv = Igv::first();

            $facturasData = [];

            foreach ($facturas as $factura) {
                $factura_registro = Facturacion_registro_m::where('facturacion_m_id', $factura->id)->get();

                if($factura->tipo_operacion_id == 12 || $factura->tipo_operacion_id == 13 || $factura->tipo_operacion_id == 14 || $factura->tipo_operacion_id == 15) {
                    $detraccion = Detracciones::where('factura_m_id', $factura->id)->first();
                    if ($factura->forma_pago_id == 2) {
                        $cuotas = Cuotas_credito::where('facturacion_m_id', $factura->id)->get();
                    } else {
                        $cuotas = "not";
                    }
                } else {
                    $detraccion = 'not';
                    $cuotas = "not";
                }

                $textoQR = $this->generarTextoQRFacturaM($factura, $empresa, $igv);
                $qrCode = $this->generarImagenQR($textoQR);

                $facturasData[] = [
                    'factura' => $factura,
                    'factura_registro' => $factura_registro,
                    'sub_total' => $factura->op_gravada + $factura->op_inafecta + $factura->op_exonerada,
                    'detraccion' => $detraccion,
                    'cuotas' => $cuotas,
                    'qrCode' => $qrCode,
                    'textoQR' => $textoQR,
                ];
            }

            $banco = Banco::where('estado', 0)->get();

            return view('transaccion.comprobantes.factura_manual.print_multiple', compact(
                'facturasData',
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
            $facturaMIds = $request->input('facturaM_ids', []);

            if (empty($facturaMIds) || !is_array($facturaMIds)) {
                return back()->with('error', 'No se seleccionaron facturas manuales para descargar.');
            }

            if (count($facturaMIds) === 1) {
                return $this->downloadSinglePDF($facturaMIds[0]);
            }

            $facturas = Facturacion_m::whereIn('id', $facturaMIds)->get();

            if ($facturas->count() !== count($facturaMIds)) {
                return back()->with('error', 'Algunas facturas manuales seleccionadas no existen.');
            }

            // Crear en storage/app/temp en lugar de sys_get_temp_dir
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            $zipName = 'Facturas_Manuales_' . date('Y-m-d_H-i-s') . '.zip';
            $tempZip = $tempDir . DIRECTORY_SEPARATOR . $zipName;

            // Limpiar si existe
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

            foreach ($facturas as $facturacion) {
                try {
                    $facturacion_registro = Facturacion_registro_m::where('facturacion_m_id', $facturacion->id)->get();

                    if($facturacion->tipo_operacion_id == 12 || $facturacion->tipo_operacion_id == 13 ||
                    $facturacion->tipo_operacion_id == 14 || $facturacion->tipo_operacion_id == 15) {
                        $detraccion = Detracciones::where('factura_m_id', $facturacion->id)->first();
                        if ($facturacion->forma_pago_id == 2) {
                            $cuotas = Cuotas_credito::where('facturacion_m_id', $facturacion->id)->get();
                        } else {
                            $cuotas = "not";
                        }
                    } else {
                        $detraccion = "not";
                        $cuotas = "not";
                    }

                    $sum = 0;
                    $sub_total = 0;
                    $i = 1;
                    $textoQR = $this->generarTextoQRFacturaM($facturacion, $empresa, $igv);
                    $qrCode = $this->generarImagenQR($textoQR);

                    $pdf = PDF::loadView('transaccion.venta.facturacion.facturacion_manual.pdf', compact(
                        'facturacion',
                        'empresa',
                        'facturacion_registro',
                        'sum',
                        'igv',
                        'sub_total',
                        'banco',
                        'banco_count',
                        'i',
                        'detraccion',
                        'cuotas',
                        'qrCode'
                        ,'textoQR'
                    ));

                    $pdfContent = $pdf->output();

                    $codigoFactura = preg_replace('/[^a-zA-Z0-9_-]/', '_', $facturacion->codigo_fac);
                    $fileName = 'FacturaM_' . $codigoFactura . '.pdf';
                    $zip->addFromString($fileName, $pdfContent);

                } catch (\Exception $e) {
                    continue;
                }
            }

            $zip->close();
            unset($zip);
            clearstatcache(true, $tempZip);
            usleep(100000);

            // Verificar que existe
            if (!file_exists($tempZip) || filesize($tempZip) == 0) {
                @unlink($tempZip);
                return back()->with('error', 'El archivo ZIP no se creó correctamente');
            }

            // SOLUCIÓN: Limpiar cualquier output buffer y enviar el archivo manualmente
            // Esto evita que Laravel o algún middleware corrompa el ZIP

            // Limpiar todos los buffers
            while (ob_get_level()) {
                ob_end_clean();
            }

            // Headers para descarga
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipName . '"');
            header('Content-Length: ' . filesize($tempZip));
            header('Cache-Control: no-cache, must-revalidate');
            header('Pragma: public');

            // Enviar archivo y eliminar
            readfile($tempZip);
            @unlink($tempZip);

            exit; // IMPORTANTE: Salir para evitar que Laravel agregue algo más

        } catch (\Exception $e) {
            return back()->with('error', 'Error al descargar facturas manuales: ' . $e->getMessage());
        }
    }

    private function downloadSinglePDF($id)
    {
        try {
            $facturacion = Facturacion_m::find($id);
            if (!$facturacion) {
                return back()->with('error', 'Factura manual no encontrada.');
            }

            $facturacion_registro = Facturacion_registro_m::where('facturacion_m_id', $id)->get();
            $igv = Igv::first();
            $banco = Banco::where('estado', 0)->get();
            $banco_count = Banco::where('estado', '0')->count();
            $empresa = Empresa::first();


            if($facturacion->tipo_operacion_id == 12 || $facturacion->tipo_operacion_id == 13 ||
            $facturacion->tipo_operacion_id == 14 || $facturacion->tipo_operacion_id == 15) {
                $detraccion = Detracciones::where('factura_m_id', $facturacion->id)->first();
                if ($facturacion->forma_pago_id == 2) {
                    $cuotas = Cuotas_credito::where('facturacion_m_id', $facturacion->id)->get();
                } else {
                    $cuotas = "not";
                }
            } else {
                $detraccion = "not";
                $cuotas = "not";
            }

            $sum = 0;
            $sub_total = 0;
            $i = 1;
            $textoQR = $this->generarTextoQRFacturaM($facturacion, $empresa, $igv);
            $qrCode = $this->generarImagenQR($textoQR);

            $pdf = PDF::loadView('transaccion.venta.facturacion.facturacion_manual.pdf', compact(
                'facturacion',
                'empresa',
                'facturacion_registro',
                'sum',
                'igv',
                'sub_total',
                'banco',
                'banco_count',
                'i',
                'detraccion',
                'cuotas',
                'qrCode',
                'textoQR'
            ));

            return $pdf->download('FacturaM_' . $facturacion->codigo_fac . '.pdf');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    /**
     * Genera el texto del código QR según los requisitos de SUNAT para facturas manuales
     *
     * @param \App\Facturacion_m $factura
     * @param \App\Empresa $empresa
     * @param \App\Igv $igv
     * @return string
     */
    private function generarTextoQRFacturaM($factura, $empresa, $igv)
    {
        try {
            $ruc = $empresa->ruc ?? '';

            $tipoDocumento = '01';

            $codFactura = $factura->codigo_factura ?? '';
            $partes = explode('-', $codFactura);
            $serie = $partes[0] ?? '';
            $numero = $partes[1] ?? '';

            $sub_total_gravado = $factura->op_gravada ?? 0;
            $igv_monto = round($sub_total_gravado * ($igv->igv_total / 100), 2);

            $sub_total = ($factura->op_gravada ?? 0) + ($factura->op_inafecta ?? 0) + ($factura->op_exonerada ?? 0);
            $montoTotal = number_format(round($sub_total + $igv_monto, 2), 2, '.', '');
            $igv_formato = number_format($igv_monto, 2, '.', '');

            $fechaEmision = $factura->fecha_emision ?? date('Y-m-d');

            $tipoDocCliente = '6';
            $numDocCliente = '';

            if (isset($factura->cliente_id) && $factura->cliente) {
                $numDocCliente = $factura->cliente->numero_documento ?? '';
            } elseif (isset($factura->cotizacion) && $factura->cotizacion->cliente) {
                $numDocCliente = $factura->cotizacion->cliente->numero_documento ?? '';
            }

            $valorResumen = $factura->hash_cpe ?? '';

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
        $facturaIds = $request->factura_ids;

        $mensaje = "";

        foreach ($facturaIds as $id) {
            $factura = Facturacion_m::find($id);
            if ($factura) {
                $codigo = substr(md5($id . env('APP_KEY') . 'factura_manual'), 0, 22);

                $pdfUrl = url("factura_manual/share/{$codigo}");

                $mensaje .= "{$pdfUrl}\n";
            }
        }

        $mensajeCodificado = urlencode($mensaje);
        $whatsappUrl = "https://wa.me/{$numero}?text={$mensajeCodificado}";

        return redirect()->away($whatsappUrl);
    }

    public function descargarPorCodigo($codigo)
    {
        $facturas = Facturacion_m::all();

        foreach ($facturas as $fac) {
            if (substr(md5($fac->id . env('APP_KEY') . 'factura_manual'), 0, 22) === $codigo) {
                return redirect()->route('pdf_fac_m', $fac->id);
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
            $facturacion = Facturacion_m::find($id);
            $facturacion_registro = Facturacion_registro_m::where('facturacion_m_id', $id)->get();
            $sum = 0;
            $igv = Igv::first();
            $sub_total = 0;
            $banco = Banco::where('estado', 0)->get();
            $banco_count = Banco::where('estado', '0')->count();
            $i = 1;

            // Generar PDF
            $archivo = 'PDF-DOC-' . $facturacion->codigo_fac . '-' . $empresa->ruc . ".pdf";
            $pdf = PDF::loadView('transaccion.venta.facturacion.facturacion_manual.pdf', compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco','banco_count','i'));
            $content = $pdf->download();
            $especif = $date . $archivo;
            Storage::disk('mailbox')->put($especif, $content);

            // XML si aplica
            $xml_file = null;
            if ($facturacion->f_electronica == 1) {
                $xml_file = $empresa->ruc . '-01-' . $facturacion->codigo_fac . '.xml';
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

            $titulo = "Factura Manual - " . $facturacion->codigo_fac;
            $mensaje_html = "Estimado cliente, adjuntamos la factura " . $facturacion->codigo_fac;
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
            $factura_ids = $request->get('factura_ids', []);

            if (empty($factura_ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se seleccionaron facturas para enviar.'
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
            $banco_count = Banco::where('estado', '0')->count();

            // Configuración de email
            $yourEmail = $config_email->email;
            $firma = $config_email->firma;
            $alto = $config_email->alto_firma;
            $ancho = $config_email->ancho_firma;

            $titulo = "Facturas Manuales - " . count($factura_ids) . " documento(s)";
            $mensaje_html = "Estimado cliente, adjuntamos las facturas solicitadas.";
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
            foreach ($factura_ids as $factura_id) {
                $facturacion = Facturacion_m::find($factura_id);
                if (!$facturacion) continue;

                $facturacion_registro = Facturacion_registro_m::where('facturacion_m_id', $factura_id)->get();
                $sum = 0;
                $sub_total = 0;
                $i = 1;

                // Generar PDF
                $archivo = 'PDF-DOC-' . $facturacion->codigo_fac . '-' . $empresa->ruc . ".pdf";
                $pdf = PDF::loadView('transaccion.venta.facturacion.facturacion_manual.pdf', compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco','banco_count','i'));
                $content = $pdf->download();
                $especif = $date . $archivo;
                Storage::disk('mailbox')->put($especif, $content);

                $pdfile = public_path() . '/archivos/' . $especif;
                $message->attach(\Swift_Attachment::fromPath($pdfile));

                $archivos_temporales[] = $especif;

                // Adjuntar XML si existe
                if ($facturacion->f_electronica == 1) {
                    $xml_file = $empresa->ruc . '-01-' . $facturacion->codigo_fac . '.xml';
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
                    'message' => 'Se enviaron ' . count($factura_ids) . ' factura(s) exitosamente a: ' . $email
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
