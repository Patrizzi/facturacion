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
        'cotizacion_manual_id',
        'cotizacion_id',
        'frecuencia',
        'dia_mensual',
        'mes_anual',
        'anio_anual',
        'estado'
    ];

    protected $casts = [
        'dia_mensual' => 'integer',
        'mes_anual' => 'integer',
        'anio_anual' => 'integer',
        'estado' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relación con CotizacionManual (cotizacion_manual_id)
    public function cotizacionManual()
    {
        return $this->belongsTo(CotizacionManual::class, 'cotizacion_manual_id', 'id');
    }

    // Relación con Cotizacion (cotizacion_id)
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id', 'id');
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
        if ($this->frecuencia == 'Mensual' && $this->dia_mensual) {
            $hoy = Carbon::now();
            $proximaFecha = Carbon::create($hoy->year, $hoy->month, $this->dia_mensual);

            if ($proximaFecha->isPast()) {
                $proximaFecha->addMonth();
            }

            return $proximaFecha;
        }

        if ($this->frecuencia == 'Anual' && $this->mes_anual && $this->anio_anual) {
            return Carbon::create($this->anio_anual, $this->mes_anual, 1);
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

    $query = self::with(['cotizacionManual.cliente', 'cotizacionManual.moneda', 'cotizacionManual.forma_pago'])
        ->whereHas('cotizacionManual')
        ->whereBetween('renovaciones_servicios.created_at', [$startDate, $endDate]);

    if (!empty($filter)) {
        $query->where(function ($q) use ($filter) {
            $q->where('renovaciones_servicios.id', 'like', '%' . $filter . '%')
              ->orWhere('renovaciones_servicios.cotizacion_manual_id', 'like', '%' . $filter . '%');

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
        });
    }

    if ($tipo !== null && $tipo !== '') {
        $query->whereHas('cotizacionManual', function($q) use ($tipo) {
            $q->where('tipo', $tipo);
        });
    }

    $renovaciones = $query->get();
    $total = 0;

    foreach ($renovaciones as $renovacion) {
        $cotizacion_manual = $renovacion->cotizacionManual;

        if ($cotizacion_manual) {
            $subtotal = $cotizacion_manual->op_gravada + $cotizacion_manual->op_inafecta + $cotizacion_manual->op_exonerada;
            $total_cotizacion = round($subtotal + ($cotizacion_manual->op_gravada * $igv) / 100, 2);
            $total += Ventas_registro::moneda_principal_convert($cotizacion_manual->moneda_id, $total_cotizacion);
        }
    }

    return $total;
}
public static function count_mes($mes_año)
{
    $fecha = Carbon::createFromFormat('d-m-Y', $mes_año);
    $mes = $fecha->format('m');
    $año = $fecha->format('Y');

    return self::whereMonth('created_at', $mes)
               ->whereYear('created_at', $año)
               ->count();
}
}