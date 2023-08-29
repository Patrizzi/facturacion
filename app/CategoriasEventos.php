<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriasEventos extends Model
{
    public function user(){
        return $this->belongsTo(User::class,'user_create_id');
    } 
}
