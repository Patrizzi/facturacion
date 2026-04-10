<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RenovacionVentas extends Model
{
    protected $table = 'renovacion_ventas';

    public $timestamps = true;

    protected $fillable = [
        'cotizacion_id',
        'cotizacion_manual_id',
        'fecha_inicio',
        'fecha_vencimiento',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio'      => 'date',
        'fecha_vencimiento' => 'date',
        'estado'            => 'boolean',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime'
    ];

    // ─── Relaciones ───────────────────────────────────────────
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id', 'id');
    }

    public function cotizacionManual()
    {
        return $this->belongsTo(CotizacionManual::class, 'cotizacion_manual_id', 'id');
    }

    public function scopeActivas($query)
    {
        return $query->where('estado', 1);
    }

    public function scopeInactivas($query)
    {
        return $query->where('estado', 0);
    }

    public function getEstadoTextoAttribute()
    {
        return $this->estado ? 'Activo' : 'Inactivo';
    }

    public function getDiasRestantesAttribute()
    {
        return Carbon::now()->startOfDay()->diffInDays($this->fecha_vencimiento, false);
    }

    public function estaProximaVencer($dias = 7)
    {
        $restantes = $this->dias_restantes;
        return $restantes >= 0 && $restantes <= $dias;
    }

    public function estaVencida()
    {
        return $this->dias_restantes < 0;
    }

    public static function total_sum_datatable($request, $startDate, $endDate)
    {
        $igv    = Igv::first()->renta;
        $filter = $request->get('value');
        $tipo   = $request->tipo_renovacion;

        $query = self::with([
                'cotizacionManual.cliente',
                'cotizacionManual.moneda',
                'cotizacionManual.forma_pago',
                'cotizacion.cliente',
                'cotizacion.moneda',
                'cotizacion.forma_pago'
            ])
            ->where(function ($q) {
                $q->whereHas('cotizacionManual')
                  ->orWhereHas('cotizacion');
            })
            ->whereBetween('renovacion_ventas.created_at', [$startDate, $endDate]);

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('renovacion_ventas.id', 'like', '%' . $filter . '%')
                  ->orWhereHas('cotizacionManual', fn($q2) => $q2->where('cod_cotizacion', 'like', '%' . $filter . '%'))
                  ->orWhereHas('cotizacionManual.cliente', fn($q2) => $q2->where('nombre', 'like', '%' . $filter . '%')->orWhere('numero_documento', 'like', '%' . $filter . '%'))
                  ->orWhereHas('cotizacionManual.forma_pago', fn($q2) => $q2->where('nombre', 'like', '%' . $filter . '%'))
                  ->orWhereHas('cotizacion', fn($q2) => $q2->where('cod_cotizacion', 'like', '%' . $filter . '%'))
                  ->orWhereHas('cotizacion.cliente', fn($q2) => $q2->where('nombre', 'like', '%' . $filter . '%')->orWhere('numero_documento', 'like', '%' . $filter . '%'))
                  ->orWhereHas('cotizacion.forma_pago', fn($q2) => $q2->where('nombre', 'like', '%' . $filter . '%'));
            });
        }

        if ($tipo !== null && $tipo !== '') {
            $query->where(function ($q) use ($tipo) {
                $q->whereHas('cotizacionManual', fn($q2) => $q2->where('tipo', $tipo))
                  ->orWhereHas('cotizacion', fn($q2) => $q2->where('tipo', $tipo));
            });
        }

        $renovaciones = $query->get();
        $total = 0;

        foreach ($renovaciones as $renovacion) {
            $cotizacion = $renovacion->cotizacion ?? $renovacion->cotizacionManual;
            if ($cotizacion) {
                $subtotal          = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
                $total_cotizacion  = round($subtotal + ($cotizacion->op_gravada * $igv) / 100, 2);
                $total            += Ventas_registro::moneda_principal_convert($cotizacion->moneda_id, $total_cotizacion);
            }
        }

        return $total;
    }

    public static function count_mes($mes_año)
    {
        $fecha = Carbon::createFromFormat('d-m-Y', $mes_año);
        $mes   = $fecha->format('m');
        $año   = $fecha->format('Y');
        $igv   = \App\Igv::first()->renta ?? 18;

        $renovaciones = self::whereMonth('created_at', $mes)
                            ->whereYear('created_at', $año)
                            ->with(['cotizacionManual', 'cotizacion'])
                            ->get();

        $total = 0;

        foreach ($renovaciones as $renovacion) {
            $cotizacion = $renovacion->cotizacion ?? $renovacion->cotizacionManual;
            if ($cotizacion) {
                $subtotal         = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
                $total_cotizacion = round($subtotal + ($cotizacion->op_gravada * $igv) / 100, 2);
                $total           += \App\Ventas_registro::moneda_principal_convert($cotizacion->moneda_id, $total_cotizacion);
            }
        }

        return [
            'cantidad' => $renovaciones->count(),
            'total'    => 'S/ ' . number_format($total, 2)
        ];
    }
}