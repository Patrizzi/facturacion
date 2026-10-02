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
        'estado_id',
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

    public function estadoProducto()
    {
        return $this->belongsTo(EstadoProducto::class, 'estado_id');
    }

    public function garantias()
    {
        return $this->hasMany(GarantiaSerie::class, 'serie_id');
    }

    public function garantiaActual()
    {
        return $this->hasOne(GarantiaSerie::class, 'serie_id')
            ->where('estado_garantia', 'Vigente')
            ->orderBy('fecha_vencimiento', 'desc')
            ->orderBy('id', 'desc');
    }
}
