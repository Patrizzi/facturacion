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
use Barryvdh\DomPDF\Facade as PDF;
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
        $facturas=Facturacion::where('f_electronica',1)->where('estado',0)->where('nota_credito',0)->get();
        $facturas_manuales=Facturacion_m::where('f_electronica',1)->where('estado',0)->where('nota_credito',0)->get();
        return view('transaccion.venta.nota_credito.lista_facturacion',compact('facturas','facturas_manuales'));
    }

    public function create_boleta()
    {
        //cambiar de 0 a 1 en f_electronica
        $boletas=Boleta::where('b_electronica',1)->where('estado',0)->where('nota_credito',0)->get();
        $boletas_manuales=Boleta_m::where('b_electronica',1)->where('estado',0)->where('nota_credito',0)->get();
        return view('transaccion.venta.nota_credito.lista_boleta',compact('boletas','boletas_manuales'));
    }

    public function create_nota_credito(Request $request){

        // return $request;
        $fecha=$request->fecha_emision;
        // $date_format = date("d-m-Y", strtotime($fecha));
        // return $fecha;
        $time = date('h:i:s', time());  
        $fecha_emision = $fecha.' '.$time;
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
            $facturacion=Facturacion::where('codigo_fac',$request->factura_id)->first();
            $facturacion_registro=Facturacion_registro::where('facturacion_id',$facturacion->id)->get();
        }else{
            $facturacion=Facturacion_m::where('codigo_fac',$request->factura_id)->first();
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
            return view('transaccion.venta.nota_credito.tipos.anulacion_operacion',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_factura','descuento_global','tipo'));
        }else if($tipo_nota_credito == 02){//anulación por el error en el RUC
            return view('transaccion.venta.nota_credito.tipos.anulacion_error_ruc',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_factura','descuento_global','tipo'));
        }else if($tipo_nota_credito == 03){//Corrección por error en la descripcion
            return view('transaccion.venta.nota_credito.tipos.correccion_error_descripcion',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_factura','descuento_global','tipo'));
        }else if($tipo_nota_credito == 06){//devolucion total
            return view('transaccion.venta.nota_credito.tipos.devolucion_total',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_factura','descuento_global','tipo'));
        }else if($tipo_nota_credito == 07){//devolucion por el item
            //return view('transaccion.venta.nota_credito.tipos.devolucion_item',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_factura','descuento_global'));
        }
        
    }

    public function create_boleta_nota_credito(Request $request){
        
        
        // return $request;
        $fecha=$request->fecha_emision;
        // $date_format = date("d-m-Y", strtotime($fecha));
        // return $fecha;
        $time = date('h:i:s', time());  
        $fecha_emision = $fecha.' '.$time;
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
                return redirect()->back('nota-credito.index')->withErrors(['codigo de boleta no encontrado!']);
            }
        }
        
        if($tipo_nota_credito == 01){//anulación de la operación
            return view('transaccion.venta.nota_credito.tipos_boleta.anulacion_operacion',compact('boleta','boleta_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_boleta','descuento_global','tipo'));
        }else if($tipo_nota_credito == 02){//anulación por el error en el RUC
            return view('transaccion.venta.nota_credito.tipos_boleta.anulacion_error_ruc',compact('boleta','boleta_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_boleta','descuento_global','tipo'));
        }else if($tipo_nota_credito == 03){//Corrección por error en la descripcion
            return view('transaccion.venta.nota_credito.tipos_boleta.correccion_error_descripcion',compact('boleta','boleta_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_boleta','descuento_global','tipo'));
        }else if($tipo_nota_credito == 06){//devolucion total
            return view('transaccion.venta.nota_credito.tipos_boleta.devolucion_total',compact('boleta','boleta_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_boleta','descuento_global','tipo'));
        }else if($tipo_nota_credito == 07){//devolucion por el item
            //return view('transaccion.venta.nota_credito.tipos_boleta.devolucion_item',compact('boleta','boleta_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_boleta','descuento_global'));
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

        $contador=$contar;

        $nc_primera=Codigo_guia_almacen::where('id', $sucursal->id)->first();
        if(is_numeric($nc_primera->cod_nota_credito)){
            $nc_primera->cod_nota_credito='NN';
            $nc_primera->save();
        }

        $factura->nota_credito=1;
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
        if($tipo == "factura_origi"){
            $boleta=Boleta::where('id',$id)->first();
            $boleta_registro=Boleta_registro::where('boleta_id',$id)->get();
        }else{
            $boleta=Boleta_m::where('id',$id)->first();
            $boleta_registro=Boleta_registros_m::where('boleta_m_id',$id)->get();
        }
        

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
        $nota_credito->fecha_emision=$request->fecha_emision;
        $nota_credito->motivo=$request->motivo;
        $nota_credito->op_gravada=$gravada;
        $nota_credito->op_inafecta=$inafecta;
        $nota_credito->op_exonerada=$exonerada;
        $nota_credito->estado=0;
        $nota_credito->n_electronica=0;
        $nota_credito->save();
        
        $codigo=$boleta->codigo_boleta;
        $contar=0;
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
        $contador=$contar;

        $nc_primera=Codigo_guia_almacen::where('id', $sucursal->id)->first();
        if(is_numeric($nc_primera->cod_nota_credito_b)){
            $nc_primera->cod_nota_credito_b='NN';
            $nc_primera->save();
        }
        // $boleta=Boleta::where('id',$id)->first();
        $boleta->nota_credito=2;
        $boleta->save();
        
        return "exito";
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
        }else{
            $document = Facturacion_m::where('id',$notas_credito->facturacion_m_id)->first();
            $doc_reg = Facturacion_registro_m::where('facturacion_id',$documenta->id)->get();
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
        }else{
            $document = Facturacion_m::where('id',$notas_credito->facturacion_m_id)->first();
            $doc_reg = Facturacion_registro_m::where('facturacion_id',$documenta->id)->get();
            $estado=2;
        }
        $igv=Igv::first();

        return view('transaccion.venta.nota_credito.print',compact('notas_credito','notas_credito_registros','empresa','estado','igv','document','doc_reg'));	
    }
    public function pdf(Request $request, $id){
        $name = $request->get('name');
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
        }else{
            $document = Facturacion_m::where('id',$notas_credito->facturacion_m_id)->first();
            $doc_reg = Facturacion_registro_m::where('facturacion_id',$documenta->id)->get();
            $estado=2;
        }
        $archivo=$name;
        $u=1;
        $igv=Igv::first();
        $pdf=PDF::loadView('transaccion.venta.nota_credito.pdf',compact('notas_credito','notas_credito_registros','empresa','estado','igv','document','doc_reg','u'));
        // return View('transaccion.venta.nota_credito.pdf',compact('notas_credito','notas_credito_registros','empresa','estado','igv','document','doc_reg'));
        return $pdf->download('Nota de Credito - '.$archivo.'.pdf');

        // return view('transaccion.venta.nota_credito.print',compact('notas_credito','notas_credito_registros','empresa','estado','igv','document','doc_reg'));
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
