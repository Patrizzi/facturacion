<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SDetalleGuiaSalida extends Model
{
    protected $table = 's_detalle_guia_salida';

    protected $fillable = [
        's_g_salida_id',
        'recomendaciones',
        'aprobado',
        'estado',
        'user_id'
    ];

    public function servicio_guia_salida() {
        return $this->belongsTo(ServicioGuiaSalida::class, 's_g_salida_id', 'id');
    }

    public function imagen_producto() {
        return $this->hasMany(SImagenProducto::class, 's_d_g_salida_id', 'id');
    }
}
