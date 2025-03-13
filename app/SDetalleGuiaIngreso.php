<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SDetalleGuiaIngreso extends Model
{
    protected $table = 's_detalle_guia_ingreso';

    protected $fillable = [
        's_g_ingreso_id',
        'producto',
        'serie',
        'observacion'
    ];

    public function servicio_guia_ingreso() {
        return $this->belongsTo(ServicioGuiaIngreso::class, 's_g_ingreso_id', 'id');
    }
}
