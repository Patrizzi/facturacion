<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioInformeTecnico extends Model
{
    protected $table = 'servicio_informe_tecnico';

    protected $fillable = [
        'servicio_g_id',
        'fecha_creacion'
    ];

    public function servicioGuia() {
        return $this->belongsTo(ServicioGuia::class, 'servicio_g_id', 'id');
    }
}
