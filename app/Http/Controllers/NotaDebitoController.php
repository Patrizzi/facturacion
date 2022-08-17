<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Almacen;
use App\Codigo_guia_almacen;
use App\Facturacion;
use App\Facturacion_registro;
use App\Boleta;
use App\Boleta_m;
use App\Boleta_registro;
use App\Boleta_registros_m;
use App\Empresa;
use App\Igv;
use App\Banco;
use App\Nota_Debito;
use App\Facturacion_m;
use App\Facturacion_registro_m;
use App\Nota_Debito_registro;
use Carbon\Carbon;


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
        return view('transaccion.venta.nota_debito.lista_facturacion',compact('facturas','factura_manual'));
    }

    public function create_boleta()
    {
        //cambiar de 0 a 1 en f_electronica
        $boletas=Boleta::where('b_electronica',1)->where('estado',0)->where('nota_debito',0)->get();
        $boleta_manual = Boleta_m::where('b_electronica',1)->where('estado',0)->where('nota_debito',0)->get();;
        return view('transaccion.venta.nota_debito.lista_boleta',compact('boletas','boleta_manual'));
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
}
