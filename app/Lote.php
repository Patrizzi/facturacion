<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Lote extends Model
{
    protected $table = 'lotes';

    protected $guarded = [];

    protected $casts = [
        'fecha_produccion' => 'date',
        'fecha_vencimiento' => 'date',
        'cantidad' => 'integer',
        'cantidad_disponible' => 'integer',
        'costo_individual' => 'float',
    ];

    /**
     * Relación con el Producto al que pertenece el lote.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    /**
     * Relación con el Almacén donde se encuentra el lote.
     */
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    /**
     * Relación con el Proveedor que suministró el lote.
     */
    public function proveedor()
    {
        return $this->belongsTo(Provedor::class, 'proveedor_id');
    }

    /**
     * Relación con las series individuales asociadas al lote.
     */
    public function series()
    {
        return $this->hasMany(SerieProducto::class, 'lote_id');
    }

    /**
     * Relación con el registro de entrada en Kardex que originó el lote.
     */
    public function kardexEntradaRegistro()
    {
        return $this->belongsTo(kardex_entrada_registro::class, 'kardex_entrada_registro_id');
    }

    /**
     * Scope para consultar Lotes Activos (vigentes o sin fecha de vencimiento y con stock disponible).
     */
    public function scopeActivos($query)
    {
        $hoy = Carbon::today()->toDateString();
        return $query->where('cantidad_disponible', '>', 0)
                     ->where(function ($q) use ($hoy) {
                         $q->whereNull('fecha_vencimiento')
                           ->orWhere('fecha_vencimiento', '>=', $hoy);
                     });
    }

    /**
     * Scope para consultar Lotes Vencidos (que superaron la fecha de caducidad).
     */
    public function scopeVencidos($query)
    {
        $hoy = Carbon::today()->toDateString();
        return $query->whereNotNull('fecha_vencimiento')
                     ->where('fecha_vencimiento', '<', $hoy);
    }

    /**
     * Actualiza automáticamente el estado del lote en función de su fecha de vencimiento y existencias.
     */
    public function recalcularEstado()
    {
        $hoy = Carbon::today()->toDateString();

        if ($this->fecha_vencimiento && Carbon::parse($this->fecha_vencimiento)->toDateString() < $hoy) {
            $this->estado = 'Vencido';
        } elseif ($this->cantidad_disponible <= 0) {
            $this->estado = 'Terminado';
        } elseif ($this->cantidad_disponible < $this->cantidad) {
            $this->estado = 'En Proceso';
        } else {
            $this->estado = 'Completo';
        }

        $this->save();
        return $this;
    }
}
