<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComprobantesPagosDetalle extends Model
{
    protected $table = 'comprobantes_pagos_detalles';

    public function comprobante_pago(){
        return $this->belongsTo(ComprobantesPagos::class,'comprobante_pago_id');
    }
}
