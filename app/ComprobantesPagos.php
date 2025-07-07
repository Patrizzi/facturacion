<?php

namespace App;

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
        'pendiente_pago'
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
        return $this->hasMany(ComprobantesPagosDetalle::class,'comprobante_pago_id', 'id');
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

    public function getPendientePagoAttribute() {
        
    }
}
