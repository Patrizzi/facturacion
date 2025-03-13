<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SImagenProducto extends Model
{
    protected $table = 's_imagenes_producto';

    protected $fillable = [
        's_d_g_salida_id',
        'foto',
        'descripcion'
    ];

    public function detalle_guia_salida() {
        return $this->belongsTo(SDetalleGuiaSalida::class, 's_d_g_salida_id', 'id');
    }
}
