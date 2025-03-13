<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioGuiaSalida extends Model
{
    protected $table = 's_guia_salida';
    protected $fillable = [
        's_g_ingreso_id'
    ];


    public function servicio_guia_ingreso() {
        return $this->belongsTo(ServicioGuiaIngreso::class, 's_g_ingreso_id', 'id');
    }

    public function detalle_guia_salida() {
        return $this->hasMany(SDetalleGuiaSalida::class, 's_g_salida_id', 'id');
    }

    public function informe_tecnico() {
        return $this->hasMany(ServicioInformeTecnico::class, 's_g_salida_id', 'id');
    }
}
