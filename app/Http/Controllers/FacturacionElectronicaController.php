<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Boleta;
use App\Boleta_registro;
use App\Codigo_guia_almacen;
use App\Config_fe;
use App\Empresa;
use App\Facturacion;
use App\Facturacion_m;
use App\Facturacion_registro;
use App\Guia_remision;
use App\Nota_Credito;
use App\Nota_Credito_registro;
use App\Nota_Debito;
use App\Nota_Debito_registro;
use App\config_acceso_sunat;
use App\g_remision_registro;
use DateTime;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

        $boletas_enviadas=Boleta::where('b_electronica',1)->get();
        $boletas=Boleta::where('b_electronica',0)->get();
        return view('facturacion_electronica.boleta.index',compact('boletas','boletas_enviadas'));
    }

    public function index_guia_remision(){

        $guia_remisiones=Guia_remision::where('g_electronica',0)->where('estado_anulado',0)->get();
        $guia_remision_anulado=Guia_remision::where('g_electronica',1)->where('estado_anulado',1)->get();
        $guia_remision_enviados=Guia_remision::where('g_electronica',1)->where('estado_anulado',0)->get();
        return view('facturacion_electronica.guia_remision.index',compact('guia_remisiones','guia_remision_enviados','guia_remision_anulado'));
    }

    public function index_nota_credito(){
        $n_creditos_enviados=Nota_Credito::where('n_electronica',1)->get();
        $n_creditos=Nota_Credito::where('n_electronica',0)->get();
        return view('facturacion_electronica.nota_credito.index',compact('n_creditos_enviados','n_creditos'));
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
        $factura->f_electronica=1;
        $factura->save();

        return redirect()->route('facturacion_electronica.index')->with('successMsg',$msg);
    }

    
    public function boleta(Request $request)
    {
        //boletas a buscar
        $boleta=Boleta::where('b_electronica',0)->where('id',$request->factura_id)->first();
        $boleta_registro=Boleta_registro::where('boleta_id',$request->factura_id)->get();
        
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


    public function guia_remision(Request $request)
    {   
        $guia=Guia_remision::where('g_electronica',0)->where('id',$request->factura_id)->first();
        $guias_registros=g_remision_registro::where('guia_remision_id',$request->factura_id)->get();
        $tipo_transporte=$guia->tipo_transporte;

        //configuracion
        $see=config_acceso_sunat::guia_electronica();

        //guia
        $invoice=Config_fe::guia_remision($guia,$guias_registros,$tipo_transporte);
        // dd($invoice);
        // return response()->json($invoice);
        
        //envio a SUNAT    
        $result=config_acceso_sunat::send($see, $invoice);

        //lectura CDR
        $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

        //cambio de guia electronica - en caso sea exitodo
        $guia->g_electronica=1;
        $guia->save();

        return redirect()->route('facturacion_electronica.index_guia_remision')->with('successMsg',$msg);

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

    public function nota_credito(Request $request)
    {   
        // return 1;
        //configuración
        $nota_credito=Nota_Credito::where('id',$request->id)->first();
        $notas_creditos_registro=Nota_Credito_registro::where('nota_credito_id',$request->id)->get();
        // return $notas_creditos_registro;  
        //factura - factura registro
        $factura=Facturacion::where('id',$nota_credito->facturacion_id)->first();
        $factura_registro=Facturacion_registro::where('facturacion_id',$nota_credito->facturacion_id)->get();

        // $n_c_request=array('cantidad' => null,'precio'=>null);
        // return $factura_registro;
        foreach($notas_creditos_registro as $i => $nota_c_registros ){
            $n_c_cantidad[$i] = $nota_c_registros->cantidad;
            $n_c_precio[$i] = $nota_c_registros->precio;
        }

        // return $n_c_cantidad[0];

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


        $invoice=Config_fe::nota_credito($factura,$factura_registro,$n_c_cantidad,$n_c_precio,$notas_creditos_count,$nota_credito_numero,$gravada,$exonerada,$inafecta,$motivo,$sustento);
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
        return redirect()->route('facturacion_electronica.index_nota_credito')->with('successMsg',$msg);
        // return redirect()->route('nota-credito.show',$nota_credito->id);

    }


    public function nota_credito_boleta(Request $request)
    {   
        // return 'nota de credito boleta';
        $nota_credito=Nota_Credito::where('id',$request->id)->first();
        $notas_creditos_registro=Nota_Credito_registro::where('nota_credito_id',$request->id)->get();
        // return $notas_creditos_registro;  
        //factura - factura registro
        $boleta=Boleta::where('id',$nota_credito->boleta_id)->first();
        $boleta_registro=Boleta_registro::where('boleta_id',$nota_credito->boleta_id)->get();

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

         $invoice=Config_fe::nota_credito_boleta($boleta,$boleta_registro,$n_c_cantidad,$n_c_precio,$notas_creditos_count,$nota_credito_numero,$gravada,$exonerada,$inafecta,$motivo,$sustento);
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
        
        return redirect()->route('facturacion_electronica.index_nota_credito')->with('successMsg',$msg);
    }

    // nota de debito

    public function nota_debito(Request $request, $id)
    {   
        //contador nota de creditos
        $notas_debitos_count=Nota_Debito_registro::count();
        $notas_debitos_count++;
        $factura=Facturacion::where('id',$id)->first();
        $factura_registro=Facturacion_registro::where('facturacion_id',$id)->get();
        //configuracion
        $see=config_acceso_sunat::facturacion_electronica();

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

        if($factura->tipo=="producto"){

            $contadores=count($factura_registro);
            for($a=0;$a<$contadores;$a++){
                $string=(string)$a;
                $nombre="input_disabled_".$string;
                $nombre_precio="input_disabled_precio_".$string;
                if($request->$nombre_precio==NULL){
                }else{
                    if(strpos($factura_registro[$a]->producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                        $gravada += round($request->$nombre_precio*$factura_registro[$a]->cantidad,2);
                    }
                    if(strpos($factura_registro[$a]->producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                        $exonerada += round($request->$nombre_precio*$factura_registro[$a]->cantidad,2);
                    }
                    if(strpos($factura_registro[$a]->producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                        $inafecta += round($request->$nombre_precio*$factura_registro[$a]->cantidad,2);
                    }
                }
            }

            $invoice=Config_fe::nota_debito($factura,$factura_registro,$request,$notas_debitos_count,$nota_debito_numero,$gravada,$exonerada,$inafecta,$request->motivo);
            //envio a SUNAT    
            $result=config_acceso_sunat::send($see, $invoice);
            //lectura CDR
            $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

            $nota_debito=new Nota_Debito();
            $nota_debito->codigo_n_d=$nota_debito_numero;
            $nota_debito->facturacion_id=$factura->id;
            $nota_debito->tipo="producto";
            $nota_debito->almacen_id=$factura->almacen_id;
            $nota_debito->motivo=$request->motivo;
            $nota_debito->op_gravada=$gravada;
            $nota_debito->op_inafecta=$inafecta;
            $nota_debito->op_exonerada=$exonerada;
            $nota_debito->save();

            $codigo=$factura->codigo_fac;
            $contar=0;
            $contador=count($factura_registro);
            for($p=0;$p<$contador;$p++){
                $string=(string)$p;
                $nombre="input_disabled_".$string;
                $nombre_precio="input_disabled_precio_".$string;
                if($request->$nombre_precio==NULL){
                }else{
                    $nota_debitos_r=new Nota_Debito_registro();
                    $nota_debitos_r->nota_debito_id=$nota_debito->id;
                    $nota_debitos_r->producto_id=$factura_registro[$p]->producto_id;
                    $nota_debitos_r->precio=$request->$nombre_precio;
                    $nota_debitos_r->cantidad=$factura_registro[$p]->cantidad;
                    $nota_debitos_r->save();
                    $contar++;
                }
            }

            $contador=$contar;

        }else if($factura->tipo=="servicio"){

            $contadores=count($factura_registro);
            for($a=0;$a<$contadores;$a++){
                $string=(string)$a;
                $nombre="input_disabled_".$string;
                $nombre_precio="input_disabled_precio_".$string;
                if($request->$nombre_precio==NULL){
                }else{

                    if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                        $gravada_s += round($request->$nombre_precio*$factura_registro[$a]->cantidad,2);
                    }
                    if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                        $exonerada_s += round($request->$nombre_precio*$factura_registro[$a]->cantidad,2);
                    }
                    if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                        $inafecta_s += round($request->$nombre_precio*$factura_registro[$a]->cantidad,2);
                    }
                }
            }
            
            $invoice=Config_fe::nota_debito_servicio($factura,$factura_registro,$request,$notas_debitos_count,$nota_debito_numero,$gravada_s,$exonerada_s,$inafecta_s,$request->motivo);
            //envio a SUNAT    
            $result=config_acceso_sunat::send($see, $invoice);
            //lectura CDR
            $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());
            
            $nota_debito=new Nota_Debito();
            $nota_debito->codigo_n_d=$nota_debito_numero;
            $nota_debito->facturacion_id=$factura->id;
            $nota_debito->tipo="servicio";
            $nota_debito->almacen_id=$factura->almacen_id;
            $nota_debito->motivo=$request->motivo;
            $nota_debito->op_gravada=$gravada;
            $nota_debito->op_inafecta=$inafecta;
            $nota_debito->op_exonerada=$exonerada;
            $nota_debito->save();

            // $codigo=$factura->cod_fac;
            $contar=0;
            $contador=count($factura_registro);
            
            for($p=0;$p<$contador;$p++){
                $string=(string)$p;
                $nombre="input_disabled_".$string;
                $nombre_precio="input_disabled_precio_".$string;
                if($request->$nombre_precio==NULL){
                }else{
                    $nota_debitos_r=new Nota_Debito_registro();
                    $nota_debitos_r->nota_debito_id=$nota_debito->id;
                    $nota_debitos_r->servicio_id=$factura_registro[$p]->servicio_id;
                    $nota_debitos_r->precio=$request->$nombre_precio;
                    $nota_debitos_r->cantidad=$factura_registro[$p]->cantidad;
                    $nota_debitos_r->save();
                    $contar++;
                }
            }

            $contador=$contar;
        }

        // modificacion para que se cierre el codigo en almacen
        $nd_primera=Codigo_guia_almacen::where('id', $sucursal->id)->first();
        if(is_numeric($nd_primera->cod_nota_debito)){
            $nd_primera->cod_nota_debito='NN';
            $nd_primera->save();
        }

        $factura->nota_debito=1;
        $factura->save();

        return redirect()->route('nota-debito.show',$nota_debito->id);

    }

    public function nota_debito_boleta(Request $request, $id)
    {   
        //contador nota de debitos
        $notas_debitos_count=Nota_Debito_registro::count();
        $notas_debitos_count++;
        $boleta=Boleta::where('id',$id)->first();
        $boleta_registro=Boleta_registro::where('boleta_id',$id)->get();
        //configuracion
        $see=config_acceso_sunat::facturacion_electronica();

        $gravada=0;
        $exonerada=0;
        $inafecta=0;

        $gravada_s=0;
        $exonerada_s=0;
        $inafecta_s=0;


        // code nota_d
        // obtencion de la sucursal
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

        if($boleta->tipo=="producto"){

            $contadores=count($boleta_registro);
            for($a=0;$a<$contadores;$a++){
                $string=(string)$a;
                $nombre="input_disabled_".$string;
                $nombre_precio="input_disabled_precio_".$string;
                if($request->$nombre_precio==NULL){
                }else{
                    if(strpos($boleta_registro[$a]->producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                        $gravada += round($request->$nombre_precio*$boleta_registro[$a]->cantidad,2);
                    }
                    if(strpos($boleta_registro[$a]->producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                        $exonerada += round($request->$nombre_precio*$boleta_registro[$a]->cantidad,2);
                    }
                    if(strpos($boleta_registro[$a]->producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                        $inafecta += round($request->$nombre_precio*$boleta_registro[$a]->cantidad,2);
                    }
                }
            }


            $nota_debito=new Nota_Debito();
            $nota_debito->codigo_n_d=$nota_debito_numero;
            $nota_debito->boleta_id=$boleta->id;
            $nota_debito->tipo="producto";
            $nota_debito->almacen_id=$boleta->almacen_id;
            $nota_debito->motivo=$request->motivo;
            $nota_debito->op_gravada=$gravada;
            $nota_debito->op_inafecta=$inafecta;
            $nota_debito->op_exonerada=$exonerada;
            $nota_debito->save();
            
            $codigo=$boleta->codigo_boleta;

            
            $invoice=Config_fe::nota_debito_boleta($boleta,$boleta_registro,$request,$notas_debitos_count,$nota_debito_numero,$gravada,$exonerada,$inafecta,$request->motivo);
            //envio a SUNAT    
            $result=config_acceso_sunat::send($see, $invoice);
            //lectura CDR
            $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

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
                    $nota_debitos_r->producto_id=$boleta_registro[$p]->producto_id;
                    $nota_debitos_r->precio=$request->$nombre_precio;
                    $nota_debitos_r->cantidad=$boleta_registro[$p]->cantidad;
                    $nota_debitos_r->save();
                    $contar++;
                }
            }
            $contador=$contar;

        }else if($boleta->tipo=="servicio"){

            $contadores=count($boleta_registro);
            for($a=0;$a<$contadores;$a++){
                $string=(string)$a;
                $nombre="input_disabled_".$string;
                $nombre_precio="input_disabled_precio_".$string;
                if($request->$nombre_precio==NULL){
                }else{
                    if(strpos($boleta_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                        $gravada_s += round($request->$nombre_precio*$boleta_registro[$a]->cantidad,2);
                    }
                    if(strpos($boleta_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                        $exonerada_s += round($request->$nombre_precio*$boleta_registro[$a]->cantidad,2);
                    }
                    if(strpos($boleta_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                        $inafecta_s += round($request->$nombre_precio*$boleta_registro[$a]->cantidad,2);
                    }
                }
            }


            $nota_debito=new Nota_Debito();
            $nota_debito->codigo_n_d=$nota_debito_numero;
            $nota_debito->boleta_id=$boleta->id;
            $nota_debito->tipo="servicio";
            $nota_debito->almacen_id=$boleta->almacen_id;
            $nota_debito->motivo=$request->motivo;
            $nota_debito->op_gravada=$gravada;
            $nota_debito->op_inafecta=$inafecta;
            $nota_debito->op_exonerada=$exonerada;
            $nota_debito->save();
            
            $invoice=Config_fe::nota_debito_boleta_servicio($boleta,$boleta_registro,$request,$notas_debitos_count,$nota_debito_numero,$gravada_s,$exonerada_s,$inafecta_s,$request->motivo);
            //envio a SUNAT    
            $result=config_acceso_sunat::send($see, $invoice);
            //lectura CDR
            $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());

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
                    $nota_debitos_r->servicio_id=$boleta_registro[$p]->servicio_id;
                    $nota_debitos_r->precio=$request->$nombre_precio;
                    $nota_debitos_r->cantidad=$boleta_registro[$p]->cantidad;
                    $nota_debitos_r->save();
                    $contar++;
                }
            }
            $contador=$contar;
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
