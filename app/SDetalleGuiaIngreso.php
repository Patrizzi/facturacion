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
        'observacion',
        'cotizado'
    ];

    public function servicio_guia_ingreso() {
        return $this->belongsTo(ServicioGuiaIngreso::class, 's_g_ingreso_id', 'id');
    }

    public function s_detalle_guia_salida() {
        return $this->belongsTo(SDetalleGuiaSalida::class, 's_d_g_ingreso_id', 'id');
    }
}
