<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    public function clientes(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    } 
    public function category(){
        return $this->belongsTo(CategoriasEventos::class,'categori_id');
    } 
}
