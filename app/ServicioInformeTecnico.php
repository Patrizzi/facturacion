<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioInformeTecnico extends Model
{
    protected $table = 's_informe_tecnico';

    protected $fillable = [
        's_egreso_id',
        'fecha'
    ];
}
