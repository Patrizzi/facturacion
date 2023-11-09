<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuotas_credito extends Model
{
    protected $table = 'cuotas_creditos';

    protected $guarded = [];

    public function factura_ids(){
        return $this->belongsTo(Facturacion::class,'facturacion_id');
    }
    public function factura_m_ids(){
        return $this->belongsTo(Facturacion_m::class,'facturacion_m_id');
    }
    public function boleta_ids(){
        return $this->belongsTo(Boleta::class,'boleta_id');
    }
    public function boleta_m_ids(){
        return $this->belongsTo(Boleta_m::class,'boleta_m_id');
    }
}
