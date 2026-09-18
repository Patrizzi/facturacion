<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturacion_registro extends Model
{
    protected $table = 'facturacion_registro';

    protected $guarded = [];

    protected $with = ['producto'];

    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }

    public function servicio(){
        return $this->belongsTo(Servicios::class,'servicio_id');
    }

    public function factura_ids(){
        return $this->belongsTo(Facturacion::class,'facturacion_id');
    }

    public function getArticuloDescripcionAttribute(){
        if (!empty($this->attributes['producto_id'])) {
            return optional($this->producto)->nombre . ' ' . $this->attributes['descripcion_item'];
        } else {
            return optional($this->servicio)->nombre . ' ' . $this->attributes['descripcion_item'];
        }
    }
}
