<?php

namespace App;

use App\Http\Controllers\HelperController;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;

class ComprobantesPagos extends Model
{
    protected $table = 'comprobantes_pagos';

    // serializar los campos
    protected $appends = [
        'cliente_nombre',
        'fecha_emision',
        'cod_comprobante',
        'estado_pago',
        'nro_documento',
        'pendiente_pago',
        'importe_total',
        'forma_pago',
        'subtotal',
        'igv',
        'fecha_vencimiento',
        'banco',
        'nro_operacion',
        'observacion',
        'tipo_cambio',
        'monto_cancelacion',
        'simbolo_moneda',
        'importe_total_formateado',
        'guia_remision'
        ];

    public function facturacion() {
        return $this->belongsTo(Facturacion::class, 'factuacion_id', 'id');
    }

    public function facturacionM() {
        return $this->belongsTo(Facturacion_m::class, 'factuacion_m_id', 'id');
    }

    public function boleta() {
        return $this->belongsTo(Boleta::class, 'boleta_id', 'id');
    }

    public function boletaM() {
        return $this->belongsTo(Boleta_m::class, 'boleta_m_id', 'id');
    }

    public function notaVenta() {
        return $this->belongsTo(NotaVenta::class, 'nota_venta_id', 'id');
    }

    public function comprobantePagoRegistro(){
        return $this->hasMany(ComprobantesPagosRegistros::class,'comprobante_pago_id', 'id');
    }
    public function comprobantePagoDetalle(){
        return $this->hasOne(ComprobantesPagosDetalle::class,'comprobante_pago_id', 'id');
    }


    // Método Accessor
    // importante Sufijo => Attribute
   public function getClienteNombreAttribute(){
        return optional(optional($this->facturacion)->cliente)->nombre
        ?? optional(optional($this->facturacionM)->cliente)->nombre
        ?? optional(optional($this->boleta)->cliente)->nombre
        ?? optional(optional($this->boletaM)->cliente)->nombre
        ?? optional(optional($this->notaVenta)->cliente)->nombre;
    }

    public function getNroDocumentoAttribute() {
        return optional(optional($this->facturacion)->cliente)->numero_documento
        ?? optional(optional($this->facturacionM)->cliente)->numero_documento
        ?? optional(optional($this->boleta)->cliente)->numero_documento
        ?? optional(optional($this->boletaM)->cliente)->numero_documento
        ?? optional(optional($this->notaVenta)->cliente)->numero_documento;
    }

    public function getFechaEmisionAttribute() {
        return optional($this->facturacion)->fecha_emision
        ?? optional($this->facturacionM)->fecha_emision
        ?? optional($this->boleta)->fecha_emision
        ?? optional($this->boletaM)->fecha_emision
        ?? optional($this->notaVenta)->fecha_emision;
    }

    public function getCodComprobanteAttribute() {
        // factura
        $codigo = optional($this->facturacion)->codigo_fac;
        if($codigo) {
            return 'Factura - ' . $codigo;
        }

        // factura_m
        $codigo = optional($this->facturacionM)->codigo_fac;
        if($codigo) {
            return 'Factura M. - ' .$codigo;
        }

        // boleta
        $codigo = optional($this->boleta)->codigo_boleta;
        if($codigo) {
            return 'Boleta - ' .$codigo;
        }

        // boleta_m
        $codigo = optional($this->boletaM)->codigo_boleta;
        if($codigo) {
            return 'Boleta M. - ' .$codigo;
        }

        // nota venta
        $codigo = optional($this->notaVenta)->cod_nota_venta;
        if($codigo){
            return 'Nota de Venta - ' .$codigo;
        }
    }

    public function getEstadoPagoAttribute() {
        $estado = optional($this->facturacion)->estado_pago
        ?? optional($this->facturacionM)->estado_pago
        ?? optional($this->boleta)->estado_pago
        ?? optional($this->boletaM)->estado_pago
        ?? optional($this->notaVenta)->estado_pago;

        $estados = [
            0 => 'Sin pago',
            1 => 'Adelantado',
            2 => 'Pagado'
        ];

        return $estados[$estado];
    }

