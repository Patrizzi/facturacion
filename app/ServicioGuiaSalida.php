<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioGuiaSalida extends Model
{
    protected $table = 's_guia_salida';
    protected $fillable = [
        's_g_ingreso_id'
    ];
}
