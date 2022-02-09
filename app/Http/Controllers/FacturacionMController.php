<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facturacion_m;
use App\Forma_pago;
use App\Cliente;
use App\Personal;
use App\Personal_venta;
use App\Igv;
use App\Producto;
use App\Servicios;
use App\Almacen;
use App\TipoCambio;
use App\Moneda;
use App\Empresa;
use App\Tipo_operacion_f;

class FacturacionMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facturacion=Facturacion_m::all();
        return view('transaccion.venta.facturacion.facturacion_manual.index', compact('facturacion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        // Forma de pago
        $forma_pagos=Forma_pago::all();

        // Cliente
        $clientes=Cliente::where('documento_identificacion','ruc')->get();

        // Personal
        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();

        // Igv
        $igv=Igv::first();

        // Categoria
        $categoria='producto';
        
        // Productos
        $productos=Producto::where('estado_anular',1)->get();

        // Sucursal
        $sucursal=1;
        $sucursal=Almacen::where('id',$sucursal)->first();

        // Servicios
        $servicios=Servicios::where('estado_anular',0)->get();

        if(count($servicios) == 0){
            return redirect()->route('servicios.index');
        }
        if(count($servicios) == 0){
            return back()->withErrors(['No hay Servicios Agregados: '.$sucursal->nombre.'']);
        }

        $servicios=Servicios::where('estado_anular',1)->get();

        // Tipo de cambio
        $tipo_cambio=TipoCambio::latest('created_at')->first();

        // Moneda
        $moneda=Moneda::get();

        // Número de factura
        $factura_numero="FA01-000001";

        // Empresa
        $empresa=Empresa::first();

        // Tipo de operación
        $tipo_operacion = Tipo_operacion_f::all();

        return view('transaccion.venta.facturacion.facturacion_manual.create',compact('productos','servicios','forma_pagos','clientes','personales','igv','moneda','p_venta','empresa','categoria','factura_numero','empresa','tipo_operacion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd("store");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd("show");
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
