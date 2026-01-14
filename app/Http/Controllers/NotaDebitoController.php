<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Almacen;
use App\Codigo_guia_almacen;
use App\Facturacion;
use App\Facturacion_registro;
use App\Servicios;
use App\Boleta;
use App\Boleta_m;
use App\Boleta_registro;
use App\Boleta_registros_m;
use App\Empresa;
use App\Kardex_entrada;
use App\Igv;
use App\Banco;
use App\Nota_Debito;
use App\Facturacion_m;
use App\Facturacion_registro_m;
use App\Nota_Debito_registro;
use Carbon\Carbon;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DateTime;
use Illuminate\Support\Facades\Log;

class NotaDebitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notas_debitos=Nota_Debito::get();
        return view('transaccion.venta.nota_debito.index',compact('notas_debitos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //cambiar de 0 a 1 en f_electronica
        $facturas=Facturacion::where('f_electronica',1)->where('estado',0)->where('nota_debito',0)->get();

        $factura_manual=Facturacion_m::where('f_electronica',1)->where('estado',0)->where('nota_debito',0)->get();
        $igv=Igv::first();
        return view('transaccion.venta.nota_debito.lista_facturacion',compact('facturas','factura_manual','igv'));
    }

    public function create_boleta()
    {
        //cambiar de 0 a 1 en f_electronica
        $boletas=Boleta::where('b_electronica',1)->where('estado',0)->where('nota_debito',0)->get();
        $boleta_manual = Boleta_m::where('b_electronica',1)->where('estado',0)->where('nota_debito',0)->get();;
        $igv=Igv::first();
        return view('transaccion.venta.nota_debito.lista_boleta',compact('boletas','boleta_manual','igv'));
    }

    public function create_nota_debito(Request $request){


        // return $request;
        $tipo = $request->get('tipo');
        if($tipo == "normal"){
            $facturacion=Facturacion::find($request->factura_id);
            $facturacion_registro=Facturacion_registro::where('facturacion_id',$request->factura_id)->get();
        }else{
            $facturacion=Facturacion_m::find($request->factura_id);
            $facturacion_registro=Facturacion_registro_m::where('facturacion_m_id',$request->factura_id)->get();
        }

        $almacen=$facturacion->almacen_id;

        //obtencion del almacen
        $almacen_id =Almacen::where('id', $almacen)->first();
        $sucursal = Codigo_guia_almacen::where('almacen_id',$almacen_id->id)->first();
        $nota_cod_n_debito=$sucursal->cod_nota_debito;
        if (is_numeric($nota_cod_n_debito)) {
            // exprecion del numero de la nota de debito
            $nota_cod_n_debito++;
            $sucursal_nr = str_pad($sucursal->serie_nota_debito, 2, "0", STR_PAD_LEFT);
            $nota_debito_nr=str_pad($nota_cod_n_debito, 8, "0", STR_PAD_LEFT);
        }else{

            // Exprecion del numero de nota de debito
            // Generacion de numero de nota de debito
            $ultima_nota_c=Nota_debito::where('almacen_id',$almacen_id->id)->latest()->first();
            $nota_debito_num=$ultima_nota_c->codigo_n_d;
            $nota_debito_num_string_porcion= explode("-", $nota_debito_num);
            $nota_debito_num_string=$nota_debito_num_string_porcion[1];
            $nota_debito_num=(int)$nota_debito_num_string;

            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_nota_debito','DESC')->latest()->first();
            if($nota_debito_num == 99999999){
                $nota_debito_num = 00000000;
            }else{
                $ultima_nota_c = $sucursal->serie_nota_debito;
            }
            $nota_debito_num++;
            $sucursal_nr = str_pad($ultima_nota_c, 2, "0", STR_PAD_LEFT);
            $nota_debito_nr=str_pad($nota_debito_num, 8, "0", STR_PAD_LEFT);
        }

        $nota_debito_numero="FF".$sucursal_nr."-".$nota_debito_nr;

        $empresa=Empresa::first();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        // return $request;
        return view('transaccion.venta.nota_debito.create',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco','nota_debito_numero','tipo'));

    }

    public function create_boleta_nota_debito(Request $request){

        // return $request;

        $tipo = $request->get('tipo');
        if($tipo == "normal"){
            $boleta=Boleta::find($request->boleta_id);
            $boleta_registro=Boleta_registro::where('boleta_id',$request->boleta_id)->get();
        }else{
            $boleta=Boleta_m::find($request->boleta_id);
            $boleta_registro=Boleta_registros_m::where('boleta_m_id',$request->boleta_id)->get();
        }

        // return $boleta;
        $almacen=$boleta->almacen_id;

        //obtencion del almacen
        $almacen_id =Almacen::where('id', $almacen)->first();
        $sucursal = Codigo_guia_almacen::where('almacen_id',$almacen_id->id)->first();
        $nota_cod_n_debito=$sucursal->cod_nota_debito;
        if (is_numeric($nota_cod_n_debito)) {
            // exprecion del numero de la nota de debito
            $nota_cod_n_debito++;
            $sucursal_nr = str_pad($sucursal->serie_nota_debito, 2, "0", STR_PAD_LEFT);
            $nota_debito_nr=str_pad($nota_cod_n_debito, 8, "0", STR_PAD_LEFT);
        }else{

            // Exprecion del numero de nota de debito
            // Generacion de numero de nota de debito
            $ultima_nota_c=Nota_debito::where('almacen_id',$almacen_id->id)->latest()->first();
            $nota_debito_num=$ultima_nota_c->codigo_n_d;
            $nota_debito_num_string_porcion= explode("-", $nota_debito_num);
            $nota_debito_num_string=$nota_debito_num_string_porcion[1];
            $nota_debito_num=(int)$nota_debito_num_string;

            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_nota_debito','DESC')->latest()->first();
            if($nota_debito_num == 99999999){
                $nota_debito_num = 00000000;
            }else{
                $ultima_nota_c = $sucursal->serie_nota_debito;
            }
            $nota_debito_num++;
            $sucursal_nr = str_pad($ultima_nota_c, 2, "0", STR_PAD_LEFT);
            $nota_debito_nr=str_pad($nota_debito_num, 8, "0", STR_PAD_LEFT);
        }

        $nota_debito_numero="FF".$sucursal_nr."-".$nota_debito_nr;


        $empresa=Empresa::first();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();

        return view('transaccion.venta.nota_debito.create_boleta',compact('boleta','boleta_registro','empresa','igv','sub_total','banco','nota_debito_numero','tipo'));
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        // return $request;
        if($request->tipo_nota == "manual"){
            $factura=Facturacion_m::where('id',$id)->first();
            $factura_registro=Facturacion_registro_m::where('facturacion_m_id',$id)->get();
        }else{
            $factura=Facturacion::where('id',$id)->first();
            $factura_registro=Facturacion_registro::where('facturacion_id',$id)->get();
        }
        // return $factura;
        //contador nota de creditos
        // $notas_debitos_count=Nota_Debito_registro::count();
        // $notas_debitos_count++;

        //configuracion
        // $see=config_acceso_sunat::facturacion_electronica();

        $gravada=0;
        $exonerada=0;
        $inafecta=0;

        $gravada_s=0;
        $exonerada_s=0;
        $inafecta_s=0;

        // code nota_c
        // obtencion de la sucursal
        $almacen=$factura->almacen_id;

        //obtencion del almacen
        $almacen_id =Almacen::where('id', $almacen)->first();
        $sucursal = Codigo_guia_almacen::where('almacen_id',$almacen_id->id)->first();
        $nota_cod_n_debito=$sucursal->cod_nota_debito;
        if (is_numeric($nota_cod_n_debito)) {
            // exprecion del numero de la nota de debito
            $nota_cod_n_debito++;
            $sucursal_nr = str_pad($sucursal->serie_nota_debito, 2, "0", STR_PAD_LEFT);
            $nota_debito_nr=str_pad($nota_cod_n_debito, 8, "0", STR_PAD_LEFT);
        }else{

            // Exprecion del numero de nota de debito
            // Generacion de numero de nota de debito
            $ultima_nota_c=Nota_debito::where('almacen_id',$almacen_id->id)->latest()->first();
            $nota_debito_num=$ultima_nota_c->codigo_n_d;
            $nota_debito_num_string_porcion= explode("-", $nota_debito_num);
            $nota_debito_num_string=$nota_debito_num_string_porcion[1];
            $nota_debito_num=(int)$nota_debito_num_string;

            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_nota_debito','DESC')->latest()->first();
            if($nota_debito_num == 99999999){
                $ultima_nota_c = $almacen_codigo->serie_nota_debito+1;
                $almacen_save_last = Codigo_guia_almacen::find($sucursal->id);
                $almacen_save_last->serie_nota_debito = $almacen_codigo->serie_nota_debito+1;
                $almacen_save_last->save();
                $nota_debito_num = 00000000;
            }else{
                $ultima_nota_c = $sucursal->serie_nota_debito;
            }
            $nota_debito_num++;
            $sucursal_nr = str_pad($ultima_nota_c, 2, "0", STR_PAD_LEFT);
            $nota_debito_nr=str_pad($nota_debito_num, 8, "0", STR_PAD_LEFT);
        }

        $nota_debito_numero="FF".$sucursal_nr."-".$nota_debito_nr;

        // if($factura->tipo=="producto"){

            $contadores=count($factura_registro);
            for($a=0;$a<$contadores;$a++){
                $string=(string)$a;
                $nombre="input_disabled_".$string;
                $nombre_precio="input_disabled_precio_".$string;
                if($request->$nombre_precio==NULL){
                }else{
                    if(isset($factura_registro[$a]->producto_id)){
                        if(strpos($factura_registro[$a]->producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                            $gravada += round($request->$nombre_precio*$factura_registro[$a]->cantidad,2);
                        }
                        if(strpos($factura_registro[$a]->producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                            $exonerada += round($request->$nombre_precio*$factura_registro[$a]->cantidad,2);
                        }
                        if(strpos($factura_registro[$a]->producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                            $inafecta += round($request->$nombre_precio*$factura_registro[$a]->cantidad,2);
                        }
                    }else{
                        if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                            $gravada += round($request->$nombre_precio*$factura_registro[$a]->cantidad,2);
                        }
                        if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                            $exonerada += round($request->$nombre_precio*$factura_registro[$a]->cantidad,2);
                        }
                        if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                            $inafecta += round($request->$nombre_precio*$factura_registro[$a]->cantidad,2);
                        }
                    }
                }
            }

            // $invoice=Config_fe::nota_debito($factura,$factura_registro,$request,$notas_debitos_count,$nota_debito_numero,$gravada,$exonerada,$inafecta,$request->motivo);
            //envio a SUNAT
            // $result=config_acceso_sunat::send($see, $invoice);
            //lectura CDR
            // $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

            $nota_debito=new Nota_Debito();
            $nota_debito->codigo_n_d=$nota_debito_numero;
            if($request->tipo_nota == "manual"){
                $nota_debito->facturacion_m_id=$factura->id;
            }else{
                $nota_debito->facturacion_id=$factura->id;
            }
            $nota_debito->tipo=$request->tipo;
            $nota_debito->motivo=$request->motivo;
            $nota_debito->n_electronica=0;
            $nota_debito->estado=0;
            $nota_debito->fecha_emision=Carbon::now();
            $nota_debito->almacen_id=$factura->almacen_id;

            $nota_debito->op_gravada=$gravada;
            $nota_debito->op_inafecta=$inafecta;
            $nota_debito->op_exonerada=$exonerada;
            $nota_debito->save();

            $codigo=$factura->codigo_fac;
            $contar=0;
            $contador=count($factura_registro);
            // return $contador;
            for($p=0;$p<$contador;$p++){
                $string=(string)$p;
                $nombre="input_disabled_".$string;
                $nombre_precio="input_disabled_precio_".$string;
                if($request->$nombre_precio==NULL){
                }else{
                    $nota_debitos_r=new Nota_Debito_registro();
                    $nota_debitos_r->nota_debito_id=$nota_debito->id;
                    //condicional para diferenciar productos y servicios en facturacion registro
                    if(isset($factura_registro[$p]->producto_id)){
                        $nota_debitos_r->producto_id=$factura_registro[$p]->producto_id;
                    }else{
                        $nota_debitos_r->servicio_id=$factura_registro[$p]->servicio_id;
                    }
                    $nota_debitos_r->precio=$request->$nombre_precio;
                    $nota_debitos_r->cantidad=$factura_registro[$p]->cantidad;
                    $nota_debitos_r->save();
                    $contar++;
                }
            }

            $contador=$contar;
        // codigo en almacen
        $nd_primera=Codigo_guia_almacen::where('id', $sucursal->id)->first();
        if(is_numeric($nd_primera->cod_nota_debito)){
            $nd_primera->cod_nota_debito='NN';
            $nd_primera->save();
        }

        $factura->nota_debito=1;
        $factura->save();

        return redirect()->route('nota-debito.show',$nota_debito->id);
    }
    public function store_boleta(Request $request, $id){
        // return $request;
        //contador nota de debitos
        $notas_debitos_count=Nota_Debito_registro::count();
        $notas_debitos_count++;
        if($request->tipo_nota == "normal"){
            $boleta=Boleta::where('id',$id)->first();
            $boleta_registro=Boleta_registro::where('boleta_id',$id)->get();

        }else{
            $boleta=Boleta_m::where('id',$id)->first();
            $boleta_registro=Boleta_registros_m::where('boleta_m_id',$id)->get();

        }

        //configuracion
        // $see=config_acceso_sunat::facturacion_electronica();

        $gravada=0;
        $exonerada=0;
        $inafecta=0;

        $gravada_s=0;
        $exonerada_s=0;
        $inafecta_s=0;
        // code nota_d
        // obtencion de la sucursal
        // return $boleta;

        $almacen=$boleta->almacen_id;
        //obtencion del almacen
        $almacen_id =Almacen::where('id', $almacen)->first();
        $sucursal = Codigo_guia_almacen::where('almacen_id',$almacen_id->id)->first();
        $nota_cod_n_debito=$sucursal->cod_nota_debito;
        if (is_numeric($nota_cod_n_debito)) {
            // exprecion del numero de la nota de debito
            $nota_cod_n_debito++;
            $sucursal_nr = str_pad($sucursal->serie_nota_debito, 2, "0", STR_PAD_LEFT);
            $nota_debito_nr=str_pad($nota_cod_n_debito, 8, "0", STR_PAD_LEFT);
        }else{
                // exprecion del numero de Nota de DEBITO
                // GENERACION DE NUMERO DE Nota de DEBITO
                $ultima_nota_d=Nota_Debito::where('almacen_id',$almacen_id->id)->latest()->first();
                $nota_debito_num=$ultima_nota_d->codigo_n_d;
                $nota_debito_num_string_porcion= explode("-", $nota_debito_num);
                $nota_debito_num_string=$nota_debito_num_string_porcion[1];
                $nota_debito_num=(int)$nota_debito_num_string;

                $almacen_codigo = Codigo_guia_almacen::orderBy('serie_nota_debito','DESC')->latest()->first();
                if($nota_debito_num == 99999999){
                    $ultima_nota_d = $almacen_codigo->serie_nota_debito+1;
                    $almacen_save_last = Codigo_guia_almacen::find($sucursal->id);
                    $almacen_save_last->serie_nota_debito = $almacen_codigo->serie_nota_debito+1;
                    $almacen_save_last->save();
                    $nota_debito_num = 00000000;
                }else{
                    $ultima_nota_d = $sucursal->serie_nota_debito;
                }
                $nota_debito_num++;
                $sucursal_nr = str_pad($ultima_nota_d, 2, "0", STR_PAD_LEFT);
                $nota_debito_nr=str_pad($nota_debito_num, 8, "0", STR_PAD_LEFT);
        }
        $nota_debito_numero="BB".$sucursal_nr."-".$nota_debito_nr;

        $contadores=count($boleta_registro);
        for($a=0;$a<$contadores;$a++){
            $string=(string)$a;
            $nombre="input_disabled_".$string;
            $nombre_precio="input_disabled_precio_".$string;
            if($request->$nombre_precio==NULL){
            }else{
                if(isset($boleta_registro[$a]->producto_id)){
                    if(strpos($boleta_registro[$a]->producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                        $gravada += round($request->$nombre_precio*$boleta_registro[$a]->cantidad,2);
                    }
                    if(strpos($boleta_registro[$a]->producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                        $exonerada += round($request->$nombre_precio*$boleta_registro[$a]->cantidad,2);
                    }
                    if(strpos($boleta_registro[$a]->producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                        $inafecta += round($request->$nombre_precio*$boleta_registro[$a]->cantidad,2);
                    }
                }else{
                    if(strpos($boleta_registro[$a]->servicio->tipo_afec_i_producto->informacion,'Gravado') !== false){
                        $gravada += round($request->$nombre_precio*$boleta_registro[$a]->cantidad,2);
                    }
                    if(strpos($boleta_registro[$a]->servicio->tipo_afec_i_servicio->informacion,'Exonerado') !== false){
                        $exonerada += round($request->$nombre_precio*$boleta_registro[$a]->cantidad,2);
                    }
                    if(strpos($boleta_registro[$a]->servicio->tipo_afec_i_servicio->informacion,'Inafecto') !== false){
                        $inafecta += round($request->$nombre_precio*$boleta_registro[$a]->cantidad,2);
                    }
                }
            }
        }
        // return $boleta_registro;
        $nota_debito=new Nota_Debito();
        $nota_debito->codigo_n_d=$nota_debito_numero;
        if($request->tipo_nota == "manual"){
            $nota_debito->boleta_m_id=$boleta->id;
        }else{
            $nota_debito->boleta_id=$boleta->id;
        }
        $nota_debito->tipo=$request->tipo;
        $nota_debito->almacen_id=$boleta->almacen_id;
        $nota_debito->motivo=$request->motivo;
        $nota_debito->op_gravada=$gravada;
        $nota_debito->op_inafecta=$inafecta;
        $nota_debito->op_exonerada=$exonerada;
        $nota_debito->save();

        $codigo=$boleta->codigo_boleta;

        $contar=0;
        $contador=count($boleta_registro);
        for($p=0;$p<$contador;$p++){
            $string=(string)$p;
            $nombre="input_disabled_".$string;
            $nombre_precio="input_disabled_precio_".$string;
            if($request->$nombre_precio==NULL){
            }else{
                $nota_debitos_r=new Nota_Debito_registro();
                $nota_debitos_r->nota_debito_id=$nota_debito->id;
                if($boleta_registro[$p]->producto_id){
                    $nota_debitos_r->producto_id=$boleta_registro[$p]->producto_id;
                }else{
                    $nota_debitos_r->servicio_id=$boleta_registro[$p]->servicio_id;
                }
                $nota_debitos_r->precio=$request->$nombre_precio;
                $nota_debitos_r->cantidad=$boleta_registro[$p]->cantidad;
                $nota_debitos_r->save();
                $contar++;
            }
        }
        // modificacion para que se cierre el codigo en almacen
        $nd_primera=Codigo_guia_almacen::where('id', $sucursal->id)->first();
        if(is_numeric($nd_primera->cod_nota_debito)){
            $nd_primera->cod_nota_debito='NN';
            $nd_primera->save();
        }

        $boleta->nota_debito=1;
        $boleta->save();

        return redirect()->route('nota-debito.show',$nota_debito->id);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notas_debito=Nota_Debito::where('id',$id)->first();
        $notas_debito_registros=Nota_Debito_registro::where('nota_debito_id',$id)->get();

        if($notas_debito->facturacion_id != NULL){
            $document = Facturacion::where('id',$notas_debito->facturacion_id)->first();
            $doc_reg = Facturacion_registro::where('facturacion_id',$document->id)->get();
            // $estado=0;
        }elseif($notas_debito->boleta_id != NULL){
            $document=Boleta::where('id',$notas_debito->boleta_id)->first();
            $doc_reg=Boleta_registro::where('boleta_id',$document->id)->get();
            // $estado=1;
        }elseif($notas_debito->boleta_m_id != NULL){
            $document=Boleta_m::where('id',$notas_debito->boleta_m_id)->first();
            $doc_reg=Boleta_registros_m::where('boleta_m_id',$document->id)->get();
            // $estado=3;
        }else{
            $document = Facturacion_m::where('id',$notas_debito->facturacion_m_id)->first();
            $doc_reg = Facturacion_registro_m::where('facturacion_m_id',$document->id)->get();
            // $estado=2;
        }

        $empresa=Empresa::first();
        $igv=Igv::first();
        // if($notas_debito->boleta_id==NULL){
        //     $estado=0;
        // }else{
        //     $estado=1;
        // }
            // return $document;
        return view('transaccion.venta.nota_debito.show',compact('notas_debito','notas_debito_registros','empresa','igv','document','doc_reg'));
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

    public function print($id){
        $nota_debito = Nota_Debito::find($id);
        $nota_debito_reg = Nota_Debito_registro::where('nota_debito_id', $nota_debito->id)->get();
        $empresa = Empresa::first();
        //* FACTURA 0 - BOLETA  1 - FAC MANUAL 2
        if($nota_debito->facturacion_id != NULL){
            $document = Facturacion::where('id',$nota_debito->facturacion_id)->first();
            $doc_reg = Facturacion_registro::where('facturacion_id',$document->id)->get();
            $estado=0;
        }elseif($nota_debito->boleta_id != NULL){
            $document=Boleta::where('id',$nota_debito->boleta_id)->first();
            $doc_reg=Boleta_registro::where('boleta_id',$document->id)->get();
            $estado=1;
        }elseif($nota_debito->boleta_m_id != NULL){
            $document=Boleta_m::where('id',$nota_debito->boleta_m_id)->first();
            $doc_reg=Boleta_registros_m::where('boleta_m_id',$document->id)->get();
            $estado=3;
        }else{
            $document = Facturacion_m::where('id',$nota_debito->facturacion_m_id)->first();
            $doc_reg = Facturacion_registro_m::where('facturacion_m_id',$document->id)->get();
            $estado=2;
        }
        $igv=Igv::first();
        $textoQR = $this->generarTextoQRNotaDebito($nota_debito, $document, $empresa, $igv, $estado);
        $qrCode = $this->generarImagenQR($textoQR);

        return view('transaccion.venta.nota_debito.print',compact('nota_debito','nota_debito_reg','empresa','estado','igv','document','doc_reg','textoQR','qrCode'));
    }

    public function pdf(Request $request,$id){
        $name = $request->get('name');
        $nota_debito = Nota_Debito::find($id);
        $nota_debito_reg = Nota_Debito_registro::where('nota_debito_id', $nota_debito->id)->get();
        $empresa = Empresa::first();
        //* FACTURA 0 - BOLETA  1 - FAC MANUAL 2
        if($nota_debito->facturacion_id != NULL){
            $document = Facturacion::where('id',$nota_debito->facturacion_id)->first();
            $doc_reg = Facturacion_registro::where('facturacion_id',$document->id)->get();
            $estado=0;
            $archivo  = $document->codigo_fac;
        }elseif($nota_debito->boleta_id != NULL){
            $document=Boleta::where('id',$nota_debito->boleta_id)->first();
            $doc_reg=Boleta_registro::where('boleta_id',$document->id)->get();
            $estado=1;
            $archivo  = $document->codigo_boleta;
        }elseif($nota_debito->boleta_m_id != NULL){
            $document=Boleta_m::where('id',$nota_debito->boleta_m_id)->first();
            $doc_reg=Boleta_registros_m::where('boleta_m_id',$document->id)->get();
            $estado=3;
            $archivo  = $document->codigo_boleta;
        }else{
            $document = Facturacion_m::where('id',$nota_debito->facturacion_m_id)->first();
            $doc_reg = Facturacion_registro_m::where('facturacion_m_id',$document->id)->get();
            $estado=2;
            $archivo  = $document->codigo_fac;
        }
        $u=1;
        $igv=Igv::first();
        $textoQR = $this->generarTextoQRNotaDebito($nota_debito, $document, $empresa, $igv, $estado);
        $qrCode = $this->generarImagenQR($textoQR);
        $pdf=PDF::loadView('transaccion.venta.nota_debito.pdf',compact('nota_debito','nota_debito_reg','empresa','estado','igv','document','doc_reg','u','textoQR','qrCode'));
        return $pdf->download('ND - '.$archivo.'.pdf');
    }

public function exportNotasDebito(Request $request)
{
    if (ob_get_contents()) {
            ob_end_clean();
        }
    if ($request->has('nota_ids') && !empty($request->input('nota_ids'))) {
        $notaIds = $request->input('nota_ids');

        $notas = Nota_Debito::with([
            'nota_i_facturacion',
            'nota_i_boleta',
            'nota_i_fac_manual',
            'nota_i_boleta_manual',
            'nota_i_almacen'
        ])
        ->whereIn('id', $notaIds)
        ->orderBy('created_at', 'desc')
        ->get();
    } else {
        $daterange = $request->get('daterange', date('01/m/Y') . ' - ' . date('t/m/Y'));
        $filter = $request->get('value');
        $tipo = $request->get('tipo_coti');

        $starDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $daterange)[1])->endOfDay();

        $query = Nota_Debito::with(['nota_i_facturacion', 'nota_i_boleta', 'nota_i_fac_manual', 'nota_i_boleta_manual', 'nota_i_almacen'])
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

        $notas = $query->get();
    }

    $igvConfig = Igv::first();


    $headers = [
        'Código Nota Débito',
        'Facturación',
        'Boleta',
        'Facturación Manual',
        'Boleta Manual',
        'Fecha Emisión',
        'Estado',
        'SUNAT',
        'Tipo',
        'Almacén',
        'Operación Gravada',
        'Operación Inafecta',
        'Operación Exonerada',
        'Operación Gratuita',
        'Motivo',
        'IGV',
        'Subtotal',
        'Importe Total',
    ];

    $rows = [$headers];

    foreach ($notas as $nota) {
        $Factura = optional($nota->nota_i_facturacion)->codigo_fac ?? '';
        $Boleta = optional($nota->nota_i_boleta)->codigo_boleta ?? '';
        $FacturaManual = optional($nota->nota_i_fac_manual)->codigo_fac ?? '';
        $BoletaManual = optional($nota->nota_i_boleta_manual)->codigo_boleta ?? '';
        $almacen = optional($nota->nota_i_almacen)->nombre ?? '';

        $subtotal = $nota->op_gravada + $nota->op_inafecta + $nota->op_exonerada;
        $igvCalculado = round($nota->op_gravada * $igvConfig->igv_total / 100, 2);
        $total = round($subtotal + $igvCalculado, 2);

        $estado = $nota->estado == 1 ? 'Activo' : 'Inactivo';
        $sunat = $nota->n_electronica == 1 ? 'Emitida' : 'Pendiente';

        $rows[] = [
            $nota->codigo_n_d,
            $Factura,
            $FacturaManual,
            $Boleta,
            $BoletaManual,
            $nota->fecha_emision,
            $estado,
            $sunat,
            $nota->tipo,
            $almacen,
            $nota->op_gravada,
            $nota->op_inafecta,
            $nota->op_exonerada,
            $nota->op_gratuita,
            $nota->motivo,
            $igvCalculado,
            $subtotal,
            $total,
        ];
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

    return Excel::download($export, 'notas_debito.xlsx');
}

public function printMultiple(Request $request)
{
    try {
        $notaIds = $request->input('nota_ids', []);

        // Si no se reciben por POST, intentar por GET
        if (empty($notaIds)) {
            $notaIds = $request->query('nota_ids', []);
        }

        // Asegurarse de que es un array
        if (!is_array($notaIds)) {
            $notaIds = [$notaIds];
        }

        // Filtrar valores vacíos o nulos
        $notaIds = array_filter($notaIds, function($id) {
            return !empty($id) && $id !== 'on';
        });

        if (empty($notaIds)) {
            return back()->withErrors(['No se seleccionaron notas de débito para imprimir.']);
        }

        $notas = Nota_Debito::whereIn('id', $notaIds)->get();

        if ($notas->count() !== count($notaIds)) {
            return back()->withErrors(['Algunas notas de débito seleccionadas no existen.']);
        }

        // Recopilar datos para múltiples notas de débito
        $notasData = [];
        $igvModel = Igv::first();
        $empresa = Empresa::first();

        if (!$igvModel) {
            return back()->withErrors(['Configuración de IGV no encontrada.']);
        }
        if (!$empresa) {
            return back()->withErrors(['Configuración de empresa no encontrada.']);
        }

        foreach ($notas as $nota) {
            $nota_debito_reg = Nota_Debito_registro::where('nota_debito_id', $nota->id)->get();

            // Determinar el documento original y sus registros
            $document = null;
            $doc_reg = [];
            $estado = 0;

            if ($nota->facturacion_id != null) {
                $document = Facturacion::with('cliente', 'forma_pago', 'moneda')->find($nota->facturacion_id);
                $doc_reg = Facturacion_registro::where('facturacion_id', $document->id)->get();
                $estado = 0;
            } elseif ($nota->boleta_id != null) {
                $document = Boleta::with('cliente', 'forma_pago', 'moneda')->find($nota->boleta_id);
                $doc_reg = Boleta_registro::where('boleta_id', $document->id)->get();
                $estado = 1;
            } elseif ($nota->boleta_m_id != null) {
                $document = Boleta_m::with('cliente', 'forma_pago', 'moneda')->find($nota->boleta_m_id);
                $doc_reg = Boleta_registros_m::where('boleta_m_id', $document->id)->get();
                $estado = 3;
            } else {
                $document = Facturacion_m::with('cliente', 'forma_pago', 'moneda')->find($nota->facturacion_m_id);
                $doc_reg = Facturacion_registro_m::where('facturacion_m_id', $document->id)->get();
                $estado = 2;
            }

            // Cálculos completos
            $sub_total = ($nota->op_gravada ?? 0) + ($nota->op_inafecta ?? 0) + ($nota->op_exonerada ?? 0);
            $sub_total_gravado = $nota->op_gravada ?? 0;
            $igv_p = ($sub_total_gravado * $igvModel->igv_total) / 100;
            $end = $sub_total + $igv_p;
            $end2 = number_format($end, 2);

            $textoQR = $this->generarTextoQRNotaDebito($nota, $document, $empresa, $igvModel, $estado);
            $qrCode = $this->generarImagenQR($textoQR);

            $notasData[] = [
                'nota_debito' => $nota,
                'nota_debito_reg' => $nota_debito_reg,
                'document' => $document,
                'doc_reg' => $doc_reg,
                'estado' => $estado,
                'sub_total' => $sub_total,
                'sub_total_gravado' => $sub_total_gravado,
                'igv_p' => $igv_p,
                'end' => $end,
                'end2' => $end2,
                'textoQR' => $textoQR,
                'qrCode' => $qrCode,
            ];
        }

        return view('transaccion.comprobantes.nota_debito.print_multiple', compact(
            'notasData',
            'empresa',
            'igvModel'
        ));

    } catch (\Exception $e) {
        return back()->withErrors(['Error al procesar la impresión múltiple: ' . $e->getMessage()]);
    }
}
public function downloadMultiplePDFs(Request $request)
{
    try {
        $notaIds = $request->input('nota_ids', []);

        if (empty($notaIds) || !is_array($notaIds)) {
            return back()->with('error', 'No se seleccionaron notas de débito para descargar.');
        }

        if (count($notaIds) === 1) {
            return $this->downloadSinglePDF($notaIds[0]);
        }

        $notas = Nota_Debito::whereIn('id', $notaIds)->get();

        if ($notas->count() !== count($notaIds)) {
            return back()->with('error', 'Algunas notas de débito seleccionadas no existen.');
        }

        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $zipName = 'Notas_Debito_' . date('Y-m-d_H-i-s') . '.zip';
        $tempZip = $tempDir . DIRECTORY_SEPARATOR . $zipName;

        if (file_exists($tempZip)) {
            @unlink($tempZip);
        }

        $zip = new \ZipArchive();

        if ($zip->open($tempZip, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Error al crear el archivo ZIP');
        }

        $igv = Igv::first();
        $empresa = Empresa::first();

        foreach ($notas as $nota_debito) {
            try {
                $nota_debito_reg = Nota_Debito_registro::where('nota_debito_id', $nota_debito->id)->get();

                if ($nota_debito->facturacion_id != null) {
                    $document = Facturacion::find($nota_debito->facturacion_id);
                    $doc_reg = Facturacion_registro::where('facturacion_id', $document->id)->get();
                    $estado = 0;
                } elseif ($nota_debito->boleta_id != null) {
                    $document = Boleta::find($nota_debito->boleta_id);
                    $doc_reg = Boleta_registro::where('boleta_id', $document->id)->get();
                    $estado = 1;
                } elseif ($nota_debito->boleta_m_id != null) {
                    $document = Boleta_m::find($nota_debito->boleta_m_id);
                    $doc_reg = Boleta_registros_m::where('boleta_m_id', $document->id)->get();
                    $estado = 3;
                } else {
                    $document = Facturacion_m::find($nota_debito->facturacion_m_id);
                    $doc_reg = Facturacion_registro_m::where('facturacion_m_id', $document->id)->get();
                    $estado = 2;
                }

                $u = 1;
                $textoQR = $this->generarTextoQRNotaDebito($nota_debito, $document, $empresa, $igv, $estado);
                $qrCode = $this->generarImagenQR($textoQR);

                $pdf = PDF::loadView('transaccion.venta.nota_debito.pdf', compact(
                    'nota_debito',
                    'nota_debito_reg',
                    'empresa',
                    'estado',
                    'igv',
                    'document',
                    'doc_reg',
                    'u',
                    'textoQR',
                    'qrCode'
                ));

                $pdfContent = $pdf->output();

                $codigoNotaDebito = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nota_debito->codigo_n_d);
                $fileName = 'ND_' . $codigoNotaDebito . '.pdf';
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
        return back()->with('error', 'Error al descargar notas de débito: ' . $e->getMessage());
    }
}

private function downloadSinglePDF($id)
{
    try {
        $nota_debito = Nota_Debito::find($id);
        if (!$nota_debito) {
            return back()->with('error', 'Nota de débito no encontrada.');
        }

        $nota_debito_reg = Nota_Debito_registro::where('nota_debito_id', $nota_debito->id)->get();
        $igv = Igv::first();
        $empresa = Empresa::first();

        // Determinar el documento original
        if ($nota_debito->facturacion_id != null) {
            $document = Facturacion::find($nota_debito->facturacion_id);
            $doc_reg = Facturacion_registro::where('facturacion_id', $document->id)->get();
            $estado = 0;
            $archivo = $document->codigo_fac;
        } elseif ($nota_debito->boleta_id != null) {
            $document = Boleta::find($nota_debito->boleta_id);
            $doc_reg = Boleta_registro::where('boleta_id', $document->id)->get();
            $estado = 1;
            $archivo = $document->codigo_boleta;
        } elseif ($nota_debito->boleta_m_id != null) {
            $document = Boleta_m::find($nota_debito->boleta_m_id);
            $doc_reg = Boleta_registros_m::where('boleta_m_id', $document->id)->get();
            $estado = 3;
            $archivo = $document->codigo_boleta;
        } else {
            $document = Facturacion_m::find($nota_debito->facturacion_m_id);
            $doc_reg = Facturacion_registro_m::where('facturacion_m_id', $document->id)->get();
            $estado = 2;
            $archivo = $document->codigo_fac;
        }

        $u = 1;
        $textoQR = $this->generarTextoQRNotaDebito($nota_debito, $document, $empresa, $igv, $estado);
        $qrCode = $this->generarImagenQR($textoQR);

        $pdf = PDF::loadView('transaccion.venta.nota_debito.pdf', compact(
            'nota_debito',
            'nota_debito_reg',
            'empresa',
            'estado',
            'igv',
            'document',
            'doc_reg',
            'u',
            'textoQR',
            'qrCode'
        ));

        return $pdf->download('ND_' . $archivo . '.pdf');

    } catch (\Exception $e) {
        return back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
    }
}

    /**
     * Genera el texto del código QR según los requisitos de SUNAT para notas de débito
     *
     * @param \App\Nota_Debito $nota
     * @param mixed $documentoOriginal (Facturacion, Boleta, etc.)
     * @param \App\Empresa $empresa
     * @param \App\Igv $igv
     * @param int $estado (0=Factura, 1=Boleta, 2=FacturaM, 3=BoletaM)
     * @return string
     */
    private function generarTextoQRNotaDebito($nota, $documentoOriginal, $empresa, $igv, $estado)
    {
        try {
            $ruc = $empresa->ruc ?? '';

            $tipoDocumento = '08';

            $codNota = $nota->codigo ?? '';
            $partes = explode('-', $codNota);
            $serie = $partes[0] ?? '';
            $numero = $partes[1] ?? '';

            $sub_total_gravado = $nota->op_gravada ?? 0;
            $igv_monto = round($sub_total_gravado * ($igv->igv_total / 100), 2);

            $sub_total = ($nota->op_gravada ?? 0) + ($nota->op_inafecta ?? 0) + ($nota->op_exonerada ?? 0);
            $montoTotal = number_format(round($sub_total + $igv_monto, 2), 2, '.', '');
            $igv_formato = number_format($igv_monto, 2, '.', '');

            $fechaEmision = $nota->fecha_emision ?? date('Y-m-d');

            $tipoDocCliente = '';
            $numDocCliente = '';

            if ($documentoOriginal && isset($documentoOriginal->cliente)) {
                $numDocCliente = $documentoOriginal->cliente->numero_documento ?? '';

                if ($estado == 0 || $estado == 2) {
                    $tipoDocCliente = '6';
                } else {
                    if (isset($documentoOriginal->cliente->tipo_documento)) {
                        $tipoDocCliente = $documentoOriginal->cliente->tipo_documento;
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
            }

            $valorResumen = $nota->hash_cpe ?? '';

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
        $notaDebitoIds = $request->nota_ids;

        $mensaje = "";

        foreach ($notaDebitoIds as $id) {
            $notaDebito = Nota_Debito::find($id);
            if ($notaDebito) {
                $codigo = substr(md5($id . env('APP_KEY') . 'nota_debito'), 0, 22);

                $pdfUrl = url("nota_debito/share/{$codigo}");

                $mensaje .= "{$pdfUrl}\n";
            }
        }

        $mensajeCodificado = urlencode($mensaje);
        $whatsappUrl = "https://wa.me/{$numero}?text={$mensajeCodificado}";

        return redirect()->away($whatsappUrl);
    }

    public function descargarPorCodigo($codigo)
    {
        $notas = Nota_Debito::all();

        foreach ($notas as $not) {
            if (substr(md5($not->id . env('APP_KEY') . 'nota_debito'), 0, 22) === $codigo) {
                return redirect()->route('nota_debito.pdf', $not->id);
            }
        }

        abort(404);
    }
}
