<?php

namespace App\Http\Controllers;
use App\Renovacion;
use Illuminate\Http\Request;
use App\ComprobantesVentas;
use Carbon\Carbon;

use App\RenovacionVentas;
use App\Almacen;
class RenovacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


public function index()
{
    $mes_año = Carbon::now()->format('d-m-Y');
    $count_month_ventas = ComprobantesVentas::count_month_ventas($mes_año);
    $almacen = Almacen::get(); // Si lo necesitas
    $count_all_ventas = ComprobantesVentas::count_day_ventas();

    return view('transaccion.venta.renovacion.index', compact('count_month_ventas', 'almacen', 'count_all_ventas'));
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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