<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioInformeTecnico extends Model
{
    protected $table = 's_informe_tecnico';

    protected $fillable = [
        's_salida_id',
        'fecha'
    ];

    public function servicio_guia_salida() {
        return $this->belongsTo(ServicioGuiaSalida::class, 's_salida_id', 'id');
    }
}
