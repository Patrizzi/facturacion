<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Facturacion;
use App\Facturacion_registro;
use App\Boleta;
use App\Boleta_registro;
use App\Empresa;
use App\Igv;
use App\Banco;
use App\Nota_Debito;
use App\Nota_Debito_registro;


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
        return view('transaccion.venta.nota_debito.lista_facturacion',compact('facturas'));
    }

    public function create_boleta()
    {
        //cambiar de 0 a 1 en f_electronica
        $boletas=Boleta::where('b_electronica',1)->where('estado',0)->where('nota_debito',0)->get();
        return view('transaccion.venta.nota_debito.lista_boleta',compact('boletas'));
    }

    public function create_nota_debito(Request $request){

        $facturacion=Facturacion::find($request->factura_id);
        $facturacion_registro=Facturacion_registro::where('facturacion_id',$request->factura_id)->get();
        
        $empresa=Empresa::first();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        if($facturacion->tipo=="producto"){
            return view('transaccion.venta.nota_debito.create',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco'));
        }else{
            return view('transaccion.venta.nota_debito.create_servicio',compact('facturacion','facturacion_registro','empresa','igv','sub_total','banco'));
        }
        
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
        $notas_debito=Nota_Debito::where('id',$id)->first();
        $notas_debito_registros=Nota_Debito_registro::where('nota_debito_id',$id)->get();

        $empresa=Empresa::first();

        if($notas_debito->boleta_id==NULL){
            $estado=0;
        }else{
            $estado=1;
        }

        if($notas_debito->tipo=="producto"){
            return view('transaccion.venta.nota_debito.show',compact('notas_debito','notas_debito_registros','empresa','estado'));
        }else{
            return view('transaccion.venta.nota_debito.show_servicio',compact('notas_debito','notas_debito_registros','empresa','estado'));
        }
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
