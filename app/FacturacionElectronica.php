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
        $factura_m = Facturacion_m::whereYear('updated_at', $year)->whereMonth('updated_at', $month)->count();
        $detracciones = Detracciones::whereYear('updated_at', $year)->whereMonth('updated_at', $month)->count();

        $f_last_update = Facturacion::where('f_electronica', "!=", 0)->latest()->first();
        $fm_last_update = Facturacion_m::where('f_electronica', "!=", 0)->latest()->first();
        $d_last_update = Detracciones::whereHas('factura', function ($query) {
            $query->whereNotNull('factura_id')
                ->orWhereNotNull('factura_m_id');
            })
            ->latest()
            ->first();

        $factura_last_update = optional($f_last_update)->updated_at ? $f_last_update->updated_at->diffForHumans() : "hace 0 segundos";
        $factura_m_last_update = optional($fm_last_update)->updated_at ? $fm_last_update->updated_at->diffForHumans() : "hace 0 segundos";
        $d_last_update = optional($d_last_update)->updated_at ? $d_last_update->updated_at->diffForHumans() : "hace 0 segundos";
            
        $data = [
            'facturas' => $facturas,
            'factura_last_update' => $factura_last_update,
            'factura_m' => $factura_m,
            'factura_m_last_update' => $factura_m_last_update,
            'detracciones' => $detracciones,
            'd_last_update' => $d_last_update

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
        $boleta_m = Boleta_m::whereYear('updated_at', $year)->whereMonth('updated_at', $month)->count();

        $b_last_update = Boleta::where('b_electronica', "!=", 0)->latest()->first();
        $bm_last_update = Boleta_m::where('b_electronica', "!=", 0)->latest()->first();

        $boleta_last_update = optional($b_last_update)->updated_at ? $b_last_update->updated_at->diffForHumans() : "hace 0 segundos";
        $boleta_m_last_update = optional($bm_last_update)->updated_at ? $bm_last_update->updated_at->diffForHumans() : "hace 0 segundos";

        $data = [
            'boleta' => $boleta,
            'boleta_last_update' => $boleta_last_update,
            'boleta_m' => $boleta_m,
            'boleta_m_last_update' => $boleta_m_last_update

        ];

        return $data;
    }

    public static function resumen_guias(){
        $fecha = Carbon::now()->format('d-m-Y');
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha

        $remision = Guia_remision::whereYear('updated_at', $year)->whereMonth('updated_at', $month)->count();
        $remision_m = GuiaRemisionManual::whereYear('updated_at', $year)->whereMonth('updated_at', $month)->count();

        $gr_last_update = Guia_remision::where('g_electronica', "!=", 0)->latest()->first();
        $grm_last_update = GuiaRemisionManual::where('g_electronica', "!=", 0)->latest()->first();

        $remision_last_update = optional($gr_last_update)->updated_at ? $gr_last_update->updated_at->diffForHumans() : "hace 0 segundos";
        $remision_m_last_update = optional($grm_last_update)->updated_at ? $grm_last_update->updated_at->diffForHumans() : "hace 0 segundos";


        $data = [
            'remision' => $remision,
            'remision_last_update' => $remision_last_update,
            'remision_m' => $remision_m,
            'remision_m_last_update' => $remision_m_last_update

        ];

        return $data;
    }

}