    public function getFormaPagoAttribute() {
        $facturacion = optional(optional($this->facturacion)->forma_pago)->nombre;
        $facturacionM = optional(optional($this->facturacionM)->forma_pago)->nombre;
        $boleta = optional(optional($this->boleta)->forma_pago)->nombre;
        $boletaM = optional(optional($this->boletaM)->forma_pago)->nombre;
        $notaVenta = optional(optional($this->notaVenta)->forma_pago)->nombre;

        return $facturacion ?? $facturacionM ?? $boleta ?? $boletaM ?? $notaVenta ?? 'No definido';
    }

    public function getImporteTotalAttribute(){

        $facturacionId = $this->factuacion_id;
        $factuacionMId = $this->factuacion_m_id;
        $boletaId = $this->boleta_id;
        $boletaMId = $this->boleta_m_id;
        $notaVentaId = $this->nota_venta_id;

        if (!is_null($facturacionId)) {
            $importe_cuotas = $this->sumar_cuotas($facturacionId, 'facturacion_id');
            if ($importe_cuotas == 0) {
                return $this->calcular_total_pagado();
            }
            return $importe_cuotas;
        }

        if (!is_null($factuacionMId)) {
            $importe_cuotas = $this->sumar_cuotas($factuacionMId, 'facturacion_m_id');
            if ($importe_cuotas == 0) {
                return $this->calcular_total_pagado();
            }
            return $importe_cuotas;
        }

        if (!is_null($boletaId)) {
            $importe_cuotas = $this->sumar_cuotas($boletaId, 'boleta_id');
            if ($importe_cuotas == 0) {
                return $this->calcular_total_pagado();
            }
            return $importe_cuotas;
        }

        if (!is_null($boletaMId)) {
            $importe_cuotas = $this->sumar_cuotas($boletaMId, 'boleta_m_id');
            if ($importe_cuotas == 0) {
                return $this->calcular_total_pagado();
            }
            return $importe_cuotas;
        }

        if (!is_null($notaVentaId)) {
            return optional($notaVentaId)->monto_tot ?? 0.0;
        }

        return 0.0;
    }

    private function sumar_cuotas($id, $columna) {
        return Cuotas_credito::where($columna, $id)->sum('monto');
    }

    private function calcular_total_pagado(){

        $facturacionId = $this->factuacion_id;
        $factuacionMId = $this->factuacion_m_id;
        $boletaId = $this->boleta_id;
        $boletaMId = $this->boleta_m_id;
        $notaVentaId = $this->nota_venta_id;

        if (!is_null($facturacionId)) {
            return ComprobantesPagos::where('factuacion_id', $facturacionId)->sum('monto_pago');
        }

        if (!is_null($factuacionMId)) {
            return ComprobantesPagos::where('factuacion_m_id', $factuacionMId)->sum('monto_pago');
        }

        if (!is_null($boletaId)) {
            return ComprobantesPagos::where('boleta_id', $boletaId)->sum('monto_pago');
        }

        if (!is_null($boletaMId)) {
            return ComprobantesPagos::where('boleta_m_id', $boletaMId)->sum('monto_pago');
        }

        if (!is_null($notaVentaId)) {
            return ComprobantesPagos::where('nota_venta_id', $notaVentaId)->sum('monto_pago');
        }

        return 0.0;
    }

    public function getPendientePagoAttribute() {
        $totalPagado = $this->calcular_total_pagado();
        $pendienteTotal = $this->importe_total - $totalPagado;

        return $pendienteTotal;
    }

    public function getSubtotalAttribute() {

        $facturacion = $this->facturacion;
        $facturacionM = $this->facturacionM;
        $boleta = $this->boleta;
        $boletaM = $this->boletaM;
        $notaVenta = $this->notaVenta;

        if (!is_null($facturacion)) {
            $subtotal = $facturacion->op_gravada + $facturacion->op_inafecta + $facturacion->op_exonerada;

            return $subtotal;
        }

        if (!is_null($facturacionM)) {
            $subtotal = $facturacionM->op_gravada + $facturacionM->op_inafecta + $facturacionM->op_exonerada;

            return $subtotal;
        }

        if (!is_null($boleta)) {
            $subtotal = $boleta->op_gravada + $boleta->op_inafecta + $boleta->op_exonerada;

            return $subtotal;
        }

        if (!is_null($boletaM)) {
            $subtotal = $boletaM->op_gravada + $boletaM->op_inafecta + $boletaM->op_exonerada;

            return $subtotal;
        }

        if (!is_null($notaVenta)) {
            $subtotal = $notaVenta->op_gravada + $notaVenta->op_inafecta + $notaVenta->op_exonerada;

            return $subtotal;
        }

        return 'No definido';
    }

