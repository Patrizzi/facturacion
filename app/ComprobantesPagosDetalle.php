<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ComprobantesPagosDetalle extends Model
{
    protected $table = 'comprobantes_pagos_detalles';

    protected $appends = ['banco_empresa','monto_pagado_format','fecha_emision_format','numero_cuenta','fechas_input_format'];

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

    public function getFechaEmisionFormatAttribute(){
        return Carbon::parse($this->fecha_emision_input)->format('d-m-Y');
    }
    public function getFechasInputFormatAttribute(){
        return Carbon::parse($this->fechas_input)->format('d-m-Y');
    }
    public function getNumeroCuentaAttribute()
    {
        $banco_reg = BancoRegistro::find($this->adicional_input);
        return $banco_reg;
    }
    public function getBancoEmpresaAttribute()
    {
       if($this->tipo_pago == "cheque"){
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

        $cuota = $this->comprobante_pago_registros->cuota_credito;
        if ($cuota->facturacion_id != null) {
            return $cuota->factura_ids->moneda;
        }
        if ($cuota->factura_m_ids != null) {
            return $cuota->factura_m_ids->moneda;
        }
        if ($cuota->boleta_ids != null) {
            return $cuota->boleta_ids->moneda;
        }
        if ($cuota->boleta_m_ids != null) {
            return $cuota->boleta_m_ids->moneda;
        }
    }
    public function getMontoPagadoAttribute()
    {

        if (($this->moneda_id == $this->moneda_comprobante->id) || ($this->moneda_id = null)) {
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
    public function getMontoPagadoFormatAttribute()
    {

        // $monedaBase = Moneda::findOrFail($moneda_pago);
        // dd( $this->moneda->simbolo );
        if (($this->moneda_id == $this->moneda_comprobante->id) || ($this->moneda_id == null)) {
            // Si se pago con la moneda del comp
            $total_pagado = $this->moneda_comprobante->simbolo . ' ' . number_format($this->comprobante_pago_registros->monto_pago, 2);
        } else {
            // $moneda_principal = Moneda::ho
            if ($this->moneda_comprobante->simbolo === '$' && $this->moneda->simbolo === 'S/') {
                $total_pagado = $this->moneda->simbolo . ' ' . number_format(round($this->comprobante_pago_registros->monto_pago * $this->tipo_cambio, 2), 2);
            } else {
                $total_pagado = $this->moneda->simbolo . '  ' . number_format(round($this->comprobante_pago_registros->monto_pago / $this->tipo_cambio, 2), 2);
            }
        }
        return $total_pagado;
    }
}
