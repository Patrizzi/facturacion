<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotaVentaRegistro extends Model
{
    protected $table = 'nota_venta_registro';

    protected $guarded = [];

    public function serie(): BelongsTo
    {
        return $this->belongsTo(SerieProducto::class, 'serie_id');
    }

}
