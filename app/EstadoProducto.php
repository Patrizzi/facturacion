<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoProducto extends Model
{
    protected $table = 'estados_productos';

    protected $fillable = [
        'nombre_estado',
        'ubicacion',
        'calidad',
    ];

    public function seriesProductos()
    {
        return $this->hasMany(SerieProducto::class, 'estado_id');
    }
}