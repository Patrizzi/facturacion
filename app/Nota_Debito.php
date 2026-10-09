<?php

namespace App;

use Carbon\Carbon;
use Facade\FlareClient\Http\Client;
use Illuminate\Database\Eloquent\Model;

class Nota_Debito extends Model
{
    protected $table  = 'nota_debito';

    protected $guarded = [];

    public function nota_i_facturacion()
    {
        return $this->belongsTo(Facturacion::class, 'facturacion_id');
    }

    public function nota_i_fac_manual()
    {
        return $this->belongsTo(Facturacion_m::class, 'facturacion_m_id');
    }

    public function nota_i_boleta()
    {
        return $this->belongsTo(Boleta::class, 'boleta_id');
    }

    public function nota_i_boleta_manual()
    {
        return $this->belongsTo(Boleta_m::class, 'boleta_m_id');
    }

    public function nota_i_almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    // AGREGAR ESTA RELACIÓN FALTANTE
    public function detalles()
    {
        return $this->hasMany(Nota_Debito_registro::class, 'nota_debito_id');
    }

    public static function count_month_comprobantes($fecha)
    {
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha
        $notas_debitos  = Nota_Debito::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
        $mes = array(
            "cantidad" => $notas_debitos->count()
        );
        return $mes;
    }

    public static function estado_sunat($id)
    {
        $nota_debito = Nota_Debito::find($id);
        switch ($nota_debito->n_electronica) {
            case '1':
                // $estado_sunat = "Enviado";
                $estado_sunat = 1;
                break;
            case '2':
                // $estado_sunat = "Anulado";
                $estado_sunat = 2;
                break;
            default:
                // $estado_sunat = "Sin enviar";
                $estado_sunat = 0;
                break;
        }
        return $estado_sunat;
    }

    public static function revision_tipo() {}

    public function getTotalPrecioAttribute()
    {
        // $boleta = Boleta::find($this->attributes['id']);
        $igv = Igv::first()->renta;
        // $boleta_reg = Boleta_registro::where('boleta_id', $boleta->id)->get();
        $subtotal = $this->attributes['op_gravada'] + $this->attributes['op_inafecta'] + $this->attributes['op_exonerada'];

        $total = round($subtotal + ($this->attributes['op_gravada'] * $igv) / 100, 2);

        // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
        // $total_conv = ComprobantesVentas::moneda_principal_convert($this->attributes['id']->moneda_id, $total);

        $total_igv = $this->moneda_imbolo . ' ' . number_format($total, 2);
        return $total_igv;
    }

    public function getClienteAttribute()
    {
        if ($this->facturacion_id) {
            return optional($this->nota_i_facturacion->cliente)->id;
        }

        if ($this->facturacion_m_id) {
            return optional($this->nota_i_fac_manual->cliente)->id;
        }

        if ($this->boleta_id) {
            return optional($this->nota_i_boleta->cliente)->id;
        }

        if ($this->boleta_m_id) {
            return optional($this->nota_i_boleta_manual->cliente)->id;
        }

        return null; // explícito
    }

    // Retorna a un objeto, no a un id
    public function getClienteObjAttribute()
    {
        if ($this->facturacion_id)
            return $this->nota_i_facturacion->cliente ?? null;
        if ($this->facturacion_m_id)
            return $this->nota_i_fac_manual->cliente ?? null;
        if ($this->boleta_id)
            return $this->nota_i_boleta->cliente ?? null;
        if ($this->boleta_m_id)
            return $this->nota_i_boleta_manual->cliente ?? null;
        return null;
    }

    public function getMonedaSimboloAttribute()
    {
        if ($this->facturacion_id) {
            return optional($this->nota_i_facturacion->moneda)->simbolo;
        }

        if ($this->facturacion_m_id) {
            return optional($this->nota_i_fac_manual->moneda)->simbolo;
        }

        if ($this->boleta_id) {
            return optional($this->nota_i_boleta->moneda)->simbolo;
        }

        if ($this->boleta_m_id) {
            return optional($this->nota_i_boleta_manual->moneda)->simbolo;
        }

        return null; // explícito
    }
}
