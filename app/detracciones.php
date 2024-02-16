<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detracciones extends Model
{
    public function tipo_detraccion(){
        return $this->belongsTo(TipoDetraccion::class,'id_cod_tipo_detraccion');
    }
    public function medio_pago(){
        return $this->belongsTo(MedioPagoDetraccion::class,'id_cod_medio_pago');
    }
}
