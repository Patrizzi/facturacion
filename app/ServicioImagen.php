<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioImagen extends Model
{
    protected $table = 'servicio_imagenes';

    protected $fillable = [
        'imagen',
        'servicio_g_egreso_id'
    ];

    public function servicioGuiaEgreso() {
        return $this->belongsTo(ServicioGuiaEgreso::class, 'servicio_g_egreso_id', 'id');
    }
}
