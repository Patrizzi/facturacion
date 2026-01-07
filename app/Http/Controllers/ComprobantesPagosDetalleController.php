<?php

namespace App\Http\Controllers;

use App\ComprobantesPagosDetalle;
use Carbon\Carbon;
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
        $detalle = ComprobantesPagosDetalle::with([
            'comprobante_pago.facturacion',
            'comprobante_pago.facturacionM',
            'comprobante_pago.boleta',
            'comprobante_pago.boletaM',
            'comprobante_pago.notaVenta',
            'comprobante_pago_registros.cuota_credito',
            'comprobante_pago_registros',
            'moneda',
        ])->findOrFail($id_detalle);
        $detalle->monto_pagado_format = $detalle->calcularMontoPagadoFormat();

        // Ventana de tiempo ±2 segundos
        $from = Carbon::parse($detalle->created_at)->subSeconds(2);
        $to   = Carbon::parse($detalle->created_at)->addSeconds(2);

        $otros_registros = ComprobantesPagosDetalle::with([
            'comprobante_pago.facturacion',
            'comprobante_pago.facturacionM',
            'comprobante_pago.boleta',
            'comprobante_pago.boletaM',
            'comprobante_pago.notaVenta',
            'comprobante_pago_registros.cuota_credito',
            'comprobante_pago_registros',
            'moneda',
        ])->where('id', '!=', $detalle->id)
            ->whereBetween('created_at', [$from, $to])
            ->get();
        if ($otros_registros && $otros_registros->isNotEmpty()) {
            $otros_registros->each(function ($item) {
                $item->monto_pagado_format = $item->calcularMontoPagadoFormat();
            });
        }

        if ($otros_registros->isEmpty()) {
            $otros_registros = null;
        }
        // dd($otros_registros);

        return response()->json([
            'detalle' => $detalle,
            'otros'   => $otros_registros
        ]);
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
