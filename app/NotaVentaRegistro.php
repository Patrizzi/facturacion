<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotaVentaRegistro extends Model
{
    protected $table = 'nota_venta_registro';

    protected $guarded = [];

    public function notaVenta(): BelongsTo
    {
        return $this->belongsTo(NotaVenta::class, 'nota_venta_id');
    }

    public function lote(): BelongsTo
    {
        return $this->belongsTo(Lote::class, 'lote_id');
    }

    public function serie(): BelongsTo
    {
        return $this->belongsTo(SerieProducto::class, 'serie_id');
    }
}
