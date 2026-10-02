<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReclamoGarantia extends Model
{
    protected $table = 'reclamos_garantia';

    protected $fillable = [
        'serie_id',
        'cliente_id',
        'descripcion_falla',
        'estado',
    ];

    protected $casts = [];

    public function serie(): BelongsTo
    {
        return $this->belongsTo(SerieProducto::class, 'serie_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function archivosEvidencia(): HasMany
    {
        return $this->hasMany(ArchivoEvidenciaGarantia::class, 'reclamo_garantia_id');
    }

    public function ordenServicio(): HasOne
    {
        return $this->hasOne(OrdenServicio::class, 'reclamo_garantia_id');
    }

    public function garantiaProveedor(): HasOne
    {
        return $this->hasOne(GarantiaProveedor::class, 'reclamo_garantia_id');
    }
}