<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GarantiaSerie extends Model
{
    protected $table = 'garantias';

    protected $fillable = [
        'serie_id',
        'estado_garantia',
        'fecha_venta',
        'fecha_vencimiento',
        'duracion_meses',
    ];

    protected $casts = [
        'fecha_venta' => 'date',
        'fecha_vencimiento' => 'date',
    ];

    public function serieProducto()
    {
        return $this->belongsTo(SerieProducto::class, 'serie_id');
    }
}