<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lotes';

    protected $fillable = [
        'codigo_lote',
        'proveedor_nombre',
        'cantidad',
        'fecha_produccion',
        'fecha_vencimiento',
        'estado',
    ];

    public function series()
    {
        return $this->hasMany(SerieProducto::class, 'lote_id');
    }
}
