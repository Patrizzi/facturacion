<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SImagenProducto extends Model
{
    protected $table = 's_imagenes_producto';

    protected $fillable = [
        's_d_g_egreso_id',
        'foto',
        'descripcion'
    ];
}
