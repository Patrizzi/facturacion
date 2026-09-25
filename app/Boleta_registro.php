<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boleta_registro extends Model
{
    protected $table='boleta_registro';

    protected $guarded=[];

    protected $with = ['producto'];

     public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }

    public function servicio(){
        return $this->belongsTo(Servicios::class,'servicio_id');
    }
    public function boleta_i(){
        return $this->belongsTo(Boleta::class,'boleta_id');
    }

    public function lote(){
        return $this->belongsTo(Lote::class,'lote_id');
    }

    public function getArticuloDescripcionAttribute(){
        if (!empty($this->attributes['producto_id'])) {
            return optional($this->producto)->nombre . ' ' . $this->attributes['descripcion_item'];
        } else {
            return optional($this->servicio)->nombre . ' ' . $this->attributes['descripcion_item'];
        }
    }
}
