<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Boleta;
use App\Boleta_registro;
use App\Boleta_m;
use App\Boleta_registros_m;
use App\Codigo_guia_almacen;
use App\Config_fe;
use App\Empresa;
use App\Facturacion;
use App\Facturacion_m;
use App\Facturacion_registro;
use App\Facturacion_registro_m;
use App\Guia_remision;
use App\g_remision_registro;
use App\GuiaRemisionManual;
use App\GuiaRemisionMRegistros;
use App\Nota_Credito;
use App\Nota_Credito_registro;
use App\Nota_Debito;
use App\Nota_Debito_registro;
use App\config_acceso_sunat;
use App\config_acc_guia;
use App\detracciones;
use App\FacturacionElectronica;
use App\Igv;
use App\Moneda;
use Carbon\Carbon;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use Illuminate\Database\Eloquent\Model;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Sale\Cuota;
use Greenter\Model\Sale\FormaPagos\FormaPagoCredito;
use Greenter\Model\Sale\Document;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Despatch\Shipment;
use Greenter\Model\Despatch\Transportist;
// use Greenter\Model\Response\CdrResponse;
// use Greenter\Model\Response\SummaryResult;
use Greenter\Model\Sale\Note;

use Greenter\Ws\Services\SunatEndpoints;
use Greenter\See;

use Greenter\XMLSecLibs\Certificate\X509Certificate;
use Greenter\XMLSecLibs\Certificate\X509ContentType;

use Greenter\Api;
use Greenter\Model\Retention\Retention;
use Illuminate\Support\Carbon as SupportCarbon;
use PhpParser\Node\Stmt\Return_;

//* IMPORTANTE: TOMAR ESTAS FUNCIONES CON MUCHA PRECAUCION, PUES SON LAS QUE SE ENCARGAN DE ENVIAR A SUNAT, REZAR PORQUE SALGA BIEN TODO
//* FALTA DOCUMENTACION DE LAS FUNCIONES, NI DIOS SABE COMO FUNCIONAN

class FacturacionElectronicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $empresa=Empresa::first();
        $fecha_hoy = Carbon::now();

        $facturacion=Facturacion::where('f_electronica',0)->where('estado', 1)->get();
        foreach ($facturacion as $factura) {
            $factura->diff_day =  intval(date_diff($factura->created_at, $fecha_hoy)->format('%R%a'));
        }
        $resumen_mes = FacturacionElectronica::resumen_facturas();
    return view('facturacion_electronica.factura.index',compact('facturacion','empresa','resumen_mes'));
    }

    public function facturas_enviadas(){

        $empresa=Empresa::first();
        $resumen_mes = FacturacionElectronica::resumen_facturas();
        return view('facturacion_electronica.factura.enviado',compact('empresa','resumen_mes'));
    }

    public function index_facturas_manual(){
        $empresa=Empresa::first();
        $fecha_hoy = Carbon::now();

        $facturas_manual=Facturacion_m::where('f_electronica', 0)->where('estado', 1)->get();
        foreach ($facturas_manual as $factura) {
            $factura->diff_day =  intval(date_diff($factura->created_at, $fecha_hoy)->format('%R%a'));
        }
        $resumen_mes = FacturacionElectronica::resumen_facturas();
        return view('facturacion_electronica.factura.index_manual',compact('facturas_manual','empresa','resumen_mes'));
    }

    public function facturas_manual_enviadas(){
        $empresa=Empresa::first();
        $resumen_mes = FacturacionElectronica::resumen_facturas();
        return view('facturacion_electronica.factura.enviado_manual', compact('empresa','resumen_mes'));
    }

    public function facturas_detracciones(){
        $empresa=Empresa::first();
        $detraccion_facturas = Detracciones::where('factura_id', '!=', null)->orWhere('factura_m_id',  '!=', null)->get();
        $resumen_mes = FacturacionElectronica::resumen_facturas();
        return view('facturacion_electronica.factura.detracciones', compact('empresa','detraccion_facturas','resumen_mes'));
    }

    public function index_boleta(){

        $empresa=Empresa::first();
        $fecha_hoy = Carbon::now();

        $boletas=Boleta::where('b_electronica',0)->get();
        foreach ($boletas as $boleta) {
            $boleta->diff_day =  intval(date_diff($boleta->created_at, $fecha_hoy)->format('%R%a'));
        }
        $resumen_mes = FacturacionElectronica::resumen_boletas();
        return view('facturacion_electronica.boleta.index',compact('boletas','empresa','resumen_mes'));
    }

    public function boletas_enviadas(){
        $empresa=Empresa::first();
        $resumen_mes = FacturacionElectronica::resumen_boletas();
        return view('facturacion_electronica.boleta.enviado',compact('empresa','resumen_mes'));
    }

    public function index_boleta_manual(){
        $empresa=Empresa::first();
        $fecha_hoy = Carbon::now();

        $boletas_m=Boleta_m::where('b_electronica',0)->get();
        foreach ($boletas_m as $boleta) {
            $boleta->diff_day =  intval(date_diff($boleta->created_at, $fecha_hoy)->format('%R%a'));
        }
        $resumen_mes = FacturacionElectronica::resumen_boletas();
        return view('facturacion_electronica.boleta.index_manual',compact('boletas_m','empresa','resumen_mes'));
    }

    public function boletas_enviadas_m(){
        $empresa=Empresa::first();
        $resumen_mes = FacturacionElectronica::resumen_boletas();
        return view('facturacion_electronica.boleta.enviado_manual',compact('empresa','resumen_mes'));
    }


    public function index_guia_remision(){

        $empresa=Empresa::first();
        $fecha_hoy = Carbon::now();

        $guia_remisiones=Guia_remision::where('estado', 1)->where('g_electronica',0)->where('estado_anulado',0)->get();
        foreach ($guia_remisiones as $remision) {
            $remision->diff_day =  intval(date_diff($remision->created_at, $fecha_hoy)->format('%R%a'));
        }
        $guia_remision_ticket = Guia_remision::where('estado', 1)->where('ticket_guia_remision_sunat','!=', null)->first();
        if(isset($guia_remision_ticket)){
            $msg_ticket = '1';
        }else{
            $msg_ticket = '0';
        }
        $resumen_mes = FacturacionElectronica::resumen_guias();
        foreach ($guia_remisiones as $remision) {
            $remision->diff_day =  intval(date_diff($remision->created_at, $fecha_hoy)->format('%R%a'));
            $remision->fecha_emision = Carbon::createFromFormat('d/m/Y', $remision->fecha_emision)->startOfDay();
            $remision->fecha_entrega = Carbon::createFromFormat('Y-m-d', $remision->fecha_entrega)->format('d-m-Y');

        }
        return view('facturacion_electronica.guia_remision.index',compact('guia_remisiones','resumen_mes','msg_ticket'));
    }

    public function remision_enviadas(){
        $empresa=Empresa::first();
        $guia_remision_ticket = Guia_remision::where('ticket_guia_remision_sunat','!=', null)->first();
        if(isset($guia_remision_ticket)){
            $msg_ticket = '1';
        }else{
            $msg_ticket = '0';
        }
        $resumen_mes = FacturacionElectronica::resumen_guias();
        return view('facturacion_electronica.guia_remision.enviado',compact('empresa','resumen_mes','msg_ticket'));
    }

    public function index_guia_remision_manual(){
        $empresa=Empresa::first();
        $fecha_hoy = Carbon::now();

        $guia_remisiones=GuiaRemisionManual::where('estado', 1)->where('g_electronica',0)->where('estado_anulado',0)->get();
        foreach ($guia_remisiones as $remision) {
            $remision->diff_day =  intval(date_diff($remision->created_at, $fecha_hoy)->format('%R%a'));
        }
        $guia_remision_ticket = GuiaRemisionManual::where('estado', 1)->where('ticket_guia_remi_m_sunat','!=', null)->first();
        // return $guia_remisiones;
        if(isset($guia_remision_ticket)){
            $msg_ticket = '1';
        }else{
            $msg_ticket = '0';
        }
        $resumen_mes = FacturacionElectronica::resumen_guias();
        // return $guia_remisiones;
        foreach ($guia_remisiones as $remision) {
            $remision->diff_day =  intval(date_diff($remision->created_at, $fecha_hoy)->format('%R%a'));
            $remision->fecha_emision = GuiaRemisionManual::normalizar_fechas($remision->fecha_emision);
            $remision->fecha_entrega = GuiaRemisionManual::normalizar_fechas($remision->fecha_entrega);

        }
        return view('facturacion_electronica.guia_remision.index_manual',compact('guia_remisiones','resumen_mes','msg_ticket'));
    }

    public function remision_m_envidas(){
        $empresa=Empresa::first();
        $guia_remision_ticket = Guia_remision::where('ticket_guia_remision_sunat','!=', null)->first();
        if(isset($guia_remision_ticket)){
            $msg_ticket = '1';
        }else{
            $msg_ticket = '0';
        }
        $resumen_mes = FacturacionElectronica::resumen_guias();
        return view('facturacion_electronica.guia_remision.enviado_manual',compact('empresa','resumen_mes','msg_ticket'));
    }

    public function index_nota_credito(){
        $empresa=Empresa::first();
        $fecha_hoy = Carbon::now();

        $n_creditos=Nota_Credito::where('n_electronica',0)->get();
        foreach ($n_creditos as $credito) {
            $credito->diff_day =  intval(date_diff($credito->created_at, $fecha_hoy)->format('%R%a'));
            // $credito->fecha_emision = Carbon::createFromFormat('Y-m-d H:i:s', $credito->fecha_emision)->format('d-m-Y');
            $credito->fecha_emision = Carbon::parse(str_replace('/', '-', $credito->fecha_emision))->format('d-m-Y');
        }
        $resumen_mes = FacturacionElectronica::resumen_notas_electronicas();
        return view('facturacion_electronica.nota_credito.index',compact('n_creditos','empresa','resumen_mes'));
    }

    public function nota_credito_env(){
        $empresa=Empresa::first();
        $resumen_mes = FacturacionElectronica::resumen_notas_electronicas();
        return view('facturacion_electronica.nota_credito.enviado',compact('empresa','resumen_mes'));
    }

    public function index_nota_debito(){
        $empresa=Empresa::first();
        $fecha_hoy = Carbon::now();

        $n_debitos=Nota_Debito::where('n_electronica',0)->get();
        foreach ($n_debitos as $debito) {
            $debito->diff_day =  intval(date_diff($debito->created_at, $fecha_hoy)->format('%R%a'));
            $debito->fecha_emision = Carbon::createFromFormat('Y-m-d H:i:s', $debito->fecha_emision)->format('d-m-Y');
        }
        $resumen_mes = FacturacionElectronica::resumen_notas_electronicas();
        return view('facturacion_electronica.nota-debito.index',compact('n_debitos','empresa','resumen_mes'));
    }

    public function nota_debito_env(){
        $empresa=Empresa::first();
        $resumen_mes = FacturacionElectronica::resumen_notas_electronicas();
        return view('facturacion_electronica.nota-debito.enviado',compact('empresa','resumen_mes'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function factura(Request $request)
    {
        //facturas a buscar
        $factura=Facturacion::where('f_electronica',0)->where('id',$request->factura_id)->first();
        $factura_registro=Facturacion_registro::where('facturacion_id',$request->factura_id)->get();

        if($factura->guia_remision=="0"){
            $guia=0;
        }else{
            $guia=1;
        }

        $facturacion_manual = 0;

        //configuracion de conexion
        $see=config_acceso_sunat::facturacion_electronica();

        // if($factura->tipo=="producto"){
            //factura
        $det = Detracciones::where('factura_id', $factura->id)->first();
        // return $det;
        //invoce - detraccion
        if($det !== null){
            // return "c";
            $invoice=Config_fe::factura_detraccion($factura, $factura_registro,$guia,$facturacion_manual);
        }else{
            // return "b";
            $invoice=Config_fe::factura($factura, $factura_registro,$guia,$facturacion_manual);
        }

        // }elseif($factura->tipo=="servicio"){
        //     //factura
        //     $invoice=Config_fe::factura_servicio($factura, $factura_registro,$guia);

        // }

        //envio a SUNAT
        $result=config_acceso_sunat::send($see, $invoice);
        //lectura CDR
        $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

        //cambio de factura electronica - en caso sea todo exitoso
        // $factura->f_electronica=1;
        // $factura->save();

        return redirect()->route('facturacion_electronica.index')->with('successMsg',$msg);
    }

    // * factura envio sunat
    public function fac_elec_all(Request $request){
        // return $request;
        $factura_codigo = $request->get('codigo_fac');
        $factura=Facturacion::where('f_electronica',0)->where('codigo_fac',$factura_codigo)->first();
        // return "suceess";
        $factura_registro=Facturacion_registro::where('facturacion_id',$factura->id)->get();
        if($factura->guia_remision=="0"){
            $guia=0;
        }else{
            $guia=1;
        }
        $facturacion_manual = 0;
        //configuracion de conexion
        $see= config_acceso_sunat::facturacion_electronica();

        $det = Detracciones::where('factura_id', $factura->id)->first();
        // return $det;
        //invoce - detraccion
        if($det !== null){
            // return "c";
            $invoice=Config_fe::factura_detraccion($factura, $factura_registro,$guia,$facturacion_manual);
        }else{
            // return "b";
            $invoice=Config_fe::factura($factura, $factura_registro,$guia,$facturacion_manual);
        }
        //envio a SUNAT
        $result = config_acceso_sunat::send($see, $invoice);
        // return dd($result);
        //lectura CDR


        $msg = config_acceso_sunat::lectura_cdr($result->getCdrResponse());
        // return  dd( $msg);
        // if(gettype($result) == "object"){
        //     $retorno = $msg;
        // }else{
        //     $retorno = $msg;
        // }
        //cambio de factura electronica - en caso sea todo exitoso
        $factura->f_electronica=1;
        $factura->save();
        //
        // $array = explode(" ",$msg);
        return $msg;

    }

    public function facturacion_m_e(Request $request){

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

        $det = Detracciones::where('factura_m_id', $factura->id)->first();
        //invoce - detraccion
        if($det !== null){
            // return "c";
            $invoice=Config_fe::factura_detraccion($factura, $factura_registro,$guia,$facturacion_manual);
        }else{
            // return "b";
            $invoice=Config_fe::factura($factura, $factura_registro,$guia,$facturacion_manual);
        }

        $result=config_acceso_sunat::send($see, $invoice);

        //lectura CDR
        $mensaje=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

        // $mensaje="La factura fue enviada exitosamente";

        //cambio de factura electronica - en caso sea todo exitoso
        $factura->f_electronica=1;
        // $factura->save();

        return redirect()->route('facturacion_electronica.index')->with('successMsg',$mensaje);

    }
    // * factura envio sunat
    public function fac_elec_man_all(Request $request){
        // return $request;
        $factura_codigo = $request->get('codigo_fac');
        // Obtención de facturación y facturacion registro
        $factura=Facturacion_m::where('codigo_fac', $factura_codigo)->first();
        $factura_registro=Facturacion_registro_m::where('facturacion_m_id',$factura->id)->get();

        if($factura->guia_remision=="0"){
            $guia=0;
        }else{
            $guia=1;
        }

        $facturacion_manual=1;

        foreach($factura_registro as $facturas_registros){
            $facturas_registros->precio_unitario_comi=$facturas_registros->precio;
        }
        //configuracion de conexion
        $see= config_acceso_sunat::facturacion_electronica();

        //invoce
        $det = Detracciones::where('factura_m_id', $factura->id)->first();

        if($det !== null){
            //invoce - detraccion
            $invoice=Config_fe::factura_detraccion($factura, $factura_registro,$guia,$facturacion_manual);
        }else{
            //invoce
            $invoice=Config_fe::factura($factura, $factura_registro,$guia,$facturacion_manual);
        }
        //envio a SUNAT
        $result = config_acceso_sunat::send($see, $invoice);

        //lectura CDR
        $msg = config_acceso_sunat::lectura_cdr($result->getCdrResponse());

        //cambio de factura electronica - en caso sea todo exitoso
        $factura->f_electronica=1;
        $factura->save();

        return $msg;

    }
    public function validacion_sunat(Request $request){
        //* SOLO FACTURA POR AHORA
        $tipo = $request->tipo;
        $msg_r = $request->msg;
        $codigo = $request->codigo_fac;
        // $factura = Facturacion::where('codigo_fac'.$request->codigo_fac)->first();
        //BUSCA EL CODIGO ERROR
        $explod = explode(" ",$msg_r);
        $n_error = substr($explod[2], 0, 4) ;
        $valor_pas = $explod[1];


        switch ($tipo) {
            case 'factura':
                $document = Facturacion::where('codigo_fac', $codigo)->first();
                break;
            case 'factura_manual':
                $document = Facturacion_m::where('codigo_fac', $codigo)->first();
                break;
        }


        if(strlen($valor_pas) == 12){ //* 12 = ACEPTADA --------- 13 = RECHAZADA
            $retorno =  "Aceptada por Sunat";
        }elseif (strpos($msg_r,'Codigo Error: ') !== false) {
            $document->f_electronica = 2; //ESTADO ANULADO
            $document->save();
            $retorno =  "Rechazado por Sunat";
        }elseif(strpos($msg_r,'OBSERVACIONES') !== false){ //OBSERVACIONES PERO ENVIADOS
            $retorno =  "Aceptada con Observaciones";
        }elseif(strpos($msg_r,'HTTP') !== false){
            $retorno =  "Error en Servidores de Sunat, volver a intentar en 10 minutos";
        }else{
            $retorno =  "Contactar con Soporte para ver el   estado del Comprobande";
        }
        return $retorno;
    }

    public function boleta(Request $request)
    {
        // return $request;
        //boletas a buscar
        $boleta=Boleta::where('b_electronica',0)->where('id',$request->boleta_id)->first();
        $boleta_registro=Boleta_registro::where('boleta_id',$request->boleta_id)->get();
        // return $boleta;
        //configuracion
        $see=config_acceso_sunat::facturacion_electronica();

        //boleta

        // if($boleta->tipo=="producto"){
            //boleta

            $invoice=Config_fe::boleta($boleta, $boleta_registro);

        // }elseif($boleta->tipo=="servicio"){
        //     //boleta

        //     $invoice=Config_fe::boleta_servicio($boleta, $boleta_registro);

        // }

        //envio a SUNAT
        $result=config_acceso_sunat::send($see, $invoice);

        //lectura CDR
        $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

        //cambio de boleta electronica - en caso sea todo exitoso
        $boleta->b_electronica=1;
        $boleta->save();
        return redirect()->route('facturacion_electronica.index_boleta')->with('successMsg',$msg);
    }
    public function boleta_elec_all(Request $request){
        $boleta_codigo = $request->get('codigo_bol');
        //boletas a buscar
        $boleta=Boleta::where('b_electronica',0)->where('codigo_boleta',$boleta_codigo)->first();
        $boleta_registro=Boleta_registro::where('boleta_id',$boleta->id)->get();
        //configuracion
        $see=config_acceso_sunat::facturacion_electronica();
        $invoice=Config_fe::boleta($boleta, $boleta_registro);
        $result=config_acceso_sunat::send($see, $invoice);
        $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());
        //cambio de boleta electronica - en caso sea todo exitoso
        $boleta->b_electronica=1;
        $boleta->save();
        return $msg;
    }

    public function boleta_m_e(Request $request){

        ///boletas a buscar
        $boleta=Boleta_m::where('b_electronica',0)->where('id',$request->boleta_id)->first();
        $boleta_registro=Boleta_registros_m::where('boleta_m_id',$request->boleta_id)->get();

        foreach($boleta_registro as $boleta_registros){
            $boleta_registros->precio_unitario_comi=$boleta_registros->precio;
        }
        // return $boleta_registro;
        //configuracion
        $see=config_acceso_sunat::facturacion_electronica();

        //boleta
        $invoice=Config_fe::boleta($boleta, $boleta_registro);
        //envio a SUNAT
        $result=config_acceso_sunat::send($see, $invoice);
        //lectura CDR
        $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

        //cambio de boleta electronica - en caso sea todo exitoso
        $boleta->b_electronica=1;
        $boleta->save();
        return redirect()->route('facturacion_electronica.index_boleta')->with('successMsg',$msg);
    }

    public function boleta_m_e_all(Request $request){
        $boleta_codigo = $request->get('codigo_bol');
        //boletas a buscar
        $boleta=Boleta_m::where('b_electronica',0)->where('codigo_boleta',$boleta_codigo)->first();
        $boleta_registro=Boleta_registros_m::where('boleta_m_id',$boleta->id)->get();
        foreach($boleta_registro as $boleta_registros){
            $boleta_registros->precio_unitario_comi=$boleta_registros->precio;
        }
        //configuracion
        $see=config_acceso_sunat::facturacion_electronica();
        $invoice=Config_fe::boleta($boleta, $boleta_registro);
        $result=config_acceso_sunat::send($see, $invoice);
        $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());
        //cambio de boleta electronica - en caso sea todo exitoso
        $boleta->b_electronica=1;
        $boleta->save();
        return $msg;
    }
    public function validacion_sunat_boleta(Request $request){
        //* SOLO FACTURA POR AHORA
        $tipo = $request->tipo;
        $msg_r = $request->msg;
        $codigo = $request->codigo_bol;
        // $factura = Facturacion::where('codigo_fac'.$request->codigo_fac)->first();
        //BUSCA EL CODIGO ERROR
        $explod = explode(" ",$msg_r);
        $n_error = substr($explod[2], 0, 4) ;
        $valor_pas = $explod[1];


        switch ($tipo) {
            case 'boleta':
                $document = Boleta::where('codigo_boleta', $codigo)->first();
                break;
            case 'boleta_manual':
                $document = Boleta_m::where('codigo_boleta', $codigo)->first();
                break;
        }


        if(strlen($valor_pas) == 12){ //* 12 = ACEPTADA --------- 13 = RECHAZADA
            $retorno =  "Aceptada por Sunat";
        }elseif (strpos($msg_r,'Codigo Error: ') !== false) {
            $document->b_electronica = 2; //ESTADO ANULADO
            $document->save();
            $retorno =  "Rechazado por Sunat";
        }elseif(strpos($msg_r,'OBSERVACIONES') !== false){ //OBSERVACIONES PERO ENVIADOS
            $retorno =  "Aceptada con Observaciones";
        }elseif(strpos($msg_r,'HTTP') !== false){
            $retorno =  "Error en Servidores de Sunat, volver a intentar en 10 minutos";
        }else{
            $retorno =  "Contactar con Soporte para ver el   estado del Comprobande";
        }

        return $retorno;
    }
    // public function guia_remision(Request $request)
    // {
    //     $guia=Guia_remision::where('g_electronica',0)->where('id',$request->factura_id)->first();
    //     $guias_registros=g_remision_registro::where('guia_remision_id',$request->factura_id)->get();
    //     $tipo_transporte=$guia->tipo_transporte;

    //     //configuracion
    //     $see = config_acceso_sunat::getSeeApi();
    //     // dd($see);
    //     $invoice = Config_fe::guia_remision($guia,$guias_registros,$tipo_transporte);
    //     // dd($invoice);
    //     $result = config_acceso_sunat::send_guia($see,$invoice);
    //     // dd($result);
    //     $msg=config_acceso_sunat::lectura_cdr_guia2($result->getCdrResponse());

    //     // return var_dump($msg);

    //         // //cambio de guia electronica - en caso sea exitodo
    //     // $guia->g_electronica=1;
    //     // $guia->save();
    //     dd( $msg);

    //     return redirect()->route('facturacion_electronica.index_guia_remision')->with('successMsg',$msg);

    // }
    public function guia_remision_elec_all(Request $request){
        $remision_codigo = $request->get('codigo_remision');
        $guia=Guia_remision::where('g_electronica',0)->where('cod_guia',$remision_codigo)->first();
        $guias_registros=g_remision_registro::where('guia_remision_id',$guia->id)->get();
        $tipo_transporte=$guia->tipo_transporte;


        $see=config_acc_guia::getSeeApi();
        $invoice=Config_fe::guia_remision($guia,$guias_registros,$tipo_transporte);
        // return response()->json($invoice);

        //envio a SUNAT
        $result=config_acc_guia::send_guia($see, $invoice,$guia->id,'normal');
        // $msg=config_acc_guia::lectura_cdr_guia2($result);
        // return '';
        //cambio de guia electronica - en caso sea exitodo
        $guia->g_electronica=1;
        $guia->save();
        return '';
    }

    public function valid_cdr(Request $request){

        $guia_remi = Guia_remision::where('id', $request->get('codigo_remision'))->first();
        $empresa = Empresa::first();
        // $guia=Guia_remision::where('g_electronica',0)->where('cod_guia',$remision_codigo)->first();
        $guias_registros=g_remision_registro::where('guia_remision_id',$guia_remi->id)->get();
        $tipo_transporte=$guia_remi->tipo_transporte;
        //configuracion
        $see=config_acc_guia::getSeeApi();
        $invoice=Config_fe::guia_remision($guia_remi,$guias_registros,$tipo_transporte);
        $response = config_acc_guia::getcdr_guia($see,$guia_remi->ticket_guia_remision_sunat,$invoice);

        $guia_remi->estado_ticket_guia = 1;
        $guia_remi->save();

        return $response;
    }

    public function guia_remision_baja(Request $request)
    {

        $guia=Guia_remision::where('g_electronica',1)->where('id',$request->factura_id)->first();
        $guias_registros=g_remision_registro::where('guia_remision_id',$request->factura_id)->get();
        $tipo_transporte=$guia->tipo_transporte;

        //configuracion
        $see=config_acceso_sunat::guia_electronica();

        //guia
        $invoice=Config_fe::guia_remision_baja($guia,$guias_registros,$tipo_transporte);
        // dd($invoice);
        // return response()->json($invoice);

        //envio a SUNAT
        $result=config_acceso_sunat::send($see, $invoice);
        //lectura CDR
        $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());
        // return $msg;


        //cambio de guia electronica - en caso sea exitodo
        $guia->estado_anulado=1;
        $guia->save();

        return redirect()->route('facturacion_electronica.index_guia_remision')->with('successMsg',$msg);

    }
    // public function guia_remision_m(Request $request){
    //     $guia = GuiaRemisionManual::where('g_electronica',0)->where('id',$request->remision_id)->first();
    //     $guias_registros=GuiaRemisionMRegistros::where('guia_remision_m_id',$request->remision_id)->get();
    //     $tipo_transporte=$guia->tipo_transporte;

    //     //configuracion
    //     $see=config_acc_guia::getSeeApi();

    //     //guia
    //     $invoice=Config_fe::guia_remision($guia,$guias_registros,$tipo_transporte);
    //     // dd($invoice);
    //     // return response()->json($invoice);

    //     //envio a SUNAT
    //     $result=config_acc_guia::send_guia($see, $invoice,$guia->id,'manual');

    //     //lectura CDR
    //     $msg=config_acc_guia::lectura_cdr_guia2($result->getCdrResponse());

    //     //cambio de guia electronica - en caso sea exitodo
    //     $guia->g_electronica=1;
    //     $guia->save();

    //     return redirect()->route('facturacion_electronica.index_guia_remision')->with('successMsg',$msg);
    // }
    public function guia_remision_m_all(Request $request){
        $remision_codigo = $request->get('codigo_remision');
        $guia = GuiaRemisionManual::where('g_electronica',0)->where('cod_guia',$remision_codigo)->first();
        $guias_registros=GuiaRemisionMRegistros::where('guia_remision_m_id',$guia->id)->get();
        $tipo_transporte=$guia->tipo_transporte;

        //configuracion
        $see=config_acc_guia::getSeeApi();

        //guia
        $invoice=Config_fe::guia_remision($guia,$guias_registros,$tipo_transporte);
        // dd($invoice);
        // return response()->json($invoice);

        //envio a SUNAT
        $result=config_acc_guia::send_guia($see, $invoice,$guia->id,'manual');
        // dd()
        //lectura CDR
        // $msg=config_acc_guia::lectura_cdr_guia2($result->getCdrResponse());

        //cambio de guia electronica - en caso sea exitodo
        $guia->g_electronica=1;
        $guia->save();
        return '';
    }
    public function guia_remision_m_baja_sunat(Request $request){

        $guia=GuiaRemisionManual::where('g_electronica',1)->where('id',$request->guia_m_id)->first();
        $guias_registros=GuiaRemisionMRegistros::where('guia_remision_m_id',$request->guia_m_id)->get();
        $tipo_transporte=$guia->tipo_transporte;

        //configuracion
        $see=config_acceso_sunat::guia_electronica();

        //guia
        $invoice=Config_fe::guia_remision_baja($guia,$guias_registros,$tipo_transporte);
        // dd($invoice);
        // return response()->json($invoice);

        //envio a SUNAT
        $result=config_acceso_sunat::send($see, $invoice);
        //lectura CDR
        $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());
        // return $msg;


        //cambio de guia electronica - en caso sea exitodo
        $guia->estado_anulado=1;
        $guia->save();

        return redirect()->route('facturacion_electronica.index_guia_remision')->with('successMsg',$msg);

    }
    public function nota_credito(Request $request)
    {
        // return 1;
        //configuración
        $nota_credito=Nota_Credito::where('id',$request->id)->first();
        if(isset($nota_credito->fecha_emision)){
            $date = $nota_credito->fecha_emision;
            $fecha_emi = date_create($date);
        }else{
            $date = $nota_credito->created_at;
            $fecha_emi = date_create($date);
        }

        // $fecha_conv = date_format($date);
        // return var_dump($date);
        $notas_creditos_registro=Nota_Credito_registro::where('nota_credito_id',$request->id)->get();
        // return $notas_creditos_registro;
        //factura - factura registro
        if ($nota_credito->facturacion_id != null ) {
            $factura=Facturacion::where('id',$nota_credito->facturacion_id)->first();
            $factura_registro=Facturacion_registro::where('facturacion_id',$nota_credito->facturacion_id)->get();
        }elseif( $nota_credito->facturacion_m_id != null ){
            $factura=Facturacion_m::where('id',$nota_credito->facturacion_m_id)->first();
            $factura_registro=Facturacion_registro_m::where('facturacion_m_id',$nota_credito->facturacion_m_id)->get();
        }

        // $n_c_request=array('cantidad' => null,'precio'=>null);
        // return $factura_registro;
        foreach($notas_creditos_registro as $i => $nota_c_registros ){
            $n_c_cantidad[$i] = $nota_c_registros->cantidad;
            $n_c_precio[$i] = $nota_c_registros->precio;
        }

        switch ($nota_credito->motivo) {
            case 01:
                $des_mot = 'Anulacion de la operacion';
                break;
            case 02:
                $des_mot = 'Anulacion por error en el ruc';
                break;
            case 03:
                $des_mot = 'Correcion por error en la descripcion';
                break;
            case 06:
                $des_mot = 'Devolucion total';
                break;
            case 07:
                $des_mot = 'Devolucion por Item';
                break;
        }
        // case($nota_credito->motivo == 1){

        // }
        // if($nota_credito->motivo == 01){

        // }

        //notas_creditos_count
        $notas_creditos_count=Nota_Credito_registro::count();
        $notas_creditos_count++;

        //nota_Credito_numero
        $nota_credito_numero=$nota_credito->codigo_n_c;

        //gravada
        $gravada=$nota_credito->op_gravada;
        //exonerada
        $exonerada=$nota_credito->op_inafecta;
        //inafecta
        $inafecta=$nota_credito->op_exonerada;
        //request->motivo
        $motivo=$nota_credito->motivo;
        //sustento
        $sustento=$nota_credito->tipo;

        $see=config_acceso_sunat::facturacion_electronica();


        $invoice=Config_fe::nota_credito($factura,$factura_registro,$n_c_cantidad,$n_c_precio,$notas_creditos_count,$nota_credito_numero,$gravada,$exonerada,$inafecta,$motivo,$sustento,$fecha_emi,$des_mot,$notas_creditos_registro);
        //envio a SUNAT
        $result=config_acceso_sunat::send($see, $invoice);
        //lectura CDR
        $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());


        //contador
        $contador=count($notas_creditos_registro);

        //codigo
        $codigo=$factura->codigo_fac;


        if($nota_credito->facturacion_id != null ){
            nota_credito::kardex_devolucion($nota_credito,$contador,$codigo);
        }

        $nota_credito->n_electronica=1;
        $nota_credito->save();
        return redirect()->route('facturacion_electronica.index_nota_credito')->with('successMsg',$msg);
        // return redirect()->route('nota-credito.show',$nota_credito->id);

    }

    public function nota_credito_boleta(Request $request)
    {

        // return 'nota de credito boleta';
        $nota_credito=Nota_Credito::where('id',$request->id)->first();
        if(isset($nota_credito->fecha_emision)){
            $date = $nota_credito->fecha_emision;
            $fecha_emi = date_create($date);
        }else{
            $date = $nota_credito->created_at;
            $fecha_emi = date_create($date);
        }
        // return var_dump($fecha_emi);
        $notas_creditos_registro=Nota_Credito_registro::where('nota_credito_id',$request->id)->get();
        switch ($nota_credito->motivo) {
            case 01:
                $des_mot = 'Anulacion de la operacion';
                break;
            case 02:
                $des_mot = 'Anulacion por error en el ruc';
                break;
            case 03:
                $des_mot = 'Correcion por error en la descripcion';
                break;
            case 06:
                $des_mot = 'Devolucion total';
                break;
            case 07:
                $des_mot = 'Devolucion por Item';
                break;
        }
        // return $notas_creditos_registro;
        //factura - factura registro
        if ($nota_credito->boleta_id != null ) {
            $boleta=Boleta::where('id',$nota_credito->boleta_id)->first();
            $boleta_registro=Boleta_registro::where('boleta_id',$nota_credito->boleta_id)->get();
        }elseif( $nota_credito->boleta_m_id != null ){
            $boleta=Boleta_m::where('id',$nota_credito->boleta_m_id)->first();
            $boleta_registro=Boleta_registros_m::where('boleta_m_id',$nota_credito->boleta_m_id)->get();
        }


        // $n_c_request=array('cantidad' => null,'precio'=>null);
        // return $factura_registro;
        foreach($notas_creditos_registro as $i => $nota_c_registros ){
            $n_c_cantidad[$i] = $nota_c_registros->cantidad;
            $n_c_precio[$i] = $nota_c_registros->precio;
        }
        $notas_creditos_count=Nota_Credito_registro::count();
        $notas_creditos_count++;

        //nota_Credito_numero
        $nota_credito_numero=$nota_credito->codigo_n_c;

        //gravada
        $gravada=$nota_credito->op_gravada;
        //exonerada
        $exonerada=$nota_credito->op_inafecta;
        //inafecta
        $inafecta=$nota_credito->op_exonerada;
        //request->motivo
        $motivo=$nota_credito->motivo;
        //sustento
        $sustento=$nota_credito->tipo;

        $see=config_acceso_sunat::facturacion_electronica();
        // return count($notas_creditos_registro);
        $invoice=Config_fe::nota_credito_boleta($boleta,$boleta_registro,$n_c_cantidad,$n_c_precio,$notas_creditos_count,$nota_credito_numero,$gravada,$exonerada,$inafecta,$motivo,$sustento,$fecha_emi,$des_mot,$notas_creditos_registro);
        dd($invoice);
        //envio a SUNAT
        $result=config_acceso_sunat::send($see, $invoice);
        //lectura CDR
        $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

        //contador
        $contador=count($notas_creditos_registro);

        //codigo
        $codigo=$boleta->codigo_boleta;
        if($nota_credito->boleta_id != null ){
            nota_credito::kardex_devolucion($nota_credito,$contador,$codigo);
        }

        $nota_credito->n_electronica=1;
        $nota_credito->save();

        return redirect()->route('facturacion_electronica.index_nota_credito')->with('successMsg',$msg);
    }

    public function nota_credito_all(Request $request)
    {
        $codigo_nota  = $request->get('codigo_nota_credito');

        $nota_credito=Nota_Credito::where('codigo_n_c',$codigo_nota)->first();

        if(isset($nota_credito->fecha_emision)){
            $date = $nota_credito->fecha_emision;
            $fecha_emi = date_create($date);
        }else{
            $date = $nota_credito->created_at;
            $fecha_emi = date_create($date);
        }
        $notas_creditos_registro=Nota_Credito_registro::where('nota_credito_id',$nota_credito->id)->get();
        switch ($nota_credito->motivo) {
            case 01:
                $des_mot = 'Anulacion de la operacion';
                break;
            case 02:
                $des_mot = 'Anulacion por error en el ruc';
                break;
            case 03:
                $des_mot = 'Correcion por error en la descripcion';
                break;
            case 06:
                $des_mot = 'Devolucion total';
                break;
        }
        // return $notas_creditos_registro;
        if ($nota_credito->facturacion_id != null ) {
            // return "factura";
            //* FACTURA
            $factura=Facturacion::where('id',$nota_credito->facturacion_id)->first();
            $factura_registro=Facturacion_registro::where('facturacion_id',$factura->id)->get();
            // return $nota_credito;
            foreach($notas_creditos_registro as $i => $nota_c_registros ){
                $n_c_cantidad[$i] = $nota_c_registros->cantidad;
                $n_c_precio[$i] = $nota_c_registros->precio;
            }
            // return $n_c_precio;
            $notas_creditos_count=Nota_Credito_registro::count();
            $notas_creditos_count++;

            $nota_credito_numero=$nota_credito->codigo_n_c;

            //gravada
            $gravada=$nota_credito->op_gravada;
            //exonerada
            $exonerada=$nota_credito->op_inafecta;
            //inafecta
            $inafecta=$nota_credito->op_exonerada;
            //request->motivo
            $motivo=$nota_credito->motivo;
            //sustento
            $sustento=$nota_credito->tipo;

            $see=config_acceso_sunat::facturacion_electronica();


            $invoice=Config_fe::nota_credito($factura,$factura_registro,$n_c_cantidad,$n_c_precio,$notas_creditos_count,$nota_credito_numero,$gravada,$exonerada,$inafecta,$motivo,$sustento,$fecha_emi,$des_mot,$notas_creditos_registro);
            //envio a SUNAT
            $result=config_acceso_sunat::send($see, $invoice);
            //lectura CDR
            $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());


            //contador
            $contador=count($notas_creditos_registro);

            //codigo
            $codigo=$factura->codigo_fac;

            nota_credito::kardex_devolucion($nota_credito,$contador,$codigo);

            $nota_credito->n_electronica=1;
            $nota_credito->save();

        }elseif ($nota_credito->facturacion_m_id != null ) {
            // return "factura manual";
            //* FACTURA MANUAL
            $factura=Facturacion_m::where('id',$nota_credito->facturacion_m_id)->first();
            $factura_registro=Facturacion_registro_m::where('facturacion_m_id',$factura->id)->get();
            foreach($notas_creditos_registro as $i => $nota_c_registros ){
                $n_c_cantidad[$i] = $nota_c_registros->cantidad;
                $n_c_precio[$i] = $nota_c_registros->precio;
            }
            // return $n_c_precio;
            $notas_creditos_count=Nota_Credito_registro::count();
            $notas_creditos_count++;

            $nota_credito_numero=$nota_credito->codigo_n_c;

            //gravada
            $gravada=$nota_credito->op_gravada;
            //exonerada
            $exonerada=$nota_credito->op_inafecta;
            //inafecta
            $inafecta=$nota_credito->op_exonerada;
            //request->motivo
            $motivo=$nota_credito->motivo;
            //sustento
            $sustento=$nota_credito->tipo;

            $see=config_acceso_sunat::facturacion_electronica();


            $invoice=Config_fe::nota_credito($factura,$factura_registro,$n_c_cantidad,$n_c_precio,$notas_creditos_count,$nota_credito_numero,$gravada,$exonerada,$inafecta,$motivo,$sustento,$fecha_emi,$des_mot,$notas_creditos_registro);
            //envio a SUNAT
            $result=config_acceso_sunat::send($see, $invoice);
            //lectura CDR
            $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());


            //contador
            $contador=count($notas_creditos_registro);

            //codigo
            $codigo=$factura->codigo_fac;

            // nota_credito::kardex_devolucion($nota_credito,$contador,$codigo);

            $nota_credito->n_electronica=1;
            $nota_credito->save();
        }elseif ($nota_credito->boleta_id != null){

            //* BOLETA
            $boleta=Boleta::where('id',$nota_credito->boleta_id)->first();
            // return $boleta;
            $boleta_registro=Boleta_registro::where('boleta_id',$boleta->id)->get();
            foreach($notas_creditos_registro as $i => $nota_c_registros ){
                $n_c_cantidad[$i] = $nota_c_registros->cantidad;
                $n_c_precio[$i] = $nota_c_registros->precio;
            }
            // $msg = $n_c_precio;
            // return $msg;
            $notas_creditos_count=Nota_Credito_registro::count();
            $notas_creditos_count++;

            //nota_Credito_numero
            $nota_credito_numero=$nota_credito->codigo_n_c;

            //gravada
            $gravada=$nota_credito->op_gravada;
            //exonerada
            $exonerada=$nota_credito->op_inafecta;
            //inafecta
            $inafecta=$nota_credito->op_exonerada;
            //request->motivo
            $motivo=$nota_credito->motivo;
            //sustento
            $sustento=$nota_credito->tipo;

            $see=config_acceso_sunat::facturacion_electronica();

            $invoice=Config_fe::nota_credito_boleta($boleta,$boleta_registro,$n_c_cantidad,$n_c_precio,$notas_creditos_count,$nota_credito_numero,$gravada,$exonerada,$inafecta,$motivo,$sustento,$fecha_emi,$des_mot,$notas_creditos_registro);

            //envio a SUNAT
            $result=config_acceso_sunat::send($see, $invoice);
            //lectura CDR
            $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

            //contador
            $contador=count($notas_creditos_registro);

            //codigo
            $codigo=$boleta->codigo_boleta;
            nota_credito::kardex_devolucion($nota_credito,$contador,$codigo);

            $nota_credito->n_electronica=1;
            $nota_credito->save();
        }elseif($nota_credito->boleta_m_id != null){
            //* BOLETA MANUAL
            $boleta=Boleta_m::where('id',$nota_credito->boleta_m_id)->first();
            // return $boleta;
            $boleta_registro=Boleta_registros_m::where('boleta_m_id',$boleta->id)->get();
            foreach($notas_creditos_registro as $i => $nota_c_registros ){
                $n_c_cantidad[$i] = $nota_c_registros->cantidad;
                $n_c_precio[$i] = $nota_c_registros->precio;
            }
            // $msg = $n_c_precio;
            // return $msg;
            $notas_creditos_count=Nota_Credito_registro::count();
            $notas_creditos_count++;

            //nota_Credito_numero
            $nota_credito_numero=$nota_credito->codigo_n_c;

            //gravada
            $gravada=$nota_credito->op_gravada;
            //exonerada
            $exonerada=$nota_credito->op_inafecta;
            //inafecta
            $inafecta=$nota_credito->op_exonerada;
            //request->motivo
            $motivo=$nota_credito->motivo;
            //sustento
            $sustento=$nota_credito->tipo;

            $see=config_acceso_sunat::facturacion_electronica();

            $invoice=Config_fe::nota_credito_boleta($boleta,$boleta_registro,$n_c_cantidad,$n_c_precio,$notas_creditos_count,$nota_credito_numero,$gravada,$exonerada,$inafecta,$motivo,$sustento,$fecha_emi,$des_mot,$notas_creditos_registro);

            //envio a SUNAT
            $result=config_acceso_sunat::send($see, $invoice);
            //lectura CDR
            $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

            //contador
            $contador=count($notas_creditos_registro);

            //codigo
            $codigo=$boleta->codigo_boleta;
            // nota_credito::kardex_devolucion($nota_credito,$contador,$codigo);

            $nota_credito->n_electronica=1;
            $nota_credito->save();
        }
        return $msg;
    }
    // nota de debito

    public function nota_debito(Request $request)
    {

        // return $request;
        $nota_debito = Nota_Debito::where('id',$request->id)->first();
        $nota_debito_registros = Nota_Debito_registro::where('nota_debito_id',$nota_debito->id)->get();

        $date = $nota_debito->fecha_emision;
        $fecha_emi = date_create($date);

        if(isset($nota_debito->facturacion_id)){
            $factura=Facturacion::where('id',$nota_debito->facturacion_id)->first();
            $factura_registro=Facturacion_registro::where('facturacion_id',$factura->id)->get();
        }else{
            $factura=Facturacion_m::where('id',$nota_debito->facturacion_m_id)->first();
            $factura_registro=Facturacion_registro_m::where('facturacion_m_id',$factura->id)->get();
        }

        $nota_debito_code = $nota_debito->codigo_n_d;
        //gravada
        $gravada=$nota_debito->op_gravada;
        //exonerada
        $exonerada=$nota_debito->op_inafecta;
        //inafecta
        $inafecta=$nota_debito->op_exonerada;
        //request->motivo
        $tipo=$nota_debito->tipo;
        if($tipo == 01){
            $motivo = 'Interes por mora';
        }elseif ($tipo == 02) {
            $motivo = 'Aumentos en el valor';
        }else{
            $motivo = 'Penalidades';
        }
        //sustento
        $see=config_acceso_sunat::facturacion_electronica();

        // return $nota_debito_registros;
        $invoice=Config_fe::nota_debito($factura,$factura_registro,$request,$nota_debito_code,$gravada,$exonerada,$inafecta,$tipo,$motivo,$nota_debito_registros,$fecha_emi);

        //envio a SUNAT
        $result=config_acceso_sunat::send($see, $invoice);
        //lectura CDR
        $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

        $nota_debito->n_electronica=1;
        $nota_debito->save();

        return redirect()->route('facturacion_electronica.index_nota_debito')->with('successMsg',$msg);
    }

    public function nota_debito_boleta(Request $request)
    {

        $nota_debito = Nota_Debito::where('id',$request->id)->first();
        $nota_debito_registros = Nota_Debito_registro::where('nota_debito_id',$nota_debito->id)->get();

        $date = $nota_debito->fecha_emision;
        $fecha_emi = date_create($date);

        if(isset($nota_debito->boleta_id)){
            $boleta = Boleta::where('id',$nota_debito->boleta_id)->first();
            $boleta_registro = Boleta_registro::where('boleta_id',$boleta->id)->get();

        }else{
            $boleta = Boleta_m::where('id',$nota_debito->boleta_m_id)->first();
            $boleta_registro = Boleta_registros_m::where('boleta_m_id',$boleta->id)->get();
        }
        // return $boleta;
        $nota_debito_code = $nota_debito->codigo_n_d;
        //gravada
        $gravada=$nota_debito->op_gravada;
        //exonerada
        $exonerada=$nota_debito->op_inafecta;
        //inafecta
        $inafecta=$nota_debito->op_exonerada;
        //request->motivo
        $tipo=$nota_debito->tipo;
        if($tipo == 01){
            $motivo = 'Interes por mora';
        }elseif ($tipo == 02) {
            $motivo = 'Aumentos en el valor';
        }else{
            $motivo = 'Penalidades';
        }
        $see=config_acceso_sunat::facturacion_electronica();

        $invoice=Config_fe::nota_debito_boleta($boleta,$boleta_registro,$request,$nota_debito_code,$gravada,$exonerada,$inafecta,$tipo,$motivo,$nota_debito_registros,$fecha_emi);
        //envio a SUNAT
        $result=config_acceso_sunat::send($see, $invoice);
        //lectura CDR
        $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

        $nota_debito->n_electronica=1;
        $nota_debito->save();

        return redirect()->route('facturacion_electronica.index_nota_debito')->with('successMsg',$msg);


    }



    public function valid_cdr_manual(Request $request){

        $guia_remi = GuiaRemisionManual::where('id', $request->get('codigo_remision'))->first();
        $empresa = Empresa::first();
        // $guia=Guia_remision::where('g_electronica',0)->where('cod_guia',$remision_codigo)->first();
        $guias_registros=GuiaRemisionMRegistros::where('guia_remision_m_id',$guia_remi->id)->get();
        $tipo_transporte=$guia_remi->tipo_transporte;
        //configuracion
        $see=config_acc_guia::getSeeApi();
        $invoice=Config_fe::guia_remision($guia_remi,$guias_registros,$tipo_transporte);
        $response = config_acc_guia::getcdr_guia($see,$guia_remi->ticket_guia_remi_m_sunat,$invoice);

        $guia_remi->estado_ticket_guia_m = 1;
        $guia_remi->save();

        // return $response;
        return $response;

    }
    /**
     *



     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function list_facturas_env(Request $request){
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        // DATA DE DB
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();
        // FILTRADO
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'codigo_fac',
            3 => 'clienteconombre',
            4 => 'cliente.numero_documento',
            5 => 'fecha_emision',
            6 => 'total_conv',
            7 => 'estado_send',
            8 => 'xml_button',
            9 => 'total_conv',
            10 => 'estado_nc',
            11 => 'estado_nd',
        ];

        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();


        $query = Facturacion::with((['cliente', 'moneda']))->where('f_electronica','!=', 0)->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if(empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('codigo_fac', 'like', '%'. $filter . '%' );
                $q->orWhereHas('cliente', function ($q) use ($filter){
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });
                $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');
                $q->orWhereHas('forma_pago', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%');
                });
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $facturacion = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $facturacion->transform(function ($facturas) use ($igv){
            $subtotal = $facturas->op_gravada + $facturas->op_inafecta + $facturas->op_exonerada;

            $total = round($subtotal + ($facturas->op_gravada * $igv) / 100, 2);

            $facturas->emision = Carbon::parse($facturas->created_at)->format('d-m-Y');
            $facturas->total = $facturas->moneda->simbolo.' '. number_format($total,2);
            return $facturas;
        });
        // Bucle de llamada para el llenado del datatable
        foreach ($facturacion as $facturas) {
            $json['data'][] = [
                $facturas->id,
                $facturas->id,
                $facturas->codigo_fac,
                $facturas->cliente->numero_documento,
                $facturas->cliente->nombre,
                $facturas->emision,
                $facturas->total,
                $facturas->f_electronica,
                $facturas->id,
                $facturas->nota_credito,
                $facturas->nota_debito
            ];
        }
        return response()->json($json);
    }

    public function list_facturas_m_env(Request $request){
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        // DATA DE DB
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();
        // FILTRADO
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'codigo_fac',
            3 => 'clienteconombre',
            4 => 'cliente.numero_documento',
            5 => 'fecha_emision',
            6 => 'total_conv',
            7 => 'estado_send',
            8 => 'xml_button',
            9 => 'total_conv',
            10 => 'estado_nc',
            11 => 'estado_nd',
        ];

        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();


        $query = Facturacion_m::with((['cliente', 'moneda']))->where('f_electronica','!=', 0)->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if(empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('codigo_fac', 'like', '%'. $filter . '%' );
                $q->orWhereHas('cliente', function ($q) use ($filter){
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });
                $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');
                $q->orWhereHas('forma_pago', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%');
                });
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $facturacion = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $facturacion->transform(function ($facturas) use ($igv){
            $subtotal = $facturas->op_gravada + $facturas->op_inafecta + $facturas->op_exonerada;

            $total = round($subtotal + ($facturas->op_gravada * $igv) / 100, 2);

            $facturas->emision = Carbon::parse($facturas->created_at)->format('d-m-Y');
            $facturas->total = $facturas->moneda->simbolo.' '. number_format($total,2);
            return $facturas;
        });
        // Bucle de llamada para el llenado del datatable
        foreach ($facturacion as $facturas) {
            $json['data'][] = [
                $facturas->id,
                $facturas->id,
                $facturas->codigo_fac,
                $facturas->cliente->numero_documento,
                $facturas->cliente->nombre,
                $facturas->emision,
                $facturas->total,
                $facturas->f_electronica,
                $facturas->id,
                $facturas->nota_credito,
                $facturas->nota_debito
            ];
        }
        return response()->json($json);
    }

    // BOLETAS

    public function list_boletas_env(Request $request){
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        // DATA DE DB
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();
        // FILTRADO
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'codigo_boleta',
            3 => 'clienteconombre',
            4 => 'cliente.numero_documento',
            5 => 'fecha_emision',
            6 => 'total_conv',
            7 => 'estado_send',
            8 => 'xml_button',
            9 => 'total_conv',
            10 => 'estado_nc',
            11 => 'estado_nd',
        ];

        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();


        $query = Boleta::with((['cliente', 'moneda']))->where('b_electronica','!=', 0)->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if(empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('codigo_boleta', 'like', '%'. $filter . '%' );
                $q->orWhereHas('cliente', function ($q) use ($filter){
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });
                $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');
                $q->orWhereHas('forma_pago', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%');
                });
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $boletas = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $boletas->transform(function ($boletas) use ($igv){
            $subtotal = $boletas->op_gravada + $boletas->op_inafecta + $boletas->op_exonerada;

            $total = round($subtotal + ($boletas->op_gravada * $igv) / 100, 2);

            $boletas->emision = Carbon::parse($boletas->created_at)->format('d-m-Y');
            $boletas->total = $boletas->moneda->simbolo.' '. number_format($total,2);
            return $boletas;
        });
        // return $boletas;
        // Bucle de llamada para el llenado del datatable
        foreach ($boletas as $boleta) {
            $json['data'][] = [
                $boleta->id,
                $boleta->id,
                $boleta->codigo_boleta,
                $boleta->cliente->numero_documento,
                $boleta->cliente->nombre,
                $boleta->emision,
                $boleta->total,
                $boleta->b_electronica,
                $boleta->id,
                $boleta->nota_credito,
                $boleta->nota_debito
            ];
        }
        return response()->json($json);
    }

    public function list_boeltas_m_env(Request $request){
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        // DATA DE DB
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();
        // FILTRADO
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'codigo_fac',
            3 => 'clienteconombre',
            4 => 'cliente.numero_documento',
            5 => 'fecha_emision',
            6 => 'total_conv',
            7 => 'estado_send',
            8 => 'xml_button',
            9 => 'total_conv',
            10 => 'estado_nc',
            11 => 'estado_nd',
        ];

        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();


        $query = Boleta_m::with((['cliente', 'moneda']))->where('b_electronica','!=', 0)->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if(empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('codigo_fac', 'like', '%'. $filter . '%' );
                $q->orWhereHas('cliente', function ($q) use ($filter){
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });
                $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');
                $q->orWhereHas('forma_pago', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%');
                });
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $boletas_m = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $boletas_m->transform(function ($boleta_m) use ($igv){
            $subtotal = $boleta_m->op_gravada + $boleta_m->op_inafecta + $boleta_m->op_exonerada;

            $total = round($subtotal + ($boleta_m->op_gravada * $igv) / 100, 2);

            $boleta_m->emision = Carbon::parse($boleta_m->created_at)->format('d-m-Y');
            $boleta_m->total = $boleta_m->moneda->simbolo.' '. number_format($total,2);
            return $boleta_m;
        });
        // Bucle de llamada para el llenado del datatable
        foreach ($boletas_m as $bole_m) {
            $json['data'][] = [
                $bole_m->id,
                $bole_m->id,
                $bole_m->codigo_fac,
                $bole_m->cliente->numero_documento,
                $bole_m->cliente->nombre,
                $bole_m->emision,
                $bole_m->total,
                $bole_m->b_electronica,
                $bole_m->id,
                $bole_m->nota_credito,
                $bole_m->nota_debito
            ];
        }
        return response()->json($json);
    }

    public function list_remision_env(Request $request){
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        // DATA DE DB
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();
        // FILTRADO
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'cod_guia',
            3 => 'clienteconombre',
            4 => 'cliente.numero_documento',
            5 => 'fecha_emision',
            6 => 'fecha_entrega',
            7 => 'transporte',
            8 => 'estado_send',
            9 => 'zip_button',
            10 => 'xml_button',
            11 => 'ticket_guia_remision_sunat'
        ];

        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();


        if($request->daterange != ""){
            $query = Guia_remision::with((['cliente']))->where('g_electronica','!=', 0)->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');
        }else{
            $query = Guia_remision::with((['cliente']))->where('g_electronica','!=', 0)->orderBy('created_at', 'desc');
        }
        

        if(empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('cod_guia', 'like', '%'. $filter . '%' );
                $q->orWhereHas('cliente', function ($q) use ($filter){
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });
                $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $remision = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $remision->transform(function ($remision) use ($igv){
            if($remision->vehiculo_publico == null){
                $remision->transporte = 'Transporte Privado';
            }else{
                $remision->transporte = 'Transporte Publico';
            }
            // $remision->fecha_emision = Carbon::parse($remision->fecha_emision)->format('d-m-Y');
            $remision->fecha_entrega = Carbon::parse($remision->fecha_entrega)->format('d-m-Y');
            if($remision->ticket_guia_remision_sunat == null){
                $remision->ticket_guia_remision_sunat = 'Sin Ticket | Enviado con la version antigua de las Guia de Remision';
            }
            return $remision;
        });
        // Bucle de llamada para el llenado del datatable
        foreach ($remision as $remi) {
            $json['data'][] = [ 
                $remi->id,
                $remi->id,
                $remi->cod_guia,
                $remi->cliente->numero_documento,
                $remi->cliente->nombre,
                $remi->fecha_emision,
                $remi->fecha_entrega,
                $remi->transporte,
                $remi->id,
                $remi->id,
                $remi->g_electronica,
                $remi->ticket_guia_remision_sunat,
                $remi->estado_ticket_guia,
                $remi->id,
                $remi->motivo_anulacion
            ];
        }
        return response()->json($json);
    }

    public function list_remision_m_env(Request $request){
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        // FILTRADO
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'cod_guia',
            3 => 'clienteconombre',
            4 => 'cliente.numero_documento',
            5 => 'fecha_emision',
            6 => 'fecha_entrega',
            7 => 'transporte',
            8 => 'estado_send',
            9 => 'zip_button',
            10 => 'xml_button',
            11 => 'ticket_guia_remision_sunat'
        ];

        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();


        if($request->daterange == ""){
            $query = GuiaRemisionManual::with((['cliente']))->where('g_electronica','!=', 0)->orderBy('created_at', 'desc');
        }else{
            $query = GuiaRemisionManual::with((['cliente']))->where('g_electronica','!=', 0)->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');
        }

        if(empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('cod_guia', 'like', '%'. $filter . '%' );
                $q->orWhereHas('cliente', function ($q) use ($filter){
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });
                $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $remision = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $remision->transform(function ($remision){
            if($remision->vehiculo_publico == null){
                $remision->transporte = 'Transporte Privado';
            }else{
                $remision->transporte = 'Transporte Publico';
            }
            $remision->fecha_emision = Carbon::createFromFormat('d/m/Y',$remision->fecha_emision)->format('d-m-Y');
            $remision->fecha_entrega = Carbon::parse($remision->fecha_entrega)->format('d-m-Y');
            if($remision->ticket_guia_remision_sunat == null){
                $remision->ticket_guia_remision_sunat = 'Sin Ticket | Enviado con la version antigua de las Guia de Remision';
            }
            return $remision;
        });
        // Bucle de llamada para el llenado del datatable
        foreach ($remision as $remi) {
            $json['data'][] = [
                $remi->id,
                $remi->id,
                $remi->cod_guia,
                $remi->cliente->numero_documento,
                $remi->cliente->nombre,
                $remi->fecha_emision,
                $remi->fecha_entrega,
                $remi->transporte,
                $remi->id,
                $remi->id,
                $remi->g_electronica,
                $remi->ticket_guia_remision_sunat,
                $remi->estado_ticket_guia,
                $remi->id,
                $remi->motivo_anulacion
            ];
        }
        return response()->json($json);
    }

    public function list_nota_credito_env(Request $request){
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        // FILTRADO
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'codigo_n_c',
            3 => 'tipo',
            4 => 'codigo_doc_asc',
            5 => 'cliente.numero_documento',
            6 => 'clienteconombre',
            7 => 'fecha_emision',
            8 => 'fecha_entrega',
            9 => 'estado_send',
            10 => 'zip_button',
            11 => 'xml_button'
        ];

        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

        $query = Nota_Credito::where('n_electronica','!=', 0)->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if(empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('codigo_n_c', 'like', '%'. $filter . '%' );
                $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $notas_creditos = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $formatearFecha = function($fecha) {
            if (empty($fecha)) return '-';

            try {
                // Si está en formato DD/MM/YYYY (viene del accessor), convertir a DD-MM-YYYY para DataTables
                if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $fecha)) {
                    return Carbon::createFromFormat('d/m/Y', $fecha)->format('d-m-Y');
                }

                // Si está en formato YYYY-MM-DD, convertir a DD-MM-YYYY
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
                    return Carbon::createFromFormat('Y-m-d', $fecha)->format('d-m-Y');
                }

                // Si ya está en formato DD-MM-YYYY, dejarlo así
                if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $fecha)) {
                    return $fecha;
                }

                // Para otros formatos, intentar parsing automático
                return Carbon::parse($fecha)->format('d-m-Y');

            } catch (\Throwable $e) {
                // Si falla, reemplazar / por - para evitar problemas con DataTables
                return str_replace('/', '-', $fecha);
            }
        };

        $notas_creditos->transform(function ($credito) use($formatearFecha){
            // $credito->fecha_emision = Carbon::createFromFormat('Y-m-d H:i:s',$credito->fecha_emision)->format('d-m-Y');
            // $credito->fecha_envio = Carbon::parse($credito->updated_at)->format('d-m-Y');
            $credito->fecha_emision = $formatearFecha($credito->fecha_emision);
            $credito->fecha_envio = $formatearFecha($credito->updated_at);

            if($credito->facturacion_id != null){
                $credito->doc_asociado = "Factura";
                $credito->num_asociado = $credito->facturacion_id;
                $credito->cliente_numero_documento = $credito->nota_i_facturacion->cliente->numero_documento;
                $credito->cliente_nombre= $credito->nota_i_facturacion->cliente->nombre;
            }
            if($credito->facturacion_m_id != null){
                $credito->doc_asociado = "Factura M.";
                $credito->num_asociado = $credito->facturacion_m_id;
                $credito->cliente_numero_documento = $credito->nota_i_fac_manual->cliente->numero_documento;
                $credito->cliente_nombre= $credito->nota_i_fac_manual->cliente->nombre;
            }
            if($credito->boleta_id != null){
                $credito->doc_asociado = "Boleta";
                $credito->num_asociado = $credito->boleta_id;
                $credito->cliente_numero_documento = $credito->nota_i_boleta->cliente->numero_documento;
                $credito->cliente_nombre= $credito->nota_i_boleta->cliente->nombre;
            }
            if($credito->boleta_m_id != null){
                $credito->doc_asociado = "Boleta M.";
                $credito->num_asociado = $credito->boleta_m_id;
                $credito->cliente_numero_documento = $credito->nota_i_boleta_manual->cliente->numero_documento;
                $credito->cliente_nombre= $credito->nota_i_boleta_manual->cliente->nombre;
            }

            return $credito;
        });
        // Bucle de llamada para el llenado del datatable
        foreach ($notas_creditos as $remi) {
            $json['data'][] = [
                $remi->id,
                $remi->id,
                $remi->codigo_n_c,
                $remi->doc_asociado,
                $remi->num_asociado,
                $remi->cliente_numero_documento,
                $remi->cliente_nombre,
                $remi->fecha_emision,
                $remi->fecha_envio,
                $remi->n_electronica,
                $remi->id,
                $remi->id
            ];
        }
        return response()->json($json);

    }

    public function list_nota_debito_env(Request $request){
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        // FILTRADO
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'codigo_n_d',
            3 => 'tipo',
            4 => 'codigo_doc_asc',
            5 => 'cliente.numero_documento',
            6 => 'clienteconombre',
            7 => 'fecha_emision',
            8 => 'fecha_entrega',
            9 => 'estado_send',
            10 => 'zip_button',
            11 => 'xml_button'
        ];

        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

        $query = Nota_Debito::where('n_electronica','!=', 0)->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if(empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('codigo_n_d', 'like', '%'. $filter . '%' );
                $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $nota_debitos = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $nota_debitos->transform(function ($debito){
            $debito->fecha_emision = Carbon::createFromFormat('Y-m-d H:i:s',$debito->fecha_emision)->format('d-m-Y');
            $debito->fecha_envio = Carbon::parse($debito->updated_at)->format('d-m-Y');

            if($debito->facturacion_id != null){
                $debito->doc_asociado = "Factura";
                $debito->num_asociado = $debito->facturacion_id;
                $debito->cliente_numero_documento = $debito->nota_i_facturacion->cliente->numero_documento;
                $debito->cliente_nombre= $debito->nota_i_facturacion->cliente->nombre;
            }
            if($debito->facturacion_m_id != null){
                $debito->doc_asociado = "Factura M.";
                $debito->num_asociado = $debito->facturacion_m_id;
                $debito->cliente_numero_documento = $debito->nota_i_fac_manual->cliente->numero_documento;
                $debito->cliente_nombre= $debito->nota_i_fac_manual->cliente->nombre;
            }
            if($debito->boleta_id != null){
                $debito->doc_asociado = "Boleta";
                $debito->num_asociado = $debito->boleta_id;
                $debito->cliente_numero_documento = $debito->nota_i_boleta->cliente->numero_documento;
                $debito->cliente_nombre= $debito->nota_i_boleta->cliente->nombre;
            }
            if($debito->boleta_m_id != null){
                $debito->doc_asociado = "Boleta M.";
                $debito->num_asociado = $debito->boleta_m_id;
                $debito->cliente_numero_documento = $debito->nota_i_boleta_manual->cliente->numero_documento;
                $debito->cliente_nombre= $debito->nota_i_boleta_manual->cliente->nombre;
            }

            return $debito;
        });
        // Bucle de llamada para el llenado del datatable
        foreach ($nota_debitos as $nota_d) {
            $json['data'][] = [
                $nota_d->id,
                $nota_d->id,
                $nota_d->codigo_n_d,
                $nota_d->doc_asociado,
                $nota_d->num_asociado,
                $nota_d->cliente_numero_documento,
                $nota_d->cliente_nombre,
                $nota_d->fecha_emision,
                $nota_d->fecha_envio,
                $nota_d->n_electronica,
                $nota_d->id,
                $nota_d->id
            ];
        }
        return response()->json($json);
    }

}
