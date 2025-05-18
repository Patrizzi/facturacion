<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subfamilia extends Model
{
   protected $fillable = [
        'id_familia', 'codigo', 'descripcion', 'ubicacion', 'estado'
    ];
}
