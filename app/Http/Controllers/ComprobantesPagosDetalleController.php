<?php

namespace App\Http\Controllers;

use App\ComprobantesPagosDetalle;
use Illuminate\Http\Request;

class ComprobantesPagosDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\ComprobantesPagosDetalle  $comprobantesPagosDetalle
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // En formarto json
        $id_detalle = $request->id_detalle;
        $detalle = ComprobantesPagosDetalle::find($id_detalle);

        return response()->json($detalle);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ComprobantesPagosDetalle  $comprobantesPagosDetalle
     * @return \Illuminate\Http\Response
     */
    public function edit(ComprobantesPagosDetalle $comprobantesPagosDetalle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ComprobantesPagosDetalle  $comprobantesPagosDetalle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ComprobantesPagosDetalle $comprobantesPagosDetalle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ComprobantesPagosDetalle  $comprobantesPagosDetalle
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComprobantesPagosDetalle $comprobantesPagosDetalle)
    {
        //
    }
}
