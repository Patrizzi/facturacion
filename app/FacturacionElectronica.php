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
        $f_last_update = Facturacion::where('f_electronica', "!=", 0)->latest()->first();

        $factura_m = Facturacion_m::whereYear('updated_at', $year)->whereMonth('updated_at', $month)->count();
        $fm_last_update = Facturacion_m::where('f_electronica', "!=", 0)->latest()->first();

        $detracciones = Detracciones::whereYear('updated_at', $year)->whereMonth('updated_at', $month)->count();
        $d_last_update = Detracciones::whereHas('factura', function ($query) {
            $query->whereNotNull('factura_id')
                ->orWhereNotNull('factura_m_id');
            })
            ->latest()
            ->first();

        $data = [
            'facturas' => $facturas,
            'factura_last_update' => Carbon::parse($f_last_update->updated_at)->diffForHumans(),
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

        $boleta = Boleta::whereYear('updated_at', $year)->whereMonth('updated_at', $month)->count();
        $b_last_update = Boleta::where('b_electronica', "!=", 0)->latest()->first();

        $boleta_m = Boleta_m::whereYear('updated_at', $year)->whereMonth('updated_at', $month)->count();
        $bm_last_update = Boleta_m::where('b_electronica', "!=", 0)->latest()->first();
        $data = [
            'boleta' => $boleta,
            'boleta_last_update' => Carbon::parse($b_last_update->updated_at)->diffForHumans(),
            'boleta_m' => $boleta_m,
            'boleta_m_last_update' => Carbon::parse($bm_last_update->updated_at)->diffForHumans()

        ];

        return $data;
    }

    public static function resumen_guias(){
        $fecha = Carbon::now()->format('d-m-Y');
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha

        $remision = Guia_remision::whereYear('updated_at', $year)->whereMonth('updated_at', $month)->count();
        $gr_last_update = Guia_remision::where('g_electronica', "!=", 0)->latest()->first();

        
        $remision_m = GuiaRemisionManual::whereYear('updated_at', $year)->whereMonth('updated_at', $month)->count();
        $grm_last_update = GuiaRemisionManual::where('g_electronica', "!=", 0)->latest()->first();

        $data = [
            'remision' => $remision,
            'remision_last_update' => Carbon::parse($gr_last_update->updated_at)->diffForHumans(),
            'remision_m' => $remision_m,
            'remision_m_last_update' => Carbon::parse($grm_last_update->updated_at)->diffForHumans()

        ];

        return $data;
    }

}
