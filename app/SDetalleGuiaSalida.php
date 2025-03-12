<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SDetalleGuiaSalida extends Model
{
    protected $table = 's_detalle_guia_salida';

    protected $fillable = [
        's_g_egreso_id',
        'recomendaciones',
        'aprobado',
        'estado',
        'user_id'
    ];
}
