<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchivoEvidenciaGarantia extends Model
{
    protected $table = 'archivos_evidencia_garantia';

    protected $fillable = [
        'reclamo_garantia_id',
        'ruta_archivo',
        'tipo_archivo',
    ];

    protected $casts = [];

    public function reclamoGarantia(): BelongsTo
    {
        return $this->belongsTo(ReclamoGarantia::class, 'reclamo_garantia_id');
    }
}