<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioGuiaIngreso extends Model
{
    protected $table = 'servicio_g_ingresos';

    protected $fillable = [
        'servicio_guia_id',
        'nombre_equipo',
        'nro_serie',
        'fecha_agregada',
        'observacion',
        'estado'
    ];

    public function servicioGuia() {
        return $this->belongsTo(ServicioGuia::class, 'servicio_guia_id', 'id');
    }

    public function servicioGuiaEgreso() {
        return $this->hasMany(ServicioGuiaEgreso::class, 'servicio_g_ingreso_id', 'id');
    }

}