    public function getIgvAttribute() {
        $igv = Igv::first();

        $facturacion = $this->facturacion;
        $facturacionM = $this->facturacionM;
        $boleta = $this->boleta;
        $boletaM = $this->boletaM;
        $notaVenta = $this->notaVenta;

        if (!is_null($facturacion)) {
            $subtotalGravado = $facturacion->op_gravada;
            $igv_p = (round($subtotalGravado, 2) * $igv->igv_total) / 100;

            return $igv_p;
        }

        if  (!is_null($facturacionM)) {
            $subtotalGravado = $facturacionM->op_gravada;
            $igv_p = (round($subtotalGravado, 2) * $igv->igv_total) / 100;

            return $igv_p;
        }

        if (!is_null($boleta)) {
            $subtotalGravado = $boleta->op_gravada;
            $igv_p = (round($subtotalGravado, 2) * $igv->igv_total) / 100;

            return $igv_p;
        }

        if (!is_null($boletaM)) {
            $subtotalGravado = $boletaM->op_gravada;
            $igv_p = (round($subtotalGravado, 2) * $igv->igv_total) / 100;

            return $igv_p;
        }

        if (!is_null($notaVenta)) {
            $subtotalGravado = $notaVenta->op_gravada;
            $igv_p = (round($subtotalGravado, 2) * $igv->igv_total) / 100;

            return $igv_p;
        }

        return 'No definido';
    }

    public function getFechaVencimientoAttribute() {
        $facturacion = optional($this->facturacion)->fecha_vencimiento;
        $facturacionM = optional($this->facturacionM)->fecha_vencimiento;
        $boleta = optional($this->boleta)->fecha_vencimiento;
        $boletaM = optional($this->boletaM)->fecha_vencimiento;

        return $facturacion ?? $facturacionM ?? $boleta ?? $boletaM ?? 'No definido';
    }

    public function getBancoAttribute() {
        $detalle = $this->comprobantePagoDetalle;

        if ($detalle) {
            if ($detalle->tipo_pago === 'tarjeta'){
                return $detalle->bancos_input ?? 'No definido';
            } else if ($detalle->tipo_pago === 'Transferencia') {
                return 'Transferencia';
            } else if ($detalle->tipo_pago === 'cheque') {
                return $detalle->bancos_input ?? 'No definido';
            }
        }

        return 'Efectivo';

    }

    public function getNroOperacionAttribute() {
        $detalle = $this->comprobantePagoDetalle;

        if ($detalle) {
            if ($detalle->tipo_pago === 'tarjeta') {
                return $detalle->numero_input ?? 'No definido';
            } else if ($detalle->tipo_pago === 'cheque') {
                return $detalle->numero_input ?? 'No definido';
            } else {
                return 'No definido';
            }
        }

        return 'No definido';
    }

    public function getObservacionAttribute() {
        $facturacion = optional($this->facturacion)->observacion;
        $facturacionM = optional($this->facturacionM)->observacion;
        $boleta = optional($this->boleta)->observacion;
        $boletaM = optional($this->boletaM)->observacion;
        $notaVenta = optional($this->notaVenta)->observacion;

        return $facturacion ?? $facturacionM ?? $boleta ?? $boletaM ?? $notaVenta ?? 'No definido';
    }

