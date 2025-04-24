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
        'orden_s_creado',
        'cotizado',
        'fecha'
    ];

    public function cliente() {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    // public function servicio_guia_ingreso() {
    //     return $this->belongsTo(ServicioGuiaIngreso::class, 's_guia_id', 'id');
    // }
    public function servicio_guia_ingreso() {
        return $this->hasOne(ServicioGuiaIngreso::class, 's_guia_id', 'id');
    }

    public function servicio_guia_salida() {
        return $this->hasOne(ServicioGuiaSalida::class, 's_guia_id', 'id');
    }

    public function cotizacion_manual() {
        return $this->hasOne(CotizacionManual::class, 'guia_id');
    }

}
