<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FacturacionElectronica extends Model
{
    public static function resumen_facturas()
    {
        $fecha = Carbon::now()->format('d-m-Y');
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha

        $facturas = Facturacion::whereYear('updated_at', $year)->whereMonth('updated_at', $month)->count();
        $f_last_updatre = Facturacion::where('f_electronica', " != ", 1)->latest()->first();

        $factura_m = Facturacion_m::whereYear('updated_at', $year)->whereMonth('updated_at', $month)->count();
        $fm_last_update = Facturacion_m::where('f_electronica', " != ", 1)->latest()->first();

        $detracciones = Detracciones::whereYear('updated_at', $year)->whereMonth('updated_at', $month)->count();
        $d_last_update = Detracciones::whereHas('factura', function ($query) {
            $query->whereNotNull('factura_id')
                ->orWhereNotNull('factura_m_id');
            })
            ->latest()
            ->first();

        $data = [
            'facturas' => $facturas,
            'factura_last_update' => Carbon::parse($f_last_updatre->updated_at)->diffForHumans(),
            'factura_m' => $factura_m,
            'factura_m_last_update' => Carbon::parse($fm_last_update->updated_at)->diffForHumans(),
            'detracciones' => $detracciones,
            'd_last_update' => Carbon::parse($d_last_update->updated_at)->diffForHumans()

        ];

        return $data;
    }

    public static function resumen_boletas()
    {
        $fecha = Carbon::now()->format('d-m-Y');
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha

        $facturas = Facturacion::whereYear('updated_at', $year)->whereMonth('updated_at', $month)->count();
        $f_last_updatre = Facturacion::where('f_electronica', " != ", 1)->latest()->first();

        $factura_m = Facturacion_m::whereYear('updated_at', $year)->whereMonth('updated_at', $month)->count();
        $fm_last_update = Facturacion_m::where('f_electronica', " != ", 1)->latest()->first();
        $data = [
            'facturas' => $facturas,
            'factura_last_update' => Carbon::parse($f_last_updatre->updated_at)->diffForHumans(),
            'factura_m' => $factura_m,
            'factura_m_last_update' => Carbon::parse($fm_last_update->updated_at)->diffForHumans()

        ];

        return $data;
    }

}