    public function getTipoCambioAttribute() {
        $fechaRaw = optional($this->facturacion)->fecha_emision
                  ?? optional($this->facturacionM)->fecha_emision
                  ?? optional($this->boleta)->fecha_emision
                  ?? optional($this->boletaM)->fecha_emision
                  ?? optional($this->notaVenta)->fecha_emision;

        if (! $fechaRaw) {
            return null;
        }

        try{
            $fecha = Carbon::createFromFormat('j-n-Y', $fechaRaw);
        } catch (Exception $e1) {
            try {
                $fecha = Carbon::parse($fechaRaw);
            } catch (Exception $e2) {
                return null;
            }
        }

        $fechaISO = $fecha->toDateString();
        $tc = TipoCambio::whereDate('fecha', $fechaISO)->first();

        if (!$tc) {
            return null;
        }

        return ($tc->compra + $tc->venta) / 2;

    }

    private function obtenerSimboloMoneda($moneda_id) {
        return $moneda_id == 1 ? 'S/' : '$';
    }

    // Método para obtener solo el símbolo de moneda (simplificado)
    public function getSimboloMonedaAttribute() {
        $facturacion = optional($this->facturacion);
        $facturacionM = optional($this->facturacionM);
        $boleta = optional($this->boleta);
        $boletaM = optional($this->boletaM);
        $notaVenta = optional($this->notaVenta);

        if (!is_null($facturacion)) {
            return $this->obtenerSimboloMoneda($facturacion->moneda_id);
        }

        if (!is_null($facturacionM)) {
            return $this->obtenerSimboloMoneda($facturacionM->moneda_id);
        }

        if (!is_null($boleta)) {
            return $this->obtenerSimboloMoneda($boleta->moneda_id);
        }

        if (!is_null($boletaM)) {
            return $this->obtenerSimboloMoneda($boletaM->moneda_id);
        }

        if (!is_null($notaVenta)) {
            return $this->obtenerSimboloMoneda($notaVenta->moneda_id);
        }

        return 'No definido';
    }

    // Método para obtener importe total formateado con símbolo
    public function getImporteTotalFormateadoAttribute() {
        $facturacion = optional($this->facturacion);
        $facturacionM = optional($this->facturacionM);
        $boleta = optional($this->boleta);
        $boletaM = optional($this->boletaM);
        $notaVenta = optional($this->notaVenta);

        $importe = $this->getImporteTotalAttribute();

        if (!is_null($facturacion)) {
            $simbolo = $this->obtenerSimboloMoneda($facturacion->moneda_id);
            return $simbolo . ' ' . number_format($importe, 2);
        }

        if (!is_null($facturacionM)) {
            $simbolo = $this->obtenerSimboloMoneda($facturacionM->moneda_id);
            return $simbolo . ' ' . number_format($importe, 2);
        }

        if (!is_null($boleta)) {
            $simbolo = $this->obtenerSimboloMoneda($boleta->moneda_id);
            return $simbolo . ' ' . number_format($importe, 2);
        }

        if (!is_null($boletaM)) {
            $simbolo = $this->obtenerSimboloMoneda($boletaM->moneda_id);
            return $simbolo . ' ' . number_format($importe, 2);
        }

        if (!is_null($notaVenta)) {
            $simbolo = $this->obtenerSimboloMoneda($notaVenta->moneda_id);
            return $simbolo . ' ' . number_format($importe, 2);
        }

        return 'S/ ' . number_format($importe, 2);
    }

    public function getGuiaRemisionAttribute() {
        $facturacion = optional($this->facturacion);
        $facturacionM = optional($this->facturacionM);
        $boleta = optional($this->boleta);
        $boletaM = optional($this->boletaM);

        if (!is_null($facturacion)) {
            if ($facturacion->guia_remision === '0' || $facturacion->guia_remision === null) {
                return "";
            }

            return $facturacion->guia_remision;
        }

        if (!is_null($facturacionM)) {
            if ($facturacionM->guia_remision === '0' || $facturacionM->guia_remision === null) {
                return "";
            }

            return $facturacionM->guia_remision;
        }

        if (!is_null($boleta)) {
            if ($boleta->guia_remision === '0' || $boleta->guia_remision === null) {
                return "";
            }

            return $boleta->guia_remision;
        }

        if (!is_null($boletaM)) {
            if ($boletaM->guia_remision === '0' || $boletaM->guia_remision === null) {
                return "";
            }

            return $boletaM->guia_remision;
        }

        return 'No definido';
    }
}
