<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SerieProducto extends Model
{
    protected $table = 'series_productos';

    protected $fillable = [
        'numero_serie',
        'producto_id',
        'codigo_producto',
        'lote_id',
        'codigo_lote',
        'estado',
        'fecha_venta',
        'fecha_vencimiento_garantia',
        'ubicacion',
        'calidad',
        'fecha_ultimo_movimiento',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'lote_id');
    }
}
