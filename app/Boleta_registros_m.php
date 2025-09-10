<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boleta_registros_m extends Model
{
    protected $table='boleta_registros_m';

    protected $guarded=[];

    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }
    public function servicio(){
        return $this->belongsTo(Servicios::class,'servicio_id');
    }
    public function boleta_i(){
        return $this->belongsTo(Boleta_m::class, 'boleta_m_id');
    }

    public function getArticuloDescripcionAttribute(){
        if (!empty($this->attributes['producto_id'])) {
            return optional($this->producto)->nombre . ' ' . $this->descripcion;
        } else {
            return optional($this->servicio)->nombre . ' ' . $this->descripcion;
        }
    }
}
