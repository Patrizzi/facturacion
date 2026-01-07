<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ComprobantesPagosDetalle extends Model
{
    protected $table = 'comprobantes_pagos_detalles';

    protected $appends = [
        'fecha_emision_format', 
        'numero_cuenta', 
        'fechas_input_format', 
        'banco_empresa', 
        // 'monto_pagado_format', 
        // 'contado_estado', 
        // 'moneda_comprobante'
    ];

    public function comprobante_pago()
    {
        return $this->belongsTo(ComprobantesPagos::class, 'comprobante_pago_id');
    }

    public function comprobante_pago_registros()
    {
        return $this->belongsTo(ComprobantesPagosRegistros::class, 'comprobante_pago_reg_id');
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id');
    }

    public function getFechaEmisionFormatAttribute()
    {
        return Carbon::parse($this->fecha_emision_input)->format('d-m-Y');
    }
    public function getFechasInputFormatAttribute()
    {
        return Carbon::parse($this->fechas_input)->format('d-m-Y');
    }
    public function getContadoEstadoAttribute()
    {
        if ( $this->comprobante_pago->factuacion_id  != null) {
            return  $this->comprobante_pago->facturacion->estado_pago_text;
        }
        if ( $this->comprobante_pago->factuacion_m_id  != null) {
            return  $this->comprobante_pago->facturacionM->estado_pago_text;
        }
        if ( $this->comprobante_pago->boleta_id != null) {
            return  $this->comprobante_pago->boleta->estado_pago_text;
        }
        if ( $this->comprobante_pago->boleta_m_id != null) {
            return  $this->comprobante_pago->boletaM->estado_pago_text;
        }
        if ( $this->comprobante_pago->nota_venta_id  != null) {
            return  $this->comprobante_pago->notaVenta->estado_pago_text ?? "Desconocido";
        }
    }
    public function getNumeroCuentaAttribute()
    {
        $banco_reg = BancoRegistro::find($this->adicional_input);
        return $banco_reg;
    }
    public function getBancoEmpresaAttribute()
    {
        if ($this->tipo_pago == "cheque") {
            //  $banco = $this->
            $banco_reg = BancoRegistro::find($this->adicional_input);
            $banco = $banco_reg->bancos_i;
            return $banco;
        }
    }
    public function getFormaPagoAttribute()
    {
        if ($this->comprobante_pago_registros->monto_total == $this->comprobante_pago_registros->monto_pago) {
            return 0;
        } else {
            return 1;
        }
    }

    public function getMonedaComprobanteAttribute()
    {
        if ($this->comprobante_pago->factuacion_id  != null) {
            return $this->comprobante_pago->facturacion->moneda;
        }
        if ($this->comprobante_pago->factuacion_m_id  != null) {
            return $this->comprobante_pago->facturacionM->moneda;
        }
        if ($this->comprobante_pago->boleta_id  != null) {
            return $this->comprobante_pago->boleta->moneda;
        }
        if ($this->comprobante_pago->boleta_m_id  != null) {
            return $this->comprobante_pago->boletaM->moneda;
        }
        if ($this->comprobante_pago->nota_venta_id  != null) {
            return $this->comprobante_pago->notaVenta->moneda;
        }
    }
    public function getMontoPagadoAttribute()
    {

        if (($this->moneda_id == $this->moneda_comprobante->id) || ($this->moneda_id == null)) {
            // Si se pago con la moneda del comp
            $total_pagado = $this->comprobante_pago_registros->monto_pago;
        } else {
            // $moneda_principal = Moneda::ho
            if (($this->moneda_comprobante->simbolo == '$' && $this->moneda->simbolo) || ($this->moneda_comprobante->simbolo !== '$' && $this->moneda->simbolo !== 'S/')) {
                $total_pagado = round($this->comprobante_pago_registros->monto_pago * $this->tipo_cambio, 2);
            } else {
                $total_pagado = round($this->comprobante_pago_registros->monto_pago / $this->tipo_cambio, 2);
            }
        }
        return $total_pagado;
    }
    public function calcularMontoPagadoFormat()
    {
        if (!$this->relationLoaded('comprobante_pago_registros')) {
            return null;
        }

        $registro = $this->comprobante_pago_registros;
        $monto = $registro->monto_pago;

        if (
            $this->moneda_id == $this->moneda_comprobante->id ||
            $this->moneda_id === null
        ) {
            return $this->moneda_comprobante->simbolo . ' ' . number_format($monto, 2);
        }

        if ($this->moneda_comprobante->simbolo === '$' && $this->moneda->simbolo === 'S/') {
            return $this->moneda->simbolo . ' ' . number_format($monto * $this->tipo_cambio, 2);
        }

        return $this->moneda->simbolo . ' ' . number_format($monto / $this->tipo_cambio, 2);
    }
}
