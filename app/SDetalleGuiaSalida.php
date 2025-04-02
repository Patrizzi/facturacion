<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SDetalleGuiaSalida extends Model
{
    protected $table = 's_detalle_guia_salida';

    protected $fillable = [
        's_g_salida_id',
        's_d_g_ingreso_id',
        'diagnostico',
        'estado_os',
        'estado_reparacion',
        'user_id',
        'fecha_inicio',
        'fecha_fin',
        'descripcion_os'
    ];

    public function servicio_guia_salida() {
        return $this->belongsTo(ServicioGuiaSalida::class, 's_g_salida_id', 'id');
    }

    public function imagen_producto() {
        return $this->hasMany(SImagenProducto::class, 's_d_g_salida_id', 'id');
    }

    public function s_detalle_guia_ingreso() {
        return $this->belongsTo(SDetalleGuiaIngreso::class, 's_d_g_ingreso_id', 'id');
    }

    public function s_tecnico() {
        return $this->belongsTo(user::class, 's_d_g_ingreso_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tecnico() {
        return $this->hasOneThrough(
            Personal::class,User::class, 'id', 'id', 'user_id', 'personal_id'
        );
    }

    public function detalle_guia_ingreso() {
        return $this->belongsTo(SDetalleGuiaIngreso::class, 's_d_g_ingreso_id', 'id');
    }
}
