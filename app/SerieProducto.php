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
        if (class_exists(Lote::class)) {
            return $this->belongsTo(Lote::class, 'lote_id');
        }

        return $this->belongsTo(Producto::class, 'producto_id')->whereRaw('1 = 0');
    }

    public function estadoProducto()
    {
        return $this->belongsTo(EstadoProducto::class, 'estado_id');
    }

    public function facturacionRegistro()
    {
        return $this->hasOne(Facturacion_registro::class, 'serie_id');
    }

    public function boletaRegistro()
    {
        return $this->hasOne(Boleta_registro::class, 'serie_id');
    }

    public function boletaRegistroAgrupado()
    {
        return $this->hasOneThrough(
            Boleta_registro::class,
            BoletaRegistroSerie::class,
            'serie_id',
            'id',
            'id',
            'boleta_registro_id'
        )->orderByDesc('boleta_registro.id');
    }

    public function getDetalleBoletaAttribute(): ?Boleta_registro
    {
        return $this->boletaRegistroAgrupado ?? $this->boletaRegistro;
    }

    public function notaVentaRegistro()
    {
        return $this->hasOne(NotaVentaRegistro::class, 'serie_id');
    }
}
