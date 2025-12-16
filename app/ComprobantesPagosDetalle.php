<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComprobantesPagosDetalle extends Model
{
    protected $table = 'comprobantes_pagos_detalles';

    public function comprobante_pago()
    {
        return $this->belongsTo(ComprobantesPagos::class, 'comprobante_pago_id');
    }

    public function comprobante_pago_registros()
    {
        return $this->belongsTo(ComprobantesPagosRegistros::class, 'comprobante_pago_reg_id');
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id');
    }

    public function getFormaPagoAttribute()
    {
        if ($this->monto == $this->monto_pago) {
            return "Pagado";
        } else {
            return "Adelantado";
        }
    }

    public function getMontoPagadoPagadoAttribute()
    {
        return 200; 
        // if( ){

        // }
    }

    // public function getPrecioPrincipalAttribute()
    // {

    //     $cuota = $this->comprobante_pago_registros->cuota_credito;
    //     // dd($cuota);

    //     $moneda_pago = $this->moneda->simbolo ?? $cuota->moneda_comprobante;

    //     if ($this->moneda->simbolo == $cuota->moneda_comprobante) { //Si son monedas iguales
    //         $precio = $this->montos_input;
    //     } else {
    //         if ($this->moneda->id == 1) { //Si es sol
    //             $moneda = Moneda::where('id', $this->moneda->id)->first();
    //             $moneda_pago = $moneda->simbolo;
    //             $precio = $this->montos_input / $this->tipo_cambio;
    //         } else {
    //             $moneda = Moneda::where('id', '!=', $this->moneda->id)->first();
    //             $moneda_pago = $moneda->simbolo;
    //             $precio = $this->montos_input * $this->tipo_cambio;
    //         }
    //     }
    //     // $precio = $this->montos_input;
    //     $precio_principal = $moneda_pago . ' ' . number_format(round($precio, 2), 2) ?? 0.00;


    //     return $precio_principal;
    // }

    // public function getPrecioSecundarioAttribute()
    // {
    //     $cuota = $this->comprobante_pago_registros->cuota_credito;



    //     if ($this->moneda->simbolo == $cuota->moneda_comprobante) { //Si son monedas iguales
    //         $precio = $this->montos_input;
    //         $moneda_pago = $this->moneda->simbolo ?? $cuota->moneda_comprobante;
    //     } else {

    //         if ($this->moneda->id == 1) { //Si es sol
    //             $moneda = Moneda::where('id', $this->moneda->id)->first();
    //             $moneda_pago = $moneda->simbolo;
    //             $precio = $this->montos_input * $this->tipo_cambio;
    //         } else {
    //             $moneda = Moneda::where('id', '!=', $this->moneda->id)->first();
    //             $moneda_pago = $moneda->simbolo;
    //             $precio = $this->montos_input / $this->tipo_cambio;
    //         }
    //     }
    //     // $precio = $this->montos_input;
    //     $precio_secundario = $moneda_pago . ' ' . number_format(round($precio, 2), 2) ?? 0.00;


    //     return $precio_secundario;
    // }
}
