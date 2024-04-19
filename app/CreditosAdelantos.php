<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditosAdelantos extends Model
{
    protected $table = 'creditos_adelantos';

    protected $guarded = [];

    public function factura_ids(){
        return $this->belongsTo(Facturacion::class,'factura_id');
    }
    public function factura_m_ids(){
        return $this->belongsTo(Facturacion_m::class,'factura_m_id');
    }
    public function boleta_ids(){
        return $this->belongsTo(Boleta::class,'boleta_id');
    }
    public function boleta_m_ids(){
        return $this->belongsTo(Boleta_m::class,'boleta_m_id');
    }
    public function nota_venta_id(){
        return $this->belongsTo(NotaVenta::class,'nota_ven_id');
    }
}
