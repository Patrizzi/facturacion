<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioGuiaIngreso extends Model
{
    protected $table = 's_guia_ingreso';

    protected $fillable = [
        's_guia_id'
    ];

    // public function servicio_guia() {
    //     return $this->belongsTo(ServicioGuia::class, 's_guia_id', 'id');
    // }
    public function servicio_guia() {
        return $this->belongsTo(ServicioGuia::class, 's_guia_id', 'id');
    }
    

    public function detalle_guia_ingreso() {
        return $this->hasMany(SDetalleGuiaIngreso::class, 's_g_ingreso_id', 'id');
    }


}
