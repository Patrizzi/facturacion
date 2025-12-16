<?php

namespace App;

use App\Observers\CuotasCreditosObserver;
use Greenter\Model\Sale\Cuota;
use Illuminate\Database\Eloquent\Model;

class Cuotas_credito extends Model
{
    protected $table = 'cuotas_creditos';

    protected $guarded = [];

    public function factura_ids()
    {
        return $this->belongsTo(Facturacion::class, 'facturacion_id');
    }
    public function factura_m_ids()
    {
        return $this->belongsTo(Facturacion_m::class, 'facturacion_m_id');
    }
    public function boleta_ids()
    {
        return $this->belongsTo(Boleta::class, 'boleta_id');
    }
    public function boleta_m_ids()
    {
        return $this->belongsTo(Boleta_m::class, 'boleta_m_id');
    }

    // protected static function boot()
    // {
    //     parent::boot();
    //     Cuotas_credito::observe(new CuotasCreditosObserver());
    // }

    public static function monto_total_convertido_cuota($id_cuota, $moneda_id, $tipo_cambio)
    {
        $cuota = Cuotas_credito::find($id_cuota);
        $moneda_comprobante = Moneda::find($moneda_id);
        $monedas = Moneda::get();
        $monto = [];
        // return $monedas;
        foreach ($monedas as $moneda) {
            // Moneda igual → no convertir
            if ($moneda->id == $moneda_comprobante->id) {
                $monto["igual"] = $moneda->simbolo . " " . $cuota->monto;
                $monto["moneda_igual"] = $moneda->simbolo;
                $monto["igual_neto"] = round($cuota->monto, 2);
                // continue;
            } else {

                // Si comprobante NO está en soles → convertir a soles
                if ($moneda_comprobante->simbolo != "S/") {
                    $monto["diferente"] = $moneda->simbolo . " " . round($cuota->monto * $tipo_cambio, 2);
                    $monto["moneda_diff"] = $moneda->simbolo;
                    $monto["diferente_neto"] = round($cuota->monto * $tipo_cambio, 2);
                } else {
                    // Convertir a dólares
                    $monto["diferente"] = $moneda->simbolo . " " . round($cuota->monto / $tipo_cambio, 2);
                    $monto["moneda_diff"] = $moneda->simbolo;
                    $monto["diferente_neto"] = round($cuota->monto / $tipo_cambio, 2);
                }
            }
        }
        return $monto;
    }

    public static function monto_pagado_convertido_cuota($id_cuota, $moneda_pago, $tipo_cambio)
    {
        // // $cuota = Cuotas_credito::find($id_cuota);
        // $registros_cuotas = ComprobantesPagosRegistros::where('id_cuota_credito', $id_cuota)->get();
        // // $suma_cuotas = ComprobantesPagosRegistros::where('id_cuota_credito', $id_cuota)->sum('monto_pago');
        // $monedas = Moneda::get();
        // $moneda_comprobante = Moneda::find($moneda_id);
        // // El tipo de cambio lo saco desde el pago
        // $restante = [];
        // foreach ($registros_cuotas as $registros) {
        //     $detalles = ComprobantesPagosDetalle::where('comprobante_pago_reg_id', $registros->id)->first();
        //     // Comparativa de monedas con que se pagó, 
        //     $moneda_pago = $moneda_id;
        //     $tipo_cambio = $detalles->tipo_cambio ?? $tipo_cambio;
        //     foreach ($monedas as $moneda) {
        //         if ($moneda->id == $moneda_pago) { //Si es igual a la moneda pagada
        //             $restante["igual"] = $moneda->simbolo . " " . $registros->monto_pago;
        //             $restante["moneda_igual"] = $moneda->simbolo;
        //             $restante["igual_neto_2"] = round($registros->monto_pago, 2);
        //             // continue;
        //         } else {

        //             // Si comprobante NO está en soles → convertir a soles
        //             if ($moneda_comprobante->simbolo != "S/") {
        //                 $restante["diferente"] = $moneda->simbolo . " " . round($registros->monto_pago * $tipo_cambio, 2);
        //                 $restante["moneda_diff"] = $moneda->simbolo;
        //                 $restante["diferente_neto_2"] = round($registros->monto_pago * $tipo_cambio, 2);
        //             } else {
        //                 // Convertir a dólares
        //                 $restante["diferente"] = $moneda->simbolo . " " . round($registros->monto_pago / $tipo_cambio, 2);
        //                 $restante["moneda_diff"] = $moneda->simbolo;
        //                 $restante["diferente_neto_2"] = round($registros->monto_pago / $tipo_cambio, 2);
        //             }
        //         }
        //     }
        // }
        // 
        $detalles = ComprobantesPagosDetalle::whereIn(
            'comprobante_pago_reg_id',
            ComprobantesPagosRegistros::where('id_cuota_credito', $id_cuota)->select('id')
        )->get();
        $moneda_comprobante = Moneda::find($moneda_pago);
        $moneda_no_comprobante = Moneda::where('id', '!=',$moneda_comprobante->id)->first();
        $restante = [
            'prin' => 0,
            'sec' => 0,
            'simbolo' => '',
            'simbolo_2' => '',
        ];
        // dd($detalles);
        foreach ($detalles as $det) {
            $restante["simbolo"] = $moneda_comprobante->simbolo;
            $restante["simbolo_2"] = $moneda_no_comprobante->simbolo;
            // Si la moneda es igual al del comprobante
            if ($moneda_comprobante->id == $det->moneda_id) {
                $restante["prin"] += $det->comprobante_pago_registros->monto_pago;
            } else {
                if ($det->moneda->simbolo == "$") { //Si es dolar conversion de sol a dolar
                    $restante["sec"] += round($det->comprobante_pago_registros->monto_pago / $det->tipo_cambio, 2);
                } else {
                    $restante["sec"] += round($det->comprobante_pago_registros->monto_pago * $det->tipo_cambio, 2);
                }
            }
        }
        // Colocar el simbolo y formato
        $data = [
            "prin" => $restante["simbolo"] . ' ' . number_format($restante["prin"] ?? 0, 2),
            "sec" => $restante["simbolo_2"] . ' ' . number_format($restante["sec"] ?? 0, 2)
        ];

        return $data;
    }

    public static function restante_pago_convertido_cuota($monto_principal, $monto_secundario, $pagado_principal, $pagado_secundario, $moneda_principal, $moneda_secundaria)
    {
        $principal = $monto_principal - $pagado_principal ?? 0.00;
        $secundario = $monto_secundario - $pagado_secundario ?? 0.00;
        $restante['saldo_principal'] = $moneda_principal . ' ' . round($principal, 2);
        $restante['saldo_sec'] = $moneda_secundaria . ' ' . round($secundario, 2);
        // $comprobante->saldo_principal = $precios["igual_neto"] - ($pagado["igual_neto_2"] ?? 0.00);
        // dd( $comprobante->saldo_principal);
        // $comprobante->saldo_secundario =  $precios["diferente_neto"] - ($pagado["diferente_neto_2"]  ?? 0.00);
        return $restante;
    }

    public function getMonedaComprobanteAttribute()
    {
        if ($this->facturacion_id != null) {
            return $this->factura_ids->moneda->simbolo;
        }
        if ($this->boleta_id != null) {
            return $this->boleta_ids->moneda->simbolo;
        }
        if ($this->facturacion_m_id != null) {
            return $this->factura_m_ids->moneda->simbolo;
        }
        if ($this->boleta_m_id != null) {
            return $this->boleta_m_ids->moneda->simbolo;
        }
    }
    // public function 
}
