<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class guia_r_traslado_registro extends Model
{
    protected $table = 'guia_r_traslado_registros';
    protected $guarded = [];

    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }
}
