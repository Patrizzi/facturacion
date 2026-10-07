<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GarantiaProveedor extends Model
{
    protected $table = 'garantias_proveedor';

    protected $fillable = [
        'reclamo_garantia_id',
        'proveedor_id',
        'estado_solicitud',
        'resolucion',
    ];

    protected $casts = [];

    public function reclamoGarantia(): BelongsTo
    {
        return $this->belongsTo(ReclamoGarantia::class, 'reclamo_garantia_id');
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Provedor::class, 'proveedor_id');
    }
}