<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RenovacionVentas extends Model
{
    protected $table = 'renovacion_ventas';

    // Timestamps automáticos (created_at, updated_at)
    public $timestamps = true;

    protected $fillable = [
        'cotizacion_id',
        'cotizacion_manual_id',
        'frecuencia',
        'dia_anual',
        'dia_mensual',
        'mes_anual',
        'anio_anual',
        'estado'
    ];

    protected $casts = [
        'dia_mensual' => 'integer',
        'dia_anual' => 'integer',
        'mes_anual' => 'integer',
        'anio_anual' => 'integer',
        'estado' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relación con Cotizacion (cotizacion_id)
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id', 'id');
    }

    // Relación con CotizacionManual (cotizacion_manual_id)
    public function cotizacionManual()
    {
        return $this->belongsTo(CotizacionManual::class, 'cotizacion_manual_id', 'id');
    }


    // Scopes útiles
    public function scopeActivas($query)
    {
        return $query->where('estado', 1);
    }

    public function scopeInactivas($query)
    {
        return $query->where('estado', 0);
    }

    public function scopeMensual($query)
    {
        return $query->where('frecuencia', 'Mensual');
    }

    public function scopeAnual($query)
    {
        return $query->where('frecuencia', 'Anual');
    }

    // Accessor para obtener la frecuencia en español
    public function getFrecuenciaTextoAttribute()
    {
        return $this->frecuencia == 'Mensual' ? 'Mensual' : 'Anual';
    }

    // Accessor para obtener el estado en texto
    public function getEstadoTextoAttribute()
    {
        return $this->estado == 1 ? 'Activo' : 'Inactivo';
    }

    // Método para obtener la próxima fecha de renovación
    public function getProximaRenovacion()
    {
        // Determinar qué cotización usar
        $cotizacion = $this->cotizacion ?? $this->cotizacionManual;

        if (!$cotizacion) {
            return null;
        }

        $fecha_emision = Carbon::parse($cotizacion->fecha_emision);
        $fecha_actual = Carbon::now();

        if ($this->frecuencia == 'Mensual' && $this->dia_mensual) {
            $dias_acumulados = (int) $this->dia_mensual;
            $proximaFecha = $fecha_emision->copy()->addDays($dias_acumulados);

            // Seguir sumando hasta encontrar una fecha futura
            while ($proximaFecha->isPast()) {
                $proximaFecha->addDays($dias_acumulados);
            }

            return $proximaFecha;
        }

        if ($this->frecuencia == 'Anual' && $this->dia_anual && $this->mes_anual) {
            $dia_vencimiento = (int) $this->dia_anual;
            $mes_vencimiento = (int) $this->mes_anual;
            $anio_vencimiento = $this->anio_anual ?? $fecha_actual->year;

            try {
                $proximaFecha = Carbon::create($anio_vencimiento, $mes_vencimiento, $dia_vencimiento);
            } catch (\Exception $e) {
                $proximaFecha = Carbon::create($anio_vencimiento, $mes_vencimiento, 1)->endOfMonth();
            }

            // Si ya pasó, sumar un año
            if ($proximaFecha->isPast()) {
                $proximaFecha->addYear();
            }

            return $proximaFecha;
        }

        return null;
    }

    // Método para verificar si está próxima a vencer
    public function estaProximaVencer($dias = 7)
    {
        $proximaRenovacion = $this->getProximaRenovacion();

        if (!$proximaRenovacion) {
            return false;
        }

        $hoy = Carbon::now();
        $diferencia = $hoy->diffInDays($proximaRenovacion, false);

        return $diferencia >= 0 && $diferencia <= $dias;
    }

    public static function total_sum_datatable($request, $startDate, $endDate)
    {
        $igv = Igv::first()->renta;
        $filter = $request->get('value');
        $tipo = $request->tipo_renovacion;

        // ✅ MODIFICADO: Cargar AMBAS relaciones
        $query = self::with([
                'cotizacionManual.cliente',
                'cotizacionManual.moneda',
                'cotizacionManual.forma_pago',
                'cotizacion.cliente',
                'cotizacion.moneda',
                'cotizacion.forma_pago'
            ])
            ->where(function($q) {
                $q->whereHas('cotizacionManual')
                ->orWhereHas('cotizacion');
            })
            ->whereBetween('renovacion_ventas.created_at', [$startDate, $endDate]);

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('renovacion_ventas.id', 'like', '%' . $filter . '%');

                // Buscar en cotizaciones manuales
                $q->orWhereHas('cotizacionManual', function ($q2) use ($filter) {
                    $q2->where('cod_cotizacion', 'like', '%' . $filter . '%');
                });

                $q->orWhereHas('cotizacionManual.cliente', function ($q2) use ($filter) {
                    $q2->where('nombre', 'like', '%' . $filter . '%')
                    ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });

                $q->orWhereHas('cotizacionManual.forma_pago', function ($q2) use ($filter) {
                    $q2->where('nombre', 'like', '%' . $filter . '%');
                });

                // Buscar en cotizaciones normales
                $q->orWhereHas('cotizacion', function ($q2) use ($filter) {
                    $q2->where('cod_cotizacion', 'like', '%' . $filter . '%');
                });

                $q->orWhereHas('cotizacion.cliente', function ($q2) use ($filter) {
                    $q2->where('nombre', 'like', '%' . $filter . '%')
                    ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });

                $q->orWhereHas('cotizacion.forma_pago', function ($q2) use ($filter) {
                    $q2->where('nombre', 'like', '%' . $filter . '%');
                });
            });
        }

        if ($tipo !== null && $tipo !== '') {
            $query->where(function($q) use ($tipo) {
                $q->whereHas('cotizacionManual', function($q2) use ($tipo) {
                    $q2->where('tipo', $tipo);
                })
                ->orWhereHas('cotizacion', function($q2) use ($tipo) {
                    $q2->where('tipo', $tipo);
                });
            });
        }

        $renovaciones = $query->get();
        $total = 0;

        foreach ($renovaciones as $renovacion) {
            // ✅ MODIFICADO: Usar cotización normal O manual
            $cotizacion = $renovacion->cotizacion ?? $renovacion->cotizacionManual;

            if ($cotizacion) {
                $subtotal = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
                $total_cotizacion = round($subtotal + ($cotizacion->op_gravada * $igv) / 100, 2);
                $total += Ventas_registro::moneda_principal_convert($cotizacion->moneda_id, $total_cotizacion);
            }
        }

        return $total;
    }

    public static function count_mes($mes_año)
    {
        $fecha = Carbon::createFromFormat('d-m-Y', $mes_año);
        $mes = $fecha->format('m');
        $año = $fecha->format('Y');

        $igv = \App\Igv::first()->renta ?? 18;

        // ✅ MODIFICADO: Cargar AMBAS relaciones
        $renovaciones = self::whereMonth('created_at', $mes)
                            ->whereYear('created_at', $año)
                            ->with(['cotizacionManual', 'cotizacion'])
                            ->get();

        $total = 0;

        foreach ($renovaciones as $renovacion) {
            // ✅ MODIFICADO: Usar cotización normal O manual
            $cotizacion = $renovacion->cotizacion ?? $renovacion->cotizacionManual;

            if ($cotizacion) {
                $subtotal = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
                $total_cotizacion = round($subtotal + ($cotizacion->op_gravada * $igv) / 100, 2);
                $total += \App\Ventas_registro::moneda_principal_convert($cotizacion->moneda_id, $total_cotizacion);
            }
        }

        return [
            'cantidad' => $renovaciones->count(),
            'total' => 'S/ ' . number_format($total, 2)
        ];
    }
}
