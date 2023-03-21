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
use PhpParser\Node\Stmt\Return_;

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
        $facturacion_m=Facturacion_m::where('f_electronica',0)->get();
        $facturacion=Facturacion::where('f_electronica',0)->get();

        $facturacion_enviada_m=Facturacion_m::where('f_electronica',1)->get();
        $facturacion_enviada=Facturacion::where('f_electronica',1)->get();
        return view('facturacion_electronica.factura.index',compact('facturacion','facturacion_enviada','facturacion_m','facturacion_enviada_m','empresa'));
    }

    public function index_boleta(){

        $empresa=Empresa::first();
        $boletas_enviadas=Boleta::where('b_electronica',1)->get();
        $boletas=Boleta::where('b_electronica',0)->get();

        $boletas_enviadas_m=Boleta_m::where('b_electronica',1)->get();
        $boletas_m=Boleta_m::where('b_electronica',0)->get();
        return view('facturacion_electronica.boleta.index',compact('boletas','boletas_enviadas','boletas_m','boletas_enviadas_m','empresa'));
    }

    public function index_guia_remision(){

        $empresa=Empresa::first();
        $guia_remisiones=Guia_remision::where('g_electronica',0)->where('estado_anulado',0)->get();
        $guia_remision_anulado=Guia_remision::where('g_electronica',1)->where('estado_anulado',1)->get();
        $guia_remision_enviados=Guia_remision::where('g_electronica',1)->where('estado_anulado',0)->get();

        $remision_m = GuiaRemisionManual::where('g_electronica',0)->where('estado_anulado',0)->get();
        $remision_m_anulado = GuiaRemisionManual::where('g_electronica',1)->where('estado_anulado',1)->get();
        $remision_m_enviados = GuiaRemisionManual::where('g_electronica',1)->where('estado_anulado',0)->get();

        return view('facturacion_electronica.guia_remision.index',compact('guia_remisiones','guia_remision_enviados','guia_remision_anulado','remision_m','remision_m_anulado','remision_m_enviados','empresa'));
    }
    
    public function index_nota_credito(){
        $empresa=Empresa::first();
        $n_creditos_enviados=Nota_Credito::where('n_electronica',1)->get();
        $n_creditos=Nota_Credito::where('n_electronica',0)->get();
        return view('facturacion_electronica.nota_credito.index',compact('n_creditos_enviados','n_creditos','empresa'));
    }
    public function index_nota_debito(){
        $empresa=Empresa::first();
        $n_debitos_enviados=Nota_Debito::where('n_electronica',1)->get();
        $n_debitos=Nota_Debito::where('n_electronica',0)->get();
        return view('facturacion_electronica.nota-debito.index',compact('n_debitos_enviados','n_debitos','empresa'));
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
        

        //configuracion de conexion
        $see=config_acceso_sunat::facturacion_electronica();

        // if($factura->tipo=="producto"){
            //factura
            $invoice=Config_fe::factura($factura, $factura_registro,$guia);
            
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
        $factura_registro=Facturacion_registro::where('facturacion_id',$factura->id)->get();
        if($factura->guia_remision=="0"){
            $guia=0;
        }else{
            $guia=1;
        }
        //configuracion de conexion
        $see= config_acceso_sunat::facturacion_electronica();
        
        //invoce
        $invoice=Config_fe::factura($factura, $factura_registro,$guia);
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
        $invoice=Config_fe::factura($factura, $factura_registro,$guia,$facturacion_manual);
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
        
        //Estado Aceptada
        $n_acept = substr($explod[1], 0, 8);

        //XML ERRORES
        $xml = substr($explod[1], 0);
        // return $xml;
        $document = Facturacion::where('codigo_fac', $codigo)->first();
        switch ($tipo) {
            case 'factura':
                $document = Facturacion::where('codigo_fac', $codigo)->first();
                break;
            case 'factura_manual':
                $document = Facturacion_m::where('codigo_fac', $codigo)->first();
                break;
        }
        // return $document;
        // return $explod;
        if(is_numeric($n_error) ){
            if($n_error < 1999){
                // $document->f_electronica = 2; //2 para estado anulado
                // $document->save();
                $retorno = "La ".$tipo." tiene un error, en caso salga error de nuevo contactar a soporte";
            }elseif($n_error  > 2000 && $n_error <  3999 ){
                // $document->f_electronica = 2; //2 para estado anulado
                // $document->save();
                $retorno =  "La ".$tipo." no ha podido ser enviada, verifique el contenido ";

            }else{ //ERROR >  4000
                $document->f_electronica = 2; //2 para estado anulado
                $document->save();
                $retorno =  "La ".$tipo." error en contenido de Observacion";
            }
        }elseif($xml == "XML"){
            //RETORNO XML ES POR ERROR VACIO O NO VALIDO EN ALGUNA PARTE, SE PUEDE MODIFICAR Y VOLVER A ENVIAR
            $retorno = "Intente volver a enviar la ".$tipo;
        }elseif($n_acept == "ACEPTADA"){
            $document->f_electronica = 1;
            $document->save();
            $retorno =  "Enviado correctamente";
        }else{
            $retorno = "Error no identificado en la ".$tipo.", no se registró, verifique en la Sunat";
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

        //lectura CDR
        $msg=config_acc_guia::lectura_cdr_guia2($result->getCdrResponse());


        //cambio de guia electronica - en caso sea exitodo 
        $guia->g_electronica=1;
        $guia->save();
        return $msg;
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
    public function guia_remision_m(Request $request){
        $guia = GuiaRemisionManual::where('g_electronica',0)->where('id',$request->remision_id)->first();
        $guias_registros=GuiaRemisionMRegistros::where('guia_remision_m_id',$request->remision_id)->get();
        $tipo_transporte=$guia->tipo_transporte;

        //configuracion
        $see=config_acc_guia::getSeeApi();

        //guia
        $invoice=Config_fe::guia_remision($guia,$guias_registros,$tipo_transporte);
        // dd($invoice);
        // return response()->json($invoice);
        
        //envio a SUNAT    
        $result=config_acc_guia::send_guia($see, $invoice,$guia->id,'manual');

        //lectura CDR
        $msg=config_acc_guia::lectura_cdr_guia2($result->getCdrResponse());

        //cambio de guia electronica - en caso sea exitodo
        $guia->g_electronica=1;
        $guia->save();

        return redirect()->route('facturacion_electronica.index_guia_remision')->with('successMsg',$msg);
    }
    public function guia_remision_m_all(Request $request){
        $remision_codigo = $request->get('codigo_remision');
        $guia = GuiaRemisionManual::where('g_electronica',0)->where('id',$remision_codigo)->first();
        $guias_registros=GuiaRemisionMRegistros::where('guia_remision_m_id',$remision_codigo)->get();
        $tipo_transporte=$guia->tipo_transporte;

        //configuracion
        $see=config_acc_guia::getSeeApi();

        //guia
        $invoice=Config_fe::guia_remision($guia,$guias_registros,$tipo_transporte);
        // dd($invoice);
        // return response()->json($invoice);
        
        //envio a SUNAT    
        $result=config_acc_guia::send_guia($see, $invoice,$guia->id,'manual');

        //lectura CDR
        $msg=config_acc_guia::lectura_cdr_guia2($result->getCdrResponse());

        //cambio de guia electronica - en caso sea exitodo
        $guia->g_electronica=1;
        $guia->save();
        return $msg;
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


        $invoice=Config_fe::nota_credito($factura,$factura_registro,$n_c_cantidad,$n_c_precio,$notas_creditos_count,$nota_credito_numero,$gravada,$exonerada,$inafecta,$motivo,$sustento,$fecha_emi,$des_mot);
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

        $invoice=Config_fe::nota_credito_boleta($boleta,$boleta_registro,$n_c_cantidad,$n_c_precio,$notas_creditos_count,$nota_credito_numero,$gravada,$exonerada,$inafecta,$motivo,$sustento,$fecha_emi,$des_mot);
        
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


            $invoice=Config_fe::nota_credito($factura,$factura_registro,$n_c_cantidad,$n_c_precio,$notas_creditos_count,$nota_credito_numero,$gravada,$exonerada,$inafecta,$motivo,$sustento,$fecha_emi,$des_mot);
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


            $invoice=Config_fe::nota_credito($factura,$factura_registro,$n_c_cantidad,$n_c_precio,$notas_creditos_count,$nota_credito_numero,$gravada,$exonerada,$inafecta,$motivo,$sustento,$fecha_emi,$des_mot);
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
    
            $invoice=Config_fe::nota_credito_boleta($boleta,$boleta_registro,$n_c_cantidad,$n_c_precio,$notas_creditos_count,$nota_credito_numero,$gravada,$exonerada,$inafecta,$motivo,$sustento,$fecha_emi,$des_mot);
            
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
    
            $invoice=Config_fe::nota_credito_boleta($boleta,$boleta_registro,$n_c_cantidad,$n_c_precio,$notas_creditos_count,$nota_credito_numero,$gravada,$exonerada,$inafecta,$motivo,$sustento,$fecha_emi,$des_mot);
            
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

    public function valid_cdr(Request $request){

        $guia_remi = Guia_remision::where('id', $request->get('id_guia'))->first();
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

        return response()->download(public_path('facturas_electronicas/'.'/R-'.$empresa->ruc.'-09-'.$guia_remi->cod_guia.'.zip'));

    }

    public function valid_cdr_manual(Request $request){

        $guia_remi = GuiaRemisionManual::where('id', $request->get('id_guia'))->first();
        $empresa = Empresa::first();
        // $guia=Guia_remision::where('g_electronica',0)->where('cod_guia',$remision_codigo)->first();
        $guias_registros=GuiaRemisionMRegistros::where('guia_remision_id',$guia_remi->id)->get();
        $tipo_transporte=$guia_remi->tipo_transporte;
        //configuracion
        $see=config_acc_guia::getSeeApi();
        $invoice=Config_fe::guia_remision($guia_remi,$guias_registros,$tipo_transporte);
        $response = config_acc_guia::getcdr_guia($see,$guia_remi->ticket_guia_remi_m_sunat,$invoice);

        $guia_remi->estado_ticket_guia_m = 1;
        $guia_remi->save();

        // return $response;
        return response()->download(public_path('facturas_electronicas/'.'/R-'.$empresa->ruc.'-09-'.$guia_remi->cod_guia.'.zip'));

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


}
