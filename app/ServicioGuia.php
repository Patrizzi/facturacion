<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioGuia extends Model
{
    protected $table = 's_guias';

    protected $fillable = [
        'nro_guia',
        'cliente_id',
        'orden_servicio',
        'fecha'
    ];
}
