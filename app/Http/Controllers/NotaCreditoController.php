<?php

namespace App\Http\Controllers;

use App\Facturacion;
use App\Facturacion_registro;
use App\Facturacion_m;
use App\Boleta_m;
use App\Boleta_registros_m;
use App\Facturacion_registro_m;
use App\Boleta;
use App\Boleta_registro;
use App\Empresa;
use App\Igv;
use App\Banco;
use App\Nota_Credito;
use App\Nota_Credito_registro;
use App\Codigo_guia_almacen;
use App\Almacen;
use Carbon\Carbon;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\Storage;
use App\EmailBandejaEnvios;
use App\EmailBandejaEnviosArchivos;
use App\EmailConfiguraciones;
use App\Exports\NotaCreditoExport;

use DateTime;

use Illuminate\Http\Request;

class NotaCreditoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notas_creditos=Nota_Credito::get();
        return view('transaccion.venta.nota_credito.index',compact('notas_creditos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //cambiar de 0 a 1 en f_electronica
        $facturas=Facturacion::where('f_electronica',1)->where('estado',1)->where('nota_credito',0)->get();
        $facturas_manuales=Facturacion_m::where('f_electronica',1)->where('estado',1)->where('nota_credito',0)->get();
        $igv=Igv::first();
        return view('transaccion.venta.nota_credito.lista_facturacion',compact('facturas','facturas_manuales','igv'));
    }

    public function create_boleta()
    {
        //cambiar de 0 a 1 en f_electronica
        $boletas=Boleta::where('b_electronica',1)->where('estado',0)->where('nota_credito',0)->get();
        $boletas_manuales=Boleta_m::where('b_electronica',1)->where('estado',0)->where('nota_credito',0)->get();
        $igv=Igv::first();
        return view('transaccion.venta.nota_credito.lista_boleta',compact('boletas','boletas_manuales','igv'));
    }

    public function create_nota_credito(Request $request){

        // return $request;
        $fecha=$request->fecha_emision;
        // $date_format = date("d-m-Y", strtotime($fecha));
        // return $fecha;
        $time = date('H:i:s', time());
        $fecha_emision = Carbon::parse($fecha)->format('d/m/Y').' '.$time;
        $fecha_emision_db = $request->fecha_emision.' '.$time;

        // return $fecha_emision;


        $tipo_nota_credito=$request->tipo_nota_credito;

        if($tipo_nota_credito == 2 ){
            $sustento=$request->sustento;
            $nueva_factura=$request->nueva_factura;
            $descuento_global="- - -";
            //envia la factura - sin modificación
        }else if($tipo_nota_credito == 3){
            $sustento=$request->sustento;
            $nueva_factura="- - -";
            $descuento_global=$request->descuento_global;
            //envia la factura con modificación para valor unitario - osea llena el valor unitario por si solo a desceuto global - con una cantidad cero y una breve descripcion solo uno
        }else{
            //1 - anulacion de la operacion = envia la factura - sin modificacion
            //4 - abula la operacion = sin modificación
            //5 - envia pero con diferente descipción
            //6 - devuelve pero por cantidad y valor unitario del item
            //7 - devuelve pero con descuento por item
            //8 - casi nunca se utliza por requerieminto de retencion
            //9 - facturas emitidas a credito - no se sabe
            $sustento=$request->sustento;
            $nueva_factura="- - -";
            $descuento_global="- - -";
        }
        $tipo = $request->get('tipo');
        if($tipo == "factura_origi"){
            $facturacion=Facturacion::where('estado', 1)->where('codigo_fac',$request->factura_id)->first();
            $facturacion_registro=Facturacion_registro::where('facturacion_id',$facturacion->id)->get();
        }else{
            $facturacion=Facturacion_m::where('estado', 1)->where('codigo_fac',$request->factura_id)->first();
            $facturacion_registro=Facturacion_registro_m::where('facturacion_m_id',$facturacion->id)->get();
        }

        $empresa=Empresa::first();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();

        //validación por boleta no encontrada
        if($request->tipo_nota_credito == 02){
            if($tipo == "factura_origi"){
                $factura_buscada=Facturacion::where('codigo_fac',$request->nueva_factura)->first();
            }else{
                $factura_buscada=Facturacion_m::where('codigo_fac',$request->nueva_factura)->first();
            }
            if(isset($factura_buscada)){

            }else{
                return redirect()->route('nota-credito.index')->withErrors(['codigo de factura no encontrado!']);
            }
        }

        if($tipo_nota_credito == 01){//anulación de la operación
            return view('transaccion.venta.nota_credito.tipos.anulacion_operacion',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco','fecha_emision','fecha_emision_db','tipo_nota_credito','sustento','nueva_factura','descuento_global','tipo'));
        }else if($tipo_nota_credito == 02){//anulación por el error en el RUC
            return view('transaccion.venta.nota_credito.tipos.anulacion_error_ruc',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco','fecha_emision','fecha_emision_db','tipo_nota_credito','sustento','nueva_factura','descuento_global','tipo'));
        }else if($tipo_nota_credito == 03){//Corrección por error en la descripcion
            return view('transaccion.venta.nota_credito.tipos.correccion_error_descripcion',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco','fecha_emision','fecha_emision_db','tipo_nota_credito','sustento','nueva_factura','descuento_global','tipo'));
        }else if($tipo_nota_credito == 06){//devolucion total
            return view('transaccion.venta.nota_credito.tipos.devolucion_total',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco','fecha_emision','fecha_emision_db','tipo_nota_credito','sustento','nueva_factura','descuento_global','tipo'));
        }else if($tipo_nota_credito == 07){//devolucion por el item
            return view('transaccion.venta.nota_credito.tipos.devolucion_item',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco','fecha_emision','fecha_emision_db','tipo_nota_credito','sustento','nueva_factura','descuento_global','tipo'));
        }

    }

    public function create_boleta_nota_credito(Request $request){


        // return $request;
        $fecha=$request->fecha_emision;
        // $date_format = date("d-m-Y", strtotime($fecha));
        // return $fecha;
        $time = date('h:i:s', time());
        $fecha_emision = Carbon::parse($fecha)->format('d/m/Y').' '.$time;
        $fecha_emision_db = $request->fecha_emision.' '.$time;
        // return $fecha_emision;
        $tipo_nota_credito=$request->tipo_nota_credito;

        if($tipo_nota_credito == 2 ){
            $sustento=$request->sustento;
            $nueva_boleta=$request->nueva_boleta;
            $descuento_global="- - -";
            //envia la factura - sin modificación
        }else if($tipo_nota_credito == 3){
            $sustento=$request->sustento;
            $nueva_boleta="- - -";
            $descuento_global=$request->descuento_global;
            //envia la factura con modificación para valor unitario - osea llena el valor unitario por si solo a desceuto global - con una cantidad cero y una breve descripcion solo uno
        }else{
            //1 - anulacion de la operacion = envia la factura - sin modificacion
            //4 - abula la operacion = sin modificación
            //5 - envia pero con diferente descipción
            //6 - devuelve pero por cantidad y valor unitario del item
            //7 - devuelve pero con descuento por item
            //8 - casi nunca se utliza por requerieminto de retencion
            //9 - facturas emitidas a credito - no se sabe
            $sustento=$request->sustento;
            $nueva_boleta="- - -";
            $descuento_global="- - -";
        }
        $tipo = $request->get('tipo');
        if($tipo == "boleta_origi"){
            $boleta=Boleta::where('codigo_boleta',$request->boleta_id)->first();
            $boleta_registro=Boleta_registro::where('boleta_id',$boleta->id)->get();
        }else{
            $boleta=Boleta_m::where('codigo_boleta',$request->boleta_id)->first();
            $boleta_registro=Boleta_registros_m::where('boleta_m_id',$boleta->id)->get();
        }
        // return $boleta;

        $empresa=Empresa::first();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();


        //validación por boleta no encontrada
        if($request->tipo_nota_credito == 02){
            if($tipo == "boleta_origi"){
                $boleta_buscada=Boleta::where('codigo_boleta',$request->nueva_boleta)->first();
            }else{
                $boleta_buscada=Boleta_m::where('codigo_boleta',$request->nueva_boleta)->first();
            }
            if(isset($boleta_buscada)){

            }else{
                return redirect()->back()->withErrors(['codigo de boleta no encontrado!']);
            }
        }

        if($tipo_nota_credito == 01){//anulación de la operación
            return view('transaccion.venta.nota_credito.tipos_boleta.anulacion_operacion',compact('boleta','boleta_registro','empresa','igv','sub_total','banco','fecha_emision','fecha_emision_db','tipo_nota_credito','sustento','nueva_boleta','descuento_global','tipo'));
        }else if($tipo_nota_credito == 02){//anulación por el error en el RUC
            return view('transaccion.venta.nota_credito.tipos_boleta.anulacion_error_ruc',compact('boleta','boleta_registro','empresa','igv','sub_total','banco','fecha_emision','fecha_emision_db','tipo_nota_credito','sustento','nueva_boleta','descuento_global','tipo'));
        }else if($tipo_nota_credito == 03){//Corrección por error en la descripcion
            return view('transaccion.venta.nota_credito.tipos_boleta.correccion_error_descripcion',compact('boleta','boleta_registro','empresa','igv','sub_total','banco','fecha_emision','fecha_emision_db','tipo_nota_credito','sustento','nueva_boleta','descuento_global','tipo'));
        }else if($tipo_nota_credito == 06){//devolucion total
            return view('transaccion.venta.nota_credito.tipos_boleta.devolucion_total',compact('boleta','boleta_registro','empresa','igv','sub_total','banco','fecha_emision','fecha_emision_db','tipo_nota_credito','sustento','nueva_boleta','descuento_global','tipo'));
        }elseif($tipo_nota_credito == 0){

        }else if($tipo_nota_credito == 07){//devolucion por el item
            return view('transaccion.venta.nota_credito.tipos_boleta.devolucion_item',compact('boleta','boleta_registro','empresa','igv','sub_total','banco','fecha_emision','fecha_emision_db','tipo_nota_credito','sustento','nueva_boleta','descuento_global','tipo'));
        }

        return view('transaccion.venta.nota_credito.create_boleta',compact('boleta','boleta_registro','empresa','igv','sub_total','banco'));

    }

    public function motivo(Request $request){
        // return $request;
        if(isset($request->factura_id)){
            $facturacion=Facturacion::find($request->factura_id);
            return view('transaccion.venta.nota_credito.create_motivo',compact('facturacion'));
        }elseif(isset($request->factura_manual_id)){
            $facturacion_m=Facturacion_m::find($request->factura_manual_id);
            return view('transaccion.venta.nota_credito.create_motivo',compact('facturacion_m'));
        }elseif(isset($request->boleta_manual_id)){
            $boleta_m=Boleta_m::find($request->boleta_manual_id);
            return view('transaccion.venta.nota_credito.create_motivo_boleta',compact('boleta_m'));
        }else{
            $boleta=Boleta::find($request->boleta_id);
            return view('transaccion.venta.nota_credito.create_motivo_boleta',compact('boleta'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_factura(Request $request,$id)
    {
        // return $request;
        // return $ultima_nota_c;
        $tipo = $request->get('tipo');
        if($request->motivo==2){
            $sustento=$request->sustento;
            $nueva_factura=$request->nueva_factura;
            $descuento_global=NULL;
        }else if($request->motivo==3){
            $sustento=$request->sustento;
            $nueva_factura=NULL;
            $descuento_global=$request->descuento_global;
        }else{
            $sustento=$request->sustento;
            $nueva_factura=NULL;
            $descuento_global=NULL;
        }

        $gravada=0;
        $exonerada=0;
        $inafecta=0;

        //Contador Nota de Creditos
        $notas_creditos_count=Nota_Credito_registro::count();
        $notas_creditos_count++;

        if($tipo == "factura_origi"){
            $factura=Facturacion::where('id',$id)->first();
            $factura_registro=Facturacion_registro::where('facturacion_id',$id)->get();
        }else{
            $factura=Facturacion_m::where('id',$id)->first();
            $factura_registro=Facturacion_registro_m::where('facturacion_m_id',$id)->get();
        }
        // obtencion de la sucursal
        $almacen=$factura->almacen_id;

        //obtencion del almacen
        $almacen_id =Almacen::where('id', $almacen)->first();
        $sucursal = Codigo_guia_almacen::where('almacen_id',$almacen_id->id)->first();
        $nota_cod_n_credito=$sucursal->cod_nota_credito;

        if (is_numeric($nota_cod_n_credito)) {
            // exprecion del numero de la nota de credito
            $nota_cod_n_credito++;
            $sucursal_nr = str_pad($sucursal->serie_nota_credito, 2, "0", STR_PAD_LEFT);
            $nota_credito_nr=str_pad($nota_cod_n_credito, 8, "0", STR_PAD_LEFT);
        }else{
            // exprecion del numero de Nota de credito
            // GENERACION DE NUMERO DE Nota de credito
            $ultima_nota_c=Nota_Credito::where('almacen_id',$almacen_id->id)->whereNotNull('facturacion_id')->orWhereNotNull('facturacion_m_id')->latest()->first();
            $nota_credito_num=$ultima_nota_c->codigo_n_c;
            $nota_credito_num_string_porcion= explode("-", $nota_credito_num);
            $nota_credito_num_string=$nota_credito_num_string_porcion[1];
            $nota_credito_num=(int)$nota_credito_num_string;

            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_nota_credito','DESC')->latest()->first();
            if($nota_credito_num == 99999999){
                $ultima_nota_c = $almacen_codigo->serie_nota_credito+1;
                $almacen_save_last = Codigo_guia_almacen::find($sucursal->id);
                $almacen_save_last->serie_nota_credito = $almacen_codigo->serie_nota_credito+1;
                $almacen_save_last->save();
                $nota_credito_num = 00000000;
            }else{
                $ultima_nota_c = $sucursal->serie_nota_credito;
            }
            $nota_credito_num++;
            $sucursal_nr = str_pad($ultima_nota_c, 2, "0", STR_PAD_LEFT);
            $nota_credito_nr=str_pad($nota_credito_num, 8, "0", STR_PAD_LEFT);
        }

        $nota_credito_numero="FF".$sucursal_nr."-".$nota_credito_nr;

        // return $nota_credito_numero;

        if($request->motivo==2){
            $factura->codigo_fac=$nueva_factura;
        }
        // return $request;

        // return $request;
        // return var_dump($request->motivo);
        if($request->motivo == "07" || $request->motivo == "05"){
            $contadores=count($request->tipo_afec);
            for($a=0;$a<$contadores;$a++){
                $string=(string)$a;

                $opt = explode(' ',$request->tipo_afec[$a]);
                // return $opt[0];
                // if($request->$cantidad==NULL){
                // }else{
                    if($opt[0] == 'Gravado'){
                        // $gravada += round($factura_registro[$a]->precio*$request->$cantidad,2);
                        $gravada += round($request->input_precio[$a]*$request->input_cant[$a],2);
                    }
                    if($opt[0] == 'Exonerado'){
                        // $exonerada += round($factura_registro[$a]->precio*$request->$cantidad,2);
                        $exonerada += round($request->precio[$a]*$request->input_cant[$a],2);
                    }
                    if($opt[0] == 'Inafecto'){
                        // $inafecta += round($factura_registro[$a]->precio*$request->$cantidad,2);
                        $inafecta += round($request->precio[$a]*$request->input_cant[$a],2);
                    }
                // }
            }
            // return $gravada;

            // return $request ;
        }else{
            $contadores=count($factura_registro);
            if($tipo == "factura_origi"){
                for($a=0;$a<$contadores;$a++){
                    $string=(string)$a;
                    $cantidad="input_cantidad_".$string;
                    if($request->$cantidad==NULL){
                    }else{
                        if(isset($factura_registro[$a]->producto_id)){
                            if(strpos($factura_registro[$a]->producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                                $gravada += round($factura_registro[$a]->precio_unitario_comi*$request->$cantidad,2);
                            }
                            if(strpos($factura_registro[$a]->producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                                $exonerada += round($factura_registro[$a]->precio_unitario_comi*$request->$cantidad,2);
                            }
                            if(strpos($factura_registro[$a]->producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                                $inafecta += round($factura_registro[$a]->precio_unitario_comi*$request->$cantidad,2);
                            }
                        }else{
                            if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                                $gravada += round($factura_registro[$a]->precio_unitario_comi*$request->$cantidad,2);
                            }
                            if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                                $exonerada += round($factura_registro[$a]->precio_unitario_comi*$request->$cantidad,2);
                            }
                            if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                                $inafecta += round($factura_registro[$a]->precio_unitario_comi*$request->$cantidad,2);
                            }
                        }
                    }
                }
            }else{
                for($a=0;$a<$contadores;$a++){
                    $string=(string)$a;
                    $cantidad="input_cantidad_".$string;
                    if($request->$cantidad==NULL){
                    }else{
                        if(isset($factura_registro[$a]->producto_id)){
                            if(strpos($factura_registro[$a]->producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                                $gravada += round($factura_registro[$a]->precio*$request->$cantidad,2);
                            }
                            if(strpos($factura_registro[$a]->producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                                $exonerada += round($factura_registro[$a]->precio*$request->$cantidad,2);
                            }
                            if(strpos($factura_registro[$a]->producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                                $inafecta += round($factura_registro[$a]->precio*$request->$cantidad,2);
                            }
                        }else{
                            if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                                $gravada += round($factura_registro[$a]->precio*$request->$cantidad,2);
                            }
                            if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                                $exonerada += round($factura_registro[$a]->precio*$request->$cantidad,2);
                            }
                            if(strpos($factura_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                                $inafecta += round($factura_registro[$a]->precio*$request->$cantidad,2);
                            }
                        }
                    }
                }
            }

        }
        // return "a";
        $nota_credito=new Nota_Credito();
        $nota_credito->codigo_n_c=$nota_credito_numero;
        if($tipo == "factura_origi"){
            $nota_credito->facturacion_id=$factura->id;
        }else{
            $nota_credito->facturacion_m_id=$factura->id;
        }
        $nota_credito->fecha_emision=$request->fecha_emision;
        $nota_credito->tipo=$request->sustento;
        $nota_credito->almacen_id=$factura->almacen_id;
        $nota_credito->motivo=$request->motivo;
        $nota_credito->op_gravada=$gravada;
        $nota_credito->op_inafecta=$inafecta;
        $nota_credito->op_exonerada=$exonerada;
        $nota_credito->estado=0;
        $nota_credito->n_electronica=0;
        $nota_credito->save();

        $codigo=$factura->codigo_fac;
        $contar=0;

        // return $request;
        if($request->motivo == "07" || $request->motivo == "09"){
            $contador=count($request->tipo_afec);
            for($a=0;$a<$contadores;$a++){
                $string=(string)$a;
                $tipo = explode(' | ',$request->tipo_item[$a]);
                $opt = explode(' ',$request->tipo_afec[$a]);
                $nota_creditos_r=new Nota_Credito_registro();
                $nota_creditos_r->nota_credito_id=$nota_credito->id;
                //condicional para diferenciar productos y servicios en facturacion registro
                if($tipo[0] == "producto"){
                    $nota_creditos_r->producto_id=$tipo[1];
                }else{
                    $nota_creditos_r->servicio_id=$tipo[1];
                }

                $nota_creditos_r->precio=$request->input_precio[$a];
                $nota_creditos_r->cantidad=$request->input_cant[$a];
                // $nota_creditos_r->descuento=$request->$descuento;
                $nota_creditos_r->descripcion=$request->input_descripcion[$a];
                $nota_creditos_r->save();
                // }
            }
        } else {
            $contador=count($factura_registro);
            for($p=0;$p<$contador;$p++){
                $string=(string)$p;
                $precio="input_precio_".$string;
                $cantidad="input_cantidad_".$string;
                $descuento="input_descuento_".$string;
                $descripcion="input_descripcion_".$string;
                if($request->$cantidad==NULL){
                }else{
                    $nota_creditos_r=new Nota_Credito_registro();
                    $nota_creditos_r->nota_credito_id=$nota_credito->id;
                    //condicional para diferenciar productos y servicios en facturacion registro
                    if(isset($factura_registro[$p]->producto_id)){
                        $nota_creditos_r->producto_id=$factura_registro[$p]->producto_id;
                    }else{
                        $nota_creditos_r->servicio_id=$factura_registro[$p]->servicio_id;
                    }

                    $nota_creditos_r->precio=$request->$precio;
                    $nota_creditos_r->cantidad=$request->$cantidad;
                    $nota_creditos_r->descuento=$request->$descuento;
                    $nota_creditos_r->descripcion=$request->$descripcion;
                    $nota_creditos_r->save();
                    $contar++;
                }
            }
        }
        // return $request->input_cantidad_0;
        $contador=$contar;

        $nc_primera=Codigo_guia_almacen::where('id', $sucursal->id)->first();
        if(is_numeric($nc_primera->cod_nota_credito)){
            $nc_primera->cod_nota_credito='NN';
            $nc_primera->save();
        }
        // 1 ==  ANULACION TOTAL || 2 == ANULACION PARCIL
        if($request->motivo== "01" || $request->motivo== "02" || $request->motivo== "06" ){
            $factura->nota_credito=1;
        }else{
            $factura->nota_credito=2;
        }
        $factura->save();

        // return "listo";
        // return redirect()->back('nota-credito.index');

     return redirect()->route('nota-credito.show',$nota_credito->id);
        // return redirect()->route('nota-credito.index');

    }

    public function store_boleta(Request $request,$id)
    {
        // return $request;
        $tipo = $request->get('tipo');
        if($request->motivo==2){
            $sustento=$request->sustento;
            $nueva_boleta=$request->nueva_boleta;
            $descuento_global=NULL;
        }else if($request->motivo==3){
            $sustento=$request->sustento;
            $nueva_boleta=NULL;
            $descuento_global=$request->descuento_global;
        }else{
            $sustento=$request->sustento;
            $nueva_boleta=NULL;
            $descuento_global=NULL;
        }

        //contador nota de creditos
        $notas_creditos_count=Nota_Credito_registro::count();
        $notas_creditos_count++;
        if($tipo == "boleta_origi"){
            $boleta=Boleta::where('id',$id)->first();
            $boleta_registro=Boleta_registro::where('boleta_id',$id)->get();
        }else{
            $boleta=Boleta_m::where('id',$id)->first();
            $boleta_registro=Boleta_registros_m::where('boleta_m_id',$id)->get();
        }
        // return $request;

        $gravada=0;
        $exonerada=0;
        $inafecta=0;

        $gravada_s=0;
        $exonerada_s=0;
        $inafecta_s=0;

        // code nota_c
        // obtencion de la sucursal
        $almacen=$boleta->almacen_id;

        //obtencion del almacen
        $almacen_id =Almacen::where('id', $almacen)->first();
        $sucursal = Codigo_guia_almacen::where('almacen_id',$almacen_id->id)->first();
        $nota_cod_n_credito=$sucursal->cod_nota_credito_b;
        // return $sucursal;
        if (is_numeric($nota_cod_n_credito)) {
            // exprecion del numero de la nota de credito
            $nota_cod_n_credito++;
            $sucursal_nr = str_pad($sucursal->serie_nota_credito_b, 2, "0", STR_PAD_LEFT);
            $nota_credito_nr=str_pad($nota_cod_n_credito, 8, "0", STR_PAD_LEFT);
        }else{
                // exprecion del numero de Nota de credito
                // GENERACION DE NUMERO DE Nota de credito->whereNotNull('facturacion_id')->orWhereNotNull('facturacion_m_id')->latest()->first();
                $ultima_nota_c=Nota_Credito::where('almacen_id',$almacen_id->id)->whereNotNull('boleta_id')->orWhereNotNull('boleta_m_id')->latest()->first();
                $nota_credito_num=$ultima_nota_c->codigo_n_c;
                $nota_credito_num_string_porcion= explode("-", $nota_credito_num);
                $nota_credito_num_string=$nota_credito_num_string_porcion[1];
                $nota_credito_num=(int)$nota_credito_num_string;

                $almacen_codigo = Codigo_guia_almacen::orderBy('serie_nota_credito_b','DESC')->latest()->first();
                if($nota_credito_num == 99999999){
                    $ultima_nota_c = $almacen_codigo->serie_nota_credito_b+1;
                    $almacen_save_last = Codigo_guia_almacen::find($sucursal->id);
                    $almacen_save_last->serie_nota_credito_b = $almacen_codigo->serie_nota_credito_b+1;
                    $almacen_save_last->save();
                    $nota_credito_num = 00000000;
                }else{
                    $ultima_nota_c = $sucursal->serie_nota_credito_b;
                }
                $nota_credito_num++;
                $sucursal_nr = str_pad($ultima_nota_c, 2, "0", STR_PAD_LEFT);
                $nota_credito_nr=str_pad($nota_credito_num, 8, "0", STR_PAD_LEFT);
        }

        $nota_credito_numero="BB".$sucursal_nr."-".$nota_credito_nr;

        // return $nota_credito_numero;

        if($request->motivo==2){
            $boleta->codigo_boleta=$nueva_boleta;
        }

        // return $request;
        if ($request->motivo == "07" || $request->motivo == "05") {
            $contadores=count($request->tipo_afec);
            for($a=0;$a<$contadores;$a++){
                $string=(string)$a;
                $opt = explode(' ',$request->tipo_afec[$a]);
                if($opt[0] == 'Gravado'){
                    $gravada += round($request->input_precio[$a]*$request->input_cant[$a],2);
                }
                if($opt[0] == 'Exonerado'){
                    $exonerada += round($request->precio[$a]*$request->input_cant[$a],2);
                }
                if($opt[0] == 'Inafecto'){
                    $inafecta += round($request->precio[$a]*$request->input_cant[$a],2);
                }
            }
        } else {
            $contadores=count($boleta_registro);
            if($tipo == "boleta_origi" ){
                for($a=0;$a<$contadores;$a++){
                    $string=(string)$a;
                    $cantidad="input_cantidad_".$string;
                    if($request->$cantidad==NULL){
                    }else{
                        if(isset($boleta_registro[$a]->producto_id)){
                            if(strpos($boleta_registro[$a]->producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                                $gravada += round($boleta_registro[$a]->precio_unitario_comi*$request->$cantidad,2);

                            }
                            if(strpos($boleta_registro[$a]->producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                                $exonerada += round($boleta_registro[$a]->precio_unitario_comi*$request->$cantidad,2);
                            }
                            if(strpos($boleta_registro[$a]->producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                                $inafecta += round($boleta_registro[$a]->precio_unitario_comi*$request->$cantidad,2);
                            }
                        }else{
                            if(strpos($boleta_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                                $gravada += round($boleta_registro[$a]->precio_unitario_comi*$request->$cantidad,2);

                            }
                            if(strpos($boleta_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                                $exonerada += round($boleta_registro[$a]->precio_unitario_comi*$request->$cantidad,2);
                            }
                            if(strpos($boleta_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                                $inafecta += round($boleta_registro[$a]->precio_unitario_comi*$request->$cantidad,2);
                            }
                        }
                    }
                    // return $request;
                }
            }else{
                for($a=0;$a<$contadores;$a++){
                    $string=(string)$a;
                    $cantidad="input_cantidad_".$string;
                    if($request->$cantidad==NULL){
                    }else{
                        if(isset($boleta_registro[$a]->producto_id)){
                            if(strpos($boleta_registro[$a]->producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                                $gravada += round($boleta_registro[$a]->precio*$request->$cantidad,2);

                            }
                            if(strpos($boleta_registro[$a]->producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                                $exonerada += round($boleta_registro[$a]->precio*$request->$cantidad,2);
                            }
                            if(strpos($boleta_registro[$a]->producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                                $inafecta += round($boleta_registro[$a]->precio*$request->$cantidad,2);
                            }
                        }else{
                            if(strpos($boleta_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                                $gravada += round($boleta_registro[$a]->precio*$request->$cantidad,2);

                            }
                            if(strpos($boleta_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                                $exonerada += round($boleta_registro[$a]->precio*$request->$cantidad,2);
                            }
                            if(strpos($boleta_registro[$a]->servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                                $inafecta += round($boleta_registro[$a]->precio*$request->$cantidad,2);
                            }
                        }
                    }
                    // return $request;
                }
            }
        }


        // return $boleta_registro[$a]->precio_unitario_comi

        $nota_credito=new Nota_Credito();
        $nota_credito->codigo_n_c=$nota_credito_numero;
        if($tipo == "boleta_origi"){
            $nota_credito->boleta_id=$boleta->id;
        }else{
            $nota_credito->boleta_m_id=$boleta->id;
        }
        $nota_credito->tipo=$request->sustento;
        $nota_credito->almacen_id=$boleta->almacen_id;
        $nota_credito->fecha_emision= $request->fecha_emision;
        $nota_credito->motivo=$request->motivo;
        $nota_credito->op_gravada=$gravada;
        $nota_credito->op_inafecta=$inafecta;
        $nota_credito->op_exonerada=$exonerada;
        $nota_credito->estado=0;
        $nota_credito->n_electronica=0;
        $nota_credito->save();

        $codigo=$boleta->codigo_boleta;
        $contar=0;
        // $contador=count($boleta_registro);


        if($request->motivo == "07" || $request->motivo == "05"){
            $contador=count($request->tipo_afec);
            for($a=0;$a<$contadores;$a++){
                $string=(string)$a;
                $tipo = explode(' | ',$request->tipo_item[$a]);
                $opt = explode(' ',$request->tipo_afec[$a]);
                $nota_creditos_r=new Nota_Credito_registro();
                $nota_creditos_r->nota_credito_id=$nota_credito->id;
                //condicional para diferenciar productos y servicios en facturacion registro
                if($tipo[0] == "producto"){
                    $nota_creditos_r->producto_id=$tipo[1];
                }else{
                    $nota_creditos_r->servicio_id=$tipo[1];
                }

                $nota_creditos_r->precio=$request->input_precio[$a];
                $nota_creditos_r->cantidad=$request->input_cant[$a];
                // $nota_creditos_r->descuento=$request->$descuento;
                $nota_creditos_r->descripcion=$request->input_descripcion[$a];
                $nota_creditos_r->save();
                // }
            }
        } else {
            $contador=count($boleta_registro);
            for($p=0;$p<$contador;$p++){
                $string=(string)$p;
                $precio="input_precio_".$string;
                $cantidad="input_cantidad_".$string;
                $descuento="input_descuento_".$string;
                $descripcion="input_descripcion_".$string;
                if($request->$cantidad==NULL){
                }else{
                    $nota_creditos_r=new Nota_Credito_registro();
                    $nota_creditos_r->nota_credito_id=$nota_credito->id;
                    if(isset($boleta_registro[$p]->producto_id)){
                        $nota_creditos_r->producto_id=$boleta_registro[$p]->producto_id;
                    }else{
                        $nota_creditos_r->servicio_id=$boleta_registro[$p]->servicio_id;
                    }

                    $nota_creditos_r->precio=$boleta_registro[$p]->precio;
                    $nota_creditos_r->cantidad=$request->$cantidad;
                    $nota_creditos_r->descuento=$request->$descuento;
                    $nota_creditos_r->descripcion=$request->$descripcion;
                    $nota_creditos_r->save();
                    $contar++;
                }
            }
        }

        $contador=$contar;

        $nc_primera=Codigo_guia_almacen::where('id', $sucursal->id)->first();
        if(is_numeric($nc_primera->cod_nota_credito_b)){
            $nc_primera->cod_nota_credito_b='NN';
            $nc_primera->save();
        }
        // $boleta=Boleta::where('id',$id)->first();

        if($request->motivo== "01" || $request->motivo== "02" || $request->motivo== "06" ){
            $boleta->nota_credito=1;
        }else{
            $boleta->nota_credito=3;
        }
        $boleta->save();

        // return "exito";
     return redirect()->route('nota-credito.show',$nota_credito->id);
        // return redirect()->route('nota-credito.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return "1";
        $notas_credito=Nota_Credito::where('id',$id)->first();
        $notas_credito_registros=Nota_Credito_registro::where('nota_credito_id',$id)->get();

        $empresa=Empresa::first();
        //* FACTURA 0 - BOLETA  1 - FAC MANUAL 2
        if($notas_credito->facturacion_id != NULL){
            $document = Facturacion::where('id',$notas_credito->facturacion_id)->first();
            $doc_reg = Facturacion_registro::where('facturacion_id',$document->id)->get();
            $estado=0;
        }elseif($notas_credito->boleta_id != NULL){
            $document=Boleta::where('id',$notas_credito->boleta_id)->first();
            $doc_reg=Boleta_registro::where('boleta_id',$document->id)->get();
            $estado=1;
        }elseif($notas_credito->boleta_m_id != NULL){
            $document=Boleta_m::where('id',$notas_credito->boleta_m_id)->first();
            $doc_reg=Boleta_registros_m::where('boleta_m_id',$document->id)->get();
            $estado=3;
        }else{
            $document = Facturacion_m::where('id',$notas_credito->facturacion_m_id)->first();
            $doc_reg = Facturacion_registro_m::where('facturacion_m_id',$document->id)->get();
            $estado=2;
        }
        $igv=Igv::first();
        return view('transaccion.venta.nota_credito.show',compact('notas_credito','notas_credito_registros','empresa','estado','igv','document','doc_reg'));

    }

    public function print($id){
        $notas_credito=Nota_Credito::where('id',$id)->first();
        $notas_credito_registros=Nota_Credito_registro::where('nota_credito_id',$id)->get();

        $empresa=Empresa::first();
        //* FACTURA 0 - BOLETA  1 - FAC MANUAL 2
        if($notas_credito->facturacion_id != NULL){
            $document = Facturacion::where('id',$notas_credito->facturacion_id)->first();
            $doc_reg = Facturacion_registro::where('facturacion_id',$document->id)->get();
            $estado=0;
        }elseif($notas_credito->boleta_id != NULL){
            $document=Boleta::where('id',$notas_credito->boleta_id)->first();
            $doc_reg=Boleta_registro::where('boleta_id',$document->id)->get();
            $estado=1;
        }elseif($notas_credito->boleta_m_id != NULL){
            $document=Boleta_m::where('id',$notas_credito->boleta_m_id)->first();
            $doc_reg=Boleta_registros_m::where('boleta_m_id',$document->id)->get();
            $estado=3;
        }else{
            $document = Facturacion_m::where('id',$notas_credito->facturacion_m_id)->first();
            $doc_reg = Facturacion_registro_m::where('facturacion_m_id',$document->id)->get();
            $estado=2;
        }
        $igv=Igv::first();
        $textoQR = $this->generarTextoQRNotaCredito($notas_credito, $document, $empresa, $igv, $estado);
        $qrCode = $this->generarImagenQR($textoQR);

        return view('transaccion.venta.nota_credito.print',compact('notas_credito','notas_credito_registros','empresa','estado','igv','document','doc_reg','textoQR','qrCode'));
    }
    public function pdf(Request $request, $id){
        $name = $request->get('name');
        $notas_credito=Nota_Credito::where('id',$id)->first();
        $notas_credito_registros=Nota_Credito_registro::where('nota_credito_id',$id)->get();

        $empresa=Empresa::first();
        //* FACTURA 0 - BOLETA  1 - FAC MANUAL 2 -  BOL MANUAL 3
        if($notas_credito->facturacion_id != NULL){
            $document = Facturacion::where('id',$notas_credito->facturacion_id)->first();
            $doc_reg = Facturacion_registro::where('facturacion_id',$document->id)->get();
            $estado=0;
            $archivo  = $document->codigo_fac;
        }elseif($notas_credito->boleta_id != NULL){
            $document=Boleta::where('id',$notas_credito->boleta_id)->first();
            $doc_reg=Boleta_registro::where('boleta_id',$document->id)->get();
            $estado=1;
            $archivo  = $document->codigo_boleta;
        }elseif($notas_credito->boleta_m_id != NULL){
            $document=Boleta_m::where('id',$notas_credito->boleta_m_id)->first();
            $doc_reg=Boleta_registros_m::where('boleta_m_id',$document->id)->get();
            $estado=3;
            $archivo  = $document->codigo_boleta;
        }else{
            $document = Facturacion_m::where('id',$notas_credito->facturacion_m_id)->first();
            $doc_reg = Facturacion_registro_m::where('facturacion_m_id',$document->id)->get();
            $estado=2;
            $archivo  = $document->codigo_fac;
        }
        // $archivo=$name;
        $u=1;
        $igv=Igv::first();
        $textoQR = $this->generarTextoQRNotaCredito($notas_credito, $document, $empresa, $igv, $estado);
        $qrCode = $this->generarImagenQR($textoQR);
        $pdf=PDF::loadView('transaccion.venta.nota_credito.pdf',compact('notas_credito','notas_credito_registros','empresa','estado','igv','document','doc_reg','u','textoQR','qrCode'));
        // return View('transaccion.venta.nota_credito.pdf',compact('notas_credito','notas_credito_registros','empresa','estado','igv','document','doc_reg'));
        return $pdf->download('NC - '.$archivo.'.pdf');

        // return view('transaccion.venta.nota_credito.print',compact('notas_credito','notas_credito_registros','empresa','estado','igv','document','doc_reg'));
    }

    public function anular(Request $request){
        $id = $request->get('id_nota_cre');

        $nota = Nota_Credito::where('id', $id)->first();
        $nota->n_electronica = 2;
        $nota->save();
        // return $nota;
        //* Volver a poder generar nota de credito
        if (isset($nota->facturacion_id)) {
            $factura = Facturacion::where('id',$nota->facturacion_id)->first();
            $factura->nota_credito = 0;
            $factura->save();
        }
        if(isset($nota->facturacion_m_id)){
            $factura_m = Facturacion_m::where('id',$nota->facturacion_m_id)->first();
            $factura_m->nota_credito = 0;
            $factura_m->save();
        }
        if(isset($nota->boleta_id)){
            $boleta = Facturacion::where('id',$nota->boleta_id)->first();
            $boleta->nota_credito = 0;
            $boleta->save();
        }
        if(isset($nota->boleta_m_id)){
            $boleta_m = Facturacion::where('id',$nota->boleta_m_id)->first();
            $boleta_m->nota_credito = 0;
            $boleta_m->save();
        }

        return redirect()->back();
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


public function exportNotasCredito(Request $request)
{ $ids = $request->json('nota_ids');

    if (!empty($ids)) {
        $export = new NotaCreditoExport($ids);
    } else {
        $request->validate([
            'daterange' => 'required|string'
        ]);

        [$start, $end] = explode(' - ', $request->daterange);

        $export = new NotaCreditoExport(null, [
            'start'  => Carbon::createFromFormat('d/m/Y', $start)->startOfDay(),
            'end'    => Carbon::createFromFormat('d/m/Y', $end)->endOfDay(),
            'filter' => $request->input('value'),
            'tipo'   => $request->input('tipo_coti'),
        ]);
    }

    return Excel::download(
        $export,
        'Notas de Crédito_' . now('America/Lima')->format('Y-m-d') . '.xlsx'
    );
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
            return back()->withErrors(['No se seleccionaron notas de crédito para imprimir.']);
        }

        $notas = Nota_Credito::whereIn('id', $notaIds)->get();

        if ($notas->count() !== count($notaIds)) {
            return back()->withErrors(['Algunas notas de crédito seleccionadas no existen.']);
        }

        // Recopilar datos para múltiples notas de crédito
        $notasData = [];
        $igvModel = Igv::first();
        $empresa = Empresa::first();

        if (!$igvModel) {
            abort(500, 'Configuración de IGV no encontrada.');
        }
        if (!$empresa) {
            abort(500, 'Configuración de empresa no encontrada.');
        }

        foreach ($notas as $nota) {
            $nota_credito_reg = Nota_Credito_registro::where('nota_credito_id', $nota->id)->get();

            // Determinar el documento original y su estado
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

            // Calcular totales
            $sub_total = ($nota->op_gravada ?? 0) + ($nota->op_inafecta ?? 0) + ($nota->op_exonerada ?? 0);
            $sub_total_gravado = $nota->op_gravada ?? 0;
            $igv_p = ($sub_total_gravado * $igvModel->igv_total) / 100;
            $end = $sub_total + $igv_p;
            $end2 = number_format($end, 2);

            $textoQR = $this->generarTextoQRNotaCredito($nota, $document, $empresa, $igvModel, $estado);
            $qrCode = $this->generarImagenQR($textoQR);

            $notasData[] = [
                'nota_credito' => $nota,
                'nota_credito_reg' => $nota_credito_reg,
                'document' => $document,
                'doc_reg' => $doc_reg,
                'estado' => $estado,
                'sub_total' => $sub_total,
                'sub_total_gravado' => $sub_total_gravado,
                'igv_p' => $igv_p,
                'end' => $end,
                'end2' => $end2,
                'qrCode' => $qrCode,
                'textoQR' => $textoQR,
            ];
        }

        return view('transaccion.comprobantes.nota_credito.print_multiple', compact(
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
            return back()->with('error', 'No se seleccionaron notas de crédito para descargar.');
        }

        if (count($notaIds) === 1) {
            return $this->downloadSinglePDF($notaIds[0]);
        }

        $notas = Nota_Credito::whereIn('id', $notaIds)->get();

        if ($notas->count() !== count($notaIds)) {
            return back()->with('error', 'Algunas notas de crédito seleccionadas no existen.');
        }

        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $zipName = 'Notas_Credito_' . date('Y-m-d_H-i-s') . '.zip';
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

        foreach ($notas as $notas_credito) {
            try {
                $notas_credito_registros = Nota_Credito_registro::where('nota_credito_id', $notas_credito->id)->get();

                // Determinar el documento original y sus registros
                if ($notas_credito->facturacion_id != null) {
                    $document = Facturacion::find($notas_credito->facturacion_id);
                    $doc_reg = Facturacion_registro::where('facturacion_id', $document->id)->get();
                    $estado = 0;
                    $archivo = $document->codigo_fac;
                } elseif ($notas_credito->boleta_id != null) {
                    $document = Boleta::find($notas_credito->boleta_id);
                    $doc_reg = Boleta_registro::where('boleta_id', $document->id)->get();
                    $estado = 1;
                    $archivo = $document->codigo_boleta;
                } elseif ($notas_credito->boleta_m_id != null) {
                    $document = Boleta_m::find($notas_credito->boleta_m_id);
                    $doc_reg = Boleta_registros_m::where('boleta_m_id', $document->id)->get();
                    $estado = 3;
                    $archivo = $document->codigo_boleta;
                } else {
                    $document = Facturacion_m::find($notas_credito->facturacion_m_id);
                    $doc_reg = Facturacion_registro_m::where('facturacion_m_id', $document->id)->get();
                    $estado = 2;
                    $archivo = $document->codigo_fac;
                }

                $u = 1;
                $textoQR = $this->generarTextoQRNotaCredito($notas_credito, $document, $empresa, $igv, $estado);
                $qrCode = $this->generarImagenQR($textoQR);

                $pdf = PDF::loadView('transaccion.venta.nota_credito.pdf', compact(
                    'notas_credito',
                    'notas_credito_registros',
                    'empresa',
                    'estado',
                    'igv',
                    'document',
                    'doc_reg',
                    'u',
                    'qrCode',
                    'textoQR'
                ));

                $pdfContent = $pdf->output();

                $codigoNotaCredito = preg_replace('/[^a-zA-Z0-9_-]/', '_', $notas_credito->codigo_n_c);
                $fileName = 'NC_' . $codigoNotaCredito . '.pdf';
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
        return back()->with('error', 'Error al descargar notas de crédito: ' . $e->getMessage());
    }
}

private function downloadSinglePDF($id)
{
    try {
        $notas_credito = Nota_Credito::find($id);
        if (!$notas_credito) {
            return back()->with('error', 'Nota de crédito no encontrada.');
        }

        $notas_credito_registros = Nota_Credito_registro::where('nota_credito_id', $notas_credito->id)->get();
        $igv = Igv::first();
        $empresa = Empresa::first();

        // Determinar el documento original
        if ($notas_credito->facturacion_id != null) {
            $document = Facturacion::find($notas_credito->facturacion_id);
            $doc_reg = Facturacion_registro::where('facturacion_id', $document->id)->get();
            $estado = 0;
            $archivo = $document->codigo_fac;
        } elseif ($notas_credito->boleta_id != null) {
            $document = Boleta::find($notas_credito->boleta_id);
            $doc_reg = Boleta_registro::where('boleta_id', $document->id)->get();
            $estado = 1;
            $archivo = $document->codigo_boleta;
        } elseif ($notas_credito->boleta_m_id != null) {
            $document = Boleta_m::find($notas_credito->boleta_m_id);
            $doc_reg = Boleta_registros_m::where('boleta_m_id', $document->id)->get();
            $estado = 3;
            $archivo = $document->codigo_boleta;
        } else {
            $document = Facturacion_m::find($notas_credito->facturacion_m_id);
            $doc_reg = Facturacion_registro_m::where('facturacion_m_id', $document->id)->get();
            $estado = 2;
            $archivo = $document->codigo_fac;
        }

        $u = 1;
        $textoQR = $this->generarTextoQRNotaCredito($notas_credito, $document, $empresa, $igv, $estado);
        $qrCode = $this->generarImagenQR($textoQR);

        $pdf = PDF::loadView('transaccion.venta.nota_credito.pdf', compact(
            'notas_credito',
            'notas_credito_registros',
            'empresa',
            'estado',
            'igv',
            'document',
            'doc_reg',
            'u',
            'qrCode',
            'textoQR'
        ));

        return $pdf->download('NC_' . $archivo . '.pdf');

    } catch (\Exception $e) {
        return back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
    }
}

    /**
     * Genera el texto del código QR según los requisitos de SUNAT para notas de crédito
     *
     * @param \App\Nota_Credito $nota
     * @param mixed $documentoOriginal (Facturacion, Boleta, etc.)
     * @param \App\Empresa $empresa
     * @param \App\Igv $igv
     * @param int $estado (0=Factura, 1=Boleta, 2=FacturaM, 3=BoletaM)
     * @return string
     */
    private function generarTextoQRNotaCredito($nota, $documentoOriginal, $empresa, $igv, $estado)
    {
        try {
            $ruc = $empresa->ruc ?? '';

            $tipoDocumento = '07';

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
        $notaCreditoIds = $request->nota_ids;

        $mensaje = "";

        foreach ($notaCreditoIds as $id) {
            $notaCredito = Nota_Credito::find($id);
            if ($notaCredito) {
                $codigo = substr(md5($id . env('APP_KEY') . 'nota_credito'), 0, 22);

                $pdfUrl = url("nota_credito/share/{$codigo}");

                $mensaje .= "{$pdfUrl}\n";
            }
        }

        $mensajeCodificado = urlencode($mensaje);
        $whatsappUrl = "https://wa.me/{$numero}?text={$mensajeCodificado}";

        return redirect()->away($whatsappUrl);
    }

    public function descargarPorCodigo($codigo)
    {
        $notas = Nota_Credito::all();

        foreach ($notas as $not) {
            if (substr(md5($not->id . env('APP_KEY') . 'nota_credito'), 0, 22) === $codigo) {
                return redirect()->route('nota_credito.pdf', $not->id);
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

            $notas_credito = Nota_Credito::where('id', $id)->first();
            $notas_credito_registros = Nota_Credito_registro::where('nota_credito_id', $id)->get();
            $empresa = Empresa::first();
            $igv = Igv::first();

            // Determinar tipo de documento origen
            if ($notas_credito->facturacion_id != NULL) {
                $document = Facturacion::where('id', $notas_credito->facturacion_id)->first();
                $doc_reg = Facturacion_registro::where('facturacion_id', $document->id)->get();
                $estado = 0;
            } elseif ($notas_credito->boleta_id != NULL) {
                $document = Boleta::where('id', $notas_credito->boleta_id)->first();
                $doc_reg = Boleta_registro::where('boleta_id', $document->id)->get();
                $estado = 1;
            } elseif ($notas_credito->boleta_m_id != NULL) {
                $document = Boleta_m::where('id', $notas_credito->boleta_m_id)->first();
                $doc_reg = Boleta_registros_m::where('boleta_m_id', $document->id)->get();
                $estado = 3;
            } else {
                $document = Facturacion_m::where('id', $notas_credito->facturacion_m_id)->first();
                $doc_reg = Facturacion_registro_m::where('facturacion_m_id', $document->id)->get();
                $estado = 2;
            }

            $textoQR = $this->generarTextoQRNotaCredito($notas_credito, $document, $empresa, $igv, $estado);
            $qrCode = $this->generarImagenQR($textoQR);

            // Generar PDF
            $archivo = 'PDF-DOC-' . $notas_credito->codigo_n_c . '-' . $empresa->ruc . ".pdf";
            $u = 1;
            $pdf = PDF::loadView('transaccion.venta.nota_credito.pdf', compact('notas_credito', 'notas_credito_registros', 'empresa', 'estado', 'igv', 'document', 'doc_reg', 'u','textoQR','qrCode'));
            $content = $pdf->download();
            $especif = $date . $archivo;
            Storage::disk('mailbox')->put($especif, $content);

            // XML si aplica
            $xml_file = null;
            if ($notas_credito->n_electronica == 1) {
                $xml_file = $empresa->ruc . '-07-' . $notas_credito->codigo_n_c . '.xml';
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

            $yourEmail = $config_email->email;
            $firma = $config_email->firma;
            $alto = $config_email->alto_firma;
            $ancho = $config_email->ancho_firma;

            $titulo = "Nota de Crédito - " . $notas_credito->codigo_n_c;
            $mensaje_html = "Estimado cliente, adjuntamos la nota de crédito " . $notas_credito->codigo_n_c;
            $mensaje = view('email_html.email_send_layout', compact('empresa', 'mensaje_html', 'firma', 'alto', 'ancho'));

            $correos_envios = array_merge($emails, [$config_email->email_backup]);
            $mails_array = array_filter($correos_envios);

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

            if ($xml_file && file_exists(public_path() . '/facturas_electronicas/' . $xml_file)) {
                $xml_path = public_path() . '/facturas_electronicas/' . $xml_file;
                $message->attach(\Swift_Attachment::fromPath($xml_path));
            }

            // Enviar correo
            if ($mailer->send($message)) {
                $texto = strip_tags($mensaje_html);

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
            $nota_credito_ids = $request->get('nota_ids', []);

            if (empty($nota_credito_ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se seleccionaron notas de crédito para enviar.'
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

            // Configuración de email
            $yourEmail = $config_email->email;
            $firma = $config_email->firma;
            $alto = $config_email->alto_firma;
            $ancho = $config_email->ancho_firma;

            $titulo = "Notas de Crédito - " . count($nota_credito_ids) . " documento(s)";
            $mensaje_html = "Estimado cliente, adjuntamos las notas de crédito solicitadas.";
            $mensaje = view('email_html.email_send_layout', compact('empresa', 'mensaje_html', 'firma', 'alto', 'ancho'));

            $correos_envios = [$email, $config_email->email_backup];
            $mails_array = array_filter($correos_envios);

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

            foreach ($nota_credito_ids as $nota_credito_id) {
                $notas_credito = Nota_Credito::where('id', $nota_credito_id)->first();
                if (!$notas_credito) continue;

                $notas_credito_registros = Nota_Credito_registro::where('nota_credito_id', $nota_credito_id)->get();

                // Determinar tipo de documento origen
                if ($notas_credito->facturacion_id != NULL) {
                    $document = Facturacion::where('id', $notas_credito->facturacion_id)->first();
                    $doc_reg = Facturacion_registro::where('facturacion_id', $document->id)->get();
                    $estado = 0;
                } elseif ($notas_credito->boleta_id != NULL) {
                    $document = Boleta::where('id', $notas_credito->boleta_id)->first();
                    $doc_reg = Boleta_registro::where('boleta_id', $document->id)->get();
                    $estado = 1;
                } elseif ($notas_credito->boleta_m_id != NULL) {
                    $document = Boleta_m::where('id', $notas_credito->boleta_m_id)->first();
                    $doc_reg = Boleta_registros_m::where('boleta_m_id', $document->id)->get();
                    $estado = 3;
                } else {
                    $document = Facturacion_m::where('id', $notas_credito->facturacion_m_id)->first();
                    $doc_reg = Facturacion_registro_m::where('facturacion_m_id', $document->id)->get();
                    $estado = 2;
                }

                // Generar PDF
                $archivo = 'PDF-DOC-' . $notas_credito->codigo_n_c . '-' . $empresa->ruc . ".pdf";
                $u = 1;

                $textoQR = $this->generarTextoQRNotaCredito($notas_credito, $document, $empresa, $igv, $estado);
                $qrCode = $this->generarImagenQR($textoQR);

                $pdf = PDF::loadView('transaccion.venta.nota_credito.pdf', compact('notas_credito', 'notas_credito_registros', 'empresa', 'estado', 'igv', 'document', 'doc_reg', 'u','textoQR','qrCode'));
                $content = $pdf->download();
                $especif = $date . $archivo;
                Storage::disk('mailbox')->put($especif, $content);

                $pdfile = public_path() . '/archivos/' . $especif;
                $message->attach(\Swift_Attachment::fromPath($pdfile));

                $archivos_temporales[] = $especif;

                // Adjuntar XML si existe
                if ($notas_credito->n_electronica == 1) {
                    $xml_file = $empresa->ruc . '-07-' . $notas_credito->codigo_n_c . '.xml';
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

                // Guardar archivos PDF en bandeja
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
                    'message' => 'Se enviaron ' . count($nota_credito_ids) . ' nota(s) de crédito exitosamente a: ' . $email
                ]);
            }

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

