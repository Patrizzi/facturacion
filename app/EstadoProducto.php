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

    public static function enStock(): self
    {
        return static::firstOrCreate(['nombre_estado' => 'En Stock'], ['calidad' => 'A']);
    }

    public static function vendido(): self
    {
        return static::firstOrCreate(['nombre_estado' => 'Vendido']);
    }

    public function seriesProductos()
    {
        return $this->hasMany(SerieProducto::class, 'estado_id');
    }
}