<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComprobantesPagosRegistros extends Model
{
    public function comprobante_pago(){
        return $this->belongsTo(ComprobantesPagos::class,'comprobante_pago_id');
    }
    public function cuota_credito(){
        return $this->belongsTo(Cuotas_credito::class,'id_cuota_credito');
    }
}
