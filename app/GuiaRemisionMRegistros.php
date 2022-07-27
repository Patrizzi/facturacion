<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuiaRemisionMRegistros extends Model
{
    protected $table = 'guia_remision_m_registros';

	protected $guarded = [];
    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }
}
