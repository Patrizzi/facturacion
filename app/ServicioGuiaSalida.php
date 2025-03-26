<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioGuiaSalida extends Model
{
    protected $table = 's_guia_salida';
    protected $fillable = [
        's_guia_id'
    ];

    public function servicio_guia() {
        return $this->belongsTo(ServicioGuia::class, 's_guia_id', 'id');
    }

    public function detalle_guia_salida() {
        return $this->hasMany(SDetalleGuiaSalida::class, 's_g_salida_id')
            ->with(['detalle_guia_ingreso', 'servicio_guia_salida']);
    }


    public function informe_tecnico() {
        return $this->hasMany(ServicioInformeTecnico::class, 's_g_salida_id', 'id');
    }

}
