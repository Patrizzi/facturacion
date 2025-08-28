<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioGuiaEgreso extends Model
{
    protected $table = 'servicio_g_egresos';

    protected $fillable = [
        'servicio_g_ingreso_id',
        'fecha_inicio_reparacion',
        'diagnostico',
        'descripcion_os',
        'fecha_fin_reparacion',
        'estado',
        'user_id'
    ];

    public function servicioGuiaIngreso() {
        return $this->belongsTo(ServicioGuiaIngreso::class, 'servicio_g_ingreso_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function imagenes() {
        return $this->hasMany(ServicioImagen::class, 'servicio_g_egreso_id', 'id');
    }
}
