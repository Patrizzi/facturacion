<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Almacen;
use App\Codigo_guia_almacen;
use App\Facturacion;
use App\Facturacion_registro;
use App\Boleta;
use App\Boleta_registro;
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
        return view('transaccion.venta.nota_debito.lista_boleta',compact('boletas'));
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

        $empresa=Empresa::first();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        // return $facturacion;
        // if($facturacion->tipo=="producto"){
            return view('transaccion.venta.nota_debito.create',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco','nota_debito_numero'));
        // }else{
            // return view('transaccion.venta.nota_debito.create_servicio',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco'));
        // }
        
    }

    public function create_boleta_nota_debito(Request $request){

        $boleta=Boleta::find($request->boleta_id);
        $boleta_registro=Boleta_registro::where('boleta_id',$request->boleta_id)->get();
        
        $empresa=Empresa::first();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        if($boleta->tipo=="producto"){
            return view('transaccion.venta.nota_debito.create_boleta',compact('boleta','boleta_registro','empresa','igv','sub_total','banco'));
        }else{
            return view('transaccion.venta.nota_debito.create_servicio_boleta',compact('boleta','boleta_registro','empresa','igv','sub_total','banco'));
        }
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
        //contador nota de creditos
        // $notas_debitos_count=Nota_Debito_registro::count();
        // $notas_debitos_count++;
        $factura=Facturacion::where('id',$id)->first();
        $factura_registro=Facturacion_registro::where('facturacion_id',$id)->get();
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
            $nota_debito->facturacion_id=$factura->id;
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

        // }else if($factura->tipo=="servicio"){

        //     $contadores=count($factura_registro);
        //     for($a=0;$a<$contadores;$a++){
        //         $string=(string)$a;
        //         $nombre="input_disabled_".$string;
        //         $nombre_precio="input_disabled_precio_".$string;
        //         if($request->$nombre_precio==NULL){
        //         }else{

        //             if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
        //                 $gravada_s += round($request->$nombre_precio*$factura_registro[$a]->cantidad,2);
        //             }
        //             if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
        //                 $exonerada_s += round($request->$nombre_precio*$factura_registro[$a]->cantidad,2);
        //             }
        //             if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
        //                 $inafecta_s += round($request->$nombre_precio*$factura_registro[$a]->cantidad,2);
        //             }
        //         }
        //     }
            
        //     // $invoice=Config_fe::nota_debito_servicio($factura,$factura_registro,$request,$notas_debitos_count,$nota_debito_numero,$gravada_s,$exonerada_s,$inafecta_s,$request->motivo);
        //     //envio a SUNAT    
        //     // $result=config_acceso_sunat::send($see, $invoice);
        //     //lectura CDR
        //     // $msg=config_acceso_sunat::lectura_cdr($result->getCdrResponse());
            
        //     $nota_debito=new Nota_Debito();
        //     $nota_debito->codigo_n_d=$nota_debito_numero;
        //     $nota_debito->facturacion_id=$factura->id;
        //     $nota_debito->tipo="servicio";
        //     $nota_debito->almacen_id=$factura->almacen_id;
        //     $nota_debito->motivo=$request->motivo;
        //     $nota_debito->op_gravada=$gravada;
        //     $nota_debito->op_inafecta=$inafecta;
        //     $nota_debito->op_exonerada=$exonerada;
        //     $nota_debito->save();

        //     // $codigo=$factura->cod_fac;
        //     $contar=0;
        //     $contador=count($factura_registro);
            
        //     for($p=0;$p<$contador;$p++){
        //         $string=(string)$p;
        //         $nombre="input_disabled_".$string;
        //         $nombre_precio="input_disabled_precio_".$string;
        //         if($request->$nombre_precio==NULL){
        //         }else{
        //             $nota_debitos_r=new Nota_Debito_registro();
        //             $nota_debitos_r->nota_debito_id=$nota_debito->id;
        //             $nota_debitos_r->servicio_id=$factura_registro[$p]->servicio_id;
        //             $nota_debitos_r->precio=$request->$nombre_precio;
        //             $nota_debitos_r->cantidad=$factura_registro[$p]->cantidad;
        //             $nota_debitos_r->save();
        //             $contar++;
        //         }
        //     }

        //     $contador=$contar;
        // }

        // modificacion para que se cierre el codigo en almacen
        $nd_primera=Codigo_guia_almacen::where('id', $sucursal->id)->first();
        if(is_numeric($nd_primera->cod_nota_debito)){
            $nd_primera->cod_nota_debito='NN';
            $nd_primera->save();
        }

        // $factura->nota_debito=1;
        // $factura->save();

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

        $empresa=Empresa::first();

        if($notas_debito->boleta_id==NULL){
            $estado=0;
        }else{
            $estado=1;
        }

        return view('transaccion.venta.nota_debito.show',compact('notas_debito','notas_debito_registros','empresa','estado'));
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
