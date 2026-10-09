<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioGuia extends Model
{
    protected $table = 'servicio_guias';

    protected $fillable = [
        'nro_servicio_guia',
        'cliente_id',
        'orden_servicio',
        'fecha_creacion',
        'estado',
        'user_id',
        'enviado_almacen'
    ];

    public function cliente() {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function servicioGuiaIngreso() {
        return $this->hasMany(ServicioGuiaIngreso::class, 'servicio_guia_id', 'id');
    }

    public function cotizacion_m() {
        return $this->belongsTo(CotizacionManual::class, 'servicio_g_id', 'id');
    }

    public function servicioInformeTecnico() {
        return $this->hasMany(ServicioInformeTecnico::class, 'servicio_g_id', 'id');
    }
}
