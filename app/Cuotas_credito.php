<?php

namespace App;

use App\Observers\CuotasCreditosObserver;
use Carbon\Carbon;
use Greenter\Model\Sale\Cuota;
use Illuminate\Database\Eloquent\Model;

class Cuotas_credito extends Model
{
    protected $table = 'cuotas_creditos';

    protected $guarded = [];

    protected $appends = ['monto_total_format', 'moneda_comprobante', 'estado_format', 'fecha_pago_format'];

    public function factura_ids()
    {
        return $this->belongsTo(Facturacion::class, 'facturacion_id');
    }
    public function factura_m_ids()
    {
        return $this->belongsTo(Facturacion_m::class, 'facturacion_m_id');
    }
    public function boleta_ids()
    {
        return $this->belongsTo(Boleta::class, 'boleta_id');
    }
    public function boleta_m_ids()
    {
        return $this->belongsTo(Boleta_m::class, 'boleta_m_id');
    }

    public function getTipoComprobanteAttribute()
    {
        if ($this->attributes['facturacion_id'] != null) {
            return 1;
        }
        if ($this->attributes['facturacion_m_id'] != null) {
            return 2;
        }
        if ($this->attributes['boleta_id'] != null) {
            return 3;
        }
        if ($this->attributes['boleta_m_id'] != null) {
            return 4;
        }
    }

    public function getMonedaComprobanteAttribute()
    {
        if ($this->facturacion_id != null) {
            return $this->factura_ids->moneda->simbolo;
        }
        if ($this->boleta_id != null) {
            return $this->boleta_ids->moneda->simbolo;
        }
        if ($this->facturacion_m_id != null) {
            return $this->factura_m_ids->moneda->simbolo;
        }
        if ($this->boleta_m_id != null) {
            return $this->boleta_m_ids->moneda->simbolo;
        }
    }
    public function getMontoTotalFormatAttribute()
    {
        // $monto = $this->moneda_comprobante . ' ' . number_format(round($this->monto, 2), 2);
        return $this->moneda_comprobante . ' ' . number_format(round($this->monto, 2), 2);
        // return $monto;
    }
    public function getFechaPagoFormatAttribute()
    {
        return Carbon::parse($this->fecha_pago)->format('d-m-Y');
    }
    public function getEstadoFormatAttribute()
    {
        switch ($this->estado) {
            case 0:
                return 'Pendiente';
                break;
            case 1:
                return 'Adelantado';
                break;
            case 2:
                return 'Pagado';
                break;
        }
    }

    public static function monto_total_convertido_cuota($id_cuota, $moneda_id, $tipo_cambio)
    {
        $cuota = Cuotas_credito::find($id_cuota);
        $moneda_comprobante = Moneda::find($moneda_id);
        $monedas = Moneda::get();
        $monto = [];
        // return $monedas;
        foreach ($monedas as $moneda) {
            // Moneda igual → no convertir
            if ($moneda->id == $moneda_comprobante->id) {
                $monto["igual"] = $moneda->simbolo . " " . $cuota->monto;
                $monto["moneda_igual"] = $moneda->simbolo;
                $monto["igual_neto"] = round($cuota->monto, 2);
                // continue;
            } else {

                // Si comprobante NO está en soles → convertir a soles
                if ($moneda_comprobante->simbolo != "S/") {
                    $monto["diferente"] = $moneda->simbolo . " " . round($cuota->monto * $tipo_cambio, 2);
                    $monto["moneda_diff"] = $moneda->simbolo;
                    $monto["diferente_neto"] = round($cuota->monto * $tipo_cambio, 2);
                } else {
                    // Convertir a dólares
                    $monto["diferente"] = $moneda->simbolo . " " . round($cuota->monto / $tipo_cambio, 2);
                    $monto["moneda_diff"] = $moneda->simbolo;
                    $monto["diferente_neto"] = round($cuota->monto / $tipo_cambio, 2);
                }
            }
        }
        return $monto;
    }

