<?php

namespace App\Http\Controllers;
use App\Cliente;
use App\Empresa;
use App\NotaVenta;
use App\Personal;
use App\Almacen;
use App\Producto;
use App\Servicios;
use App\Moneda;
use App\Forma_pago;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NotaVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nota_venta=NotaVenta::all();
        $almacen =Almacen::all();
        $conteo_almacen=Almacen::where('estado',0)->count();
        $almacen_primero =Almacen::first();
        $user_login =auth()->user();
        return view('transaccion.venta.nota_venta.index',compact('nota_venta','conteo_almacen','almacen_primero','user_login','almacen'));

        // // REDIRECCION PARA MOSTRAR EL inventario_inicial
        // $existe_id=Kardex_entrada::where('estado',2)->first();
        // if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

        // $clientes=Cliente::all();
        // $moneda=Moneda::all();
        // $forma_pagos= Forma_pago::all();
        // $igv=Igv::first();
        // $servicios = Servicios::all();
        // $productos=Producto::all();

        // $empresa=Empresa::first();
        // return view('transaccion.venta.cotizacion.otros.create',compact('igv','empresa','clientes','forma_pagos','moneda','productos','servicios'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

       $sucursal_nr = str_pad(12, 3, "0", STR_PAD_LEFT);
       $correlativo=str_pad(12, 8, "0", STR_PAD_LEFT);
       $cod_nota_venta="NV ".$sucursal_nr."-".$correlativo;

       $clientes=Cliente::all();
       $moneda=Moneda::all();
       $forma_pagos= Forma_pago::all();
       $servicios = Servicios::all();
       $productos=Producto::all();
       $user_login =auth()->user();

       $empresa=Empresa::first();
       return view('transaccion.venta.nota_venta.create',compact('empresa','clientes','forma_pagos','moneda','productos','servicios','user_login','cod_nota_venta'));

   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return "Llegaste";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

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
