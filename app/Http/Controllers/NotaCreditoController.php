<?php

namespace App\Http\Controllers;

use App\Facturacion;
use App\Facturacion_registro;
use App\Boleta;
use App\Boleta_registro;
use App\Empresa;
use App\Igv;
use App\Banco;
use App\Nota_Credito;
use App\Nota_Credito_registro;

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
        return view('transaccion.venta.nota_credito.lista_facturacion',compact('facturas'));
    }

    public function create_boleta()
    {
        //cambiar de 0 a 1 en f_electronica
        $boletas=Boleta::where('b_electronica',1)->where('estado',0)->where('nota_credito',0)->get();
        return view('transaccion.venta.nota_credito.lista_boleta',compact('boletas'));
    }

    public function create_nota_credito(Request $request){

        // return $request;
        $fecha_emision=$request->fecha_emision;
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

        $facturacion=Facturacion::where('codigo_fac',$request->factura_id)->first();
        $facturacion_registro=Facturacion_registro::where('facturacion_id',$facturacion->id)->get();
        
        $empresa=Empresa::first();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();

        //validación por boleta no encontrada
        if($request->tipo_nota_credito == 02){
            $factura_buscada=Facturacion::where('codigo_fac',$request->nueva_factura)->first();
            if(isset($factura_buscada)){
            
            }else{
                return redirect()->route('nota-credito.index')->withErrors(['codigo de factura no encontrado!']);
            }
        }

        if($tipo_nota_credito == 01){//anulación de la operación
            return view('transaccion.venta.nota_credito.tipos.anulacion_operacion',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_factura','descuento_global'));
        }else if($tipo_nota_credito == 02){//anulación por el error en el RUC
            return view('transaccion.venta.nota_credito.tipos.anulacion_error_ruc',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_factura','descuento_global'));
        }else if($tipo_nota_credito == 03){//Corrección por error en la descripcion
            return view('transaccion.venta.nota_credito.tipos.correccion_error_descripcion',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_factura','descuento_global'));
        }else if($tipo_nota_credito == 06){//devolucion total
            return view('transaccion.venta.nota_credito.tipos.devolucion_total',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_factura','descuento_global'));
        }else if($tipo_nota_credito == 07){//devolucion por el item
            //return view('transaccion.venta.nota_credito.tipos.devolucion_item',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_factura','descuento_global'));
        }
        
    }

    public function create_boleta_nota_credito(Request $request){
        
        
        //return $request;
        $fecha_emision=$request->fecha_emision;
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

        $boleta=Boleta::where('codigo_boleta',$request->boleta_id)->first();
        $boleta_registro=Boleta_registro::where('boleta_id',$boleta->id)->get();

        $empresa=Empresa::first();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        
        
        //validación por boleta no encontrada
        if($request->tipo_nota_credito == 02){
            $boleta_buscada=Boleta::where('codigo_boleta',$request->nueva_boleta)->first();
            if(isset($boleta_buscada)){

            }else{
                return redirect()->back('nota-credito.index')->withErrors(['codigo de boleta no encontrado!']);
            }
        }
        
        
        if($tipo_nota_credito == 01){//anulación de la operación
            return view('transaccion.venta.nota_credito.tipos_boleta.anulacion_operacion',compact('boleta','boleta_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_boleta','descuento_global'));
        }else if($tipo_nota_credito == 02){//anulación por el error en el RUC
            return view('transaccion.venta.nota_credito.tipos_boleta.anulacion_error_ruc',compact('boleta','boleta_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_boleta','descuento_global'));
        }else if($tipo_nota_credito == 03){//Corrección por error en la descripcion
            return view('transaccion.venta.nota_credito.tipos_boleta.correccion_error_descripcion',compact('boleta','boleta_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_boleta','descuento_global'));
        }else if($tipo_nota_credito == 06){//devolucion total
            return view('transaccion.venta.nota_credito.tipos_boleta.devolucion_total',compact('boleta','boleta_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_boleta','descuento_global'));
        }else if($tipo_nota_credito == 07){//devolucion por el item
            //return view('transaccion.venta.nota_credito.tipos_boleta.devolucion_item',compact('boleta','boleta_registro','empresa','igv','sub_total','banco','fecha_emision','tipo_nota_credito','sustento','nueva_boleta','descuento_global'));
        }

        return view('transaccion.venta.nota_credito.create_boleta',compact('boleta','boleta_registro','empresa','igv','sub_total','banco'));
        
    }

    public function motivo(Request $request){
        
        if(isset($request->factura_id)){
            $facturacion=Facturacion::find($request->factura_id);
            return view('transaccion.venta.nota_credito.create_motivo',compact('facturacion'));
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
    public function store(Request $request)
    {

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

        if($notas_credito->boleta_id==NULL){
            $estado=0;
        }else{
            $estado=1;
        }
        $igv=Igv::first();

        return view('transaccion.venta.nota_credito.show',compact('notas_credito','notas_credito_registros','empresa','estado','igv'));	

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