    public static function monto_pagado_convertido_cuota($id_cuota, $moneda_pago, $tipo_cambio)
    {
        $detalles = ComprobantesPagosDetalle::whereIn(
            'comprobante_pago_reg_id',
            ComprobantesPagosRegistros::where('id_cuota_credito', $id_cuota)->select('id')
        )->get();
        $moneda_comprobante = Moneda::find($moneda_pago);
        $moneda_no_comprobante = Moneda::where('id', '!=', $moneda_comprobante->id)->first();
        $restante = [
            'prin' => 0,
            'sec' => 0,
            'simbolo' => '',
            'simbolo_2' => '',
        ];
        // if(){}
        foreach ($detalles as $det) {
            $moneda_detalle = $det->moneda_id ?? $moneda_comprobante->id;
            $restante["simbolo"] = $moneda_comprobante->simbolo;
            $restante["simbolo_2"] = $moneda_no_comprobante->simbolo;
            // Si la moneda es igual al del comprobante
            if ($moneda_comprobante->id == $moneda_detalle) {
                $restante["prin"] += $det->comprobante_pago_registros->monto_pago;
            } else {
                if ($det->moneda->simbolo == "$") { //Si es dolar conversion de sol a dolar
                    $restante["sec"] += round($det->comprobante_pago_registros->monto_pago / $det->tipo_cambio, 2);
                } else {
                    $restante["sec"] += round($det->comprobante_pago_registros->monto_pago * $det->tipo_cambio, 2);
                }
            }
        }
        // dd($restante);
        // Colocar el simbolo y formato
        $no_moneda = Moneda::where('id', '!=', $moneda_comprobante->id)->first();
        $data = [
            "prin" => (trim($restante['simbolo'] ?? '') ? $restante["simbolo"] : $moneda_comprobante->simbolo) . ' ' . number_format($restante["prin"] ?? 0, 2),
            "sec" => (trim($restante['simbolo_2'] ?? '') ? $restante["simbolo_2"] : $no_moneda->simbolo) . ' ' . number_format($restante["sec"] ?? 0, 2)
        ];

        return $data;
    }

    public static function restante_pago_convertido_cuota($id_cuota, $moneda_pago)
    {
        $cuota = Cuotas_credito::findOrFail($id_cuota);
        $monedaBase = Moneda::findOrFail($moneda_pago);
        $detalles = ComprobantesPagosDetalle::whereIn(
            'comprobante_pago_reg_id',
            ComprobantesPagosRegistros::where('id_cuota_credito', $id_cuota)->select('id')
        )->get();
        $totalPagado = 0.0;

        foreach ($detalles as $det) {
            $monto = $det->comprobante_pago_registros->monto_pago;
            // dd($monto);
            if ($det->moneda_id == $monedaBase->id) {
                $totalPagado += $monto;
                continue;
            }
            if (!$det->tipo_cambio || $det->tipo_cambio <= 0) {
                continue;
            }
            if (($monedaBase->simbolo === '$' && $det->moneda->simbolo === 'S/') || ($monedaBase->simbolo !== '$' && $det->moneda->simbolo !== 'S/')) {
                $totalPagado += round($monto * $det->tipo_cambio, 2);
            } else {
                $totalPagado += round($monto / $det->tipo_cambio, 2);
            }
        }
        $saldoPendiente = round($cuota->monto - $totalPagado, 2);

        return [
            'total_cuota'     => round($cuota->importe_total, 2),
            'total_pagado'    => round($totalPagado, 2),
            'saldo_pendiente' => max($saldoPendiente, 0),
            'moneda'          => $monedaBase->simbolo,
        ];
    }

    public function getMontoTotalProcesadoAttribute()
    {
        $monto_base = $this->attributes['monto'];
        switch ($this->tipo_comprobante) {
            case 1: //Factura
                $factura = Facturacion::find($this->attributes['id']);
                $total = $factura->precio_sin_forma; //Total de Factura con reduccion incluida
                if($this->estado == 1 || $this->estado == 2){ //Si ya está pagado o adelantado
                    return $this->attributes['monto'];
                }else{
                    $cuotas_disponibles = Cuotas_credito::where('facturacion_id', $this->attributes['facturacion_id'])->where('estado', '!=', 2)->count();
                    $total_red = $total 
                }
                // $precio_red = $total 
                break;
            case 2: //Factura M
                # code...
                break;
            case 3: //Boleta 
                # code...
                break;
            case 4: //Boleta M
                # code...
                break;
        }
    }
}
