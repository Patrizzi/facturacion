<?php

namespace App;

use CodGuiaAlmacenTable;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    protected $table = 'almacen';

	protected $guarded = [];
    
	public function personal(){
        return $this->belongsTo(Personal::class,'responsable');
    }
    
    public function cod_sunat(){
        return $this->hasOne(Codigo_guia_almacen::class, 'almacen_id', 'id');
    }
}
