<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturacion_registro_m extends Model
{
    protected $table = 'facturacion_registro_m';

    protected $guarded = [];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicios::class, 'servicio_id');
    }

    public function factura_ids()
    {
        return $this->belongsTo(Facturacion_m::class, 'facturacion_m_id');
    }

    public function getArticuloDescripcionAttribute()
    {
        if (!empty($this->attributes['producto_id'])) {
            return optional($this->producto)->nombre . ' ' . $this->attributes['descripcion_item'];
        } else {
            return optional($this->servicio)->nombre . ' ' . $this->attributes['descripcion_item'];
        }
    }

    public function getPrecioSugeridoAttribute()
    {
        $tipo_cambio = $this->factura_ids->tipo_cambio;
        if ($this->factura_ids->moneda->tipo == 'nacional') {
            // Si la factura es en moneda nacional
            if (!empty($this->attributes['producto_id'])) {
                // Si es producto
                return $this->producto->calcularPrecioNacional()['precio_nacional'];
            } else {
                // Si es servicio
                return $this->servicio->calcularPreciosTCExacto($tipo_cambio)['precio_nacional'];
            }
        } else {
            if (!empty($this->attributes['producto_id'])) {
                // Si es producto
                return $this->producto->calcularPrecioExtranjero()['precio_nacional'];
            } else {
                // Si es servicio
                return $this->servicio->calcularPreciosTCExacto($tipo_cambio)['precio_extranjero'];
            }
        }
    }

    public function getPrecioIgvAttribute(){
        $tipo_cambio = $this->factura_ids->tipo_cambio;
        $igv = Igv::first();
        if ($this->factura_ids->moneda_id == 1) {
            // Si la factura es en moneda nacional
            if (!empty($this->attributes['producto_id'])) {
                // Si es producto
                $precio = ($this->producto->calcularPrecioNacional()['precio_nacional']) + ($this->producto->calcularPrecioNacional()['precio_nacional'] * ($igv->igv_total / 100)); ;
                return $precio;
            } else {
                // Si es servicio
                $precio = ($this->servicio->calcularPreciosTCExacto($tipo_cambio)['precio_nacional']) + ($this->servicio->calcularPreciosTCExacto($tipo_cambio)['precio_nacional_igv'] * ($igv->igv_total / 100)); ;
                return $precio;
            }
        } else {
            if (!empty($this->attributes['producto_id'])) {
                // Si es producto
                $precio = ($this->producto->calcularPrecioExtranjero()['precio_nacional']) + ($this->producto->calcularPrecioExtranjero()['precio_nacional'] * ($igv->igv_total / 100)); ;
                return $precio;
            } else {
                // Si es servicio
                $precio = ($this->servicio->calcularPreciosTCExacto($tipo_cambio)['precio_extranjero']) + ($this->servicio->calcularPreciosTCExacto($tipo_cambio)['precio_extranjero_igv'] * ($igv->igv_total / 100)); ;
                return $precio;
            }
        }
    }

    public function getPrecioIgvEditAttribute(){
        $igv = Igv::first();
        $precio = $this->precio;
        $precio_igv = $this->precio * ( $igv->igv_total / 100);
        $total =  $precio  + $precio_igv;
        return $total; 
    }
}
