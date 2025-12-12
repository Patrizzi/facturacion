<?php

namespace App;

use App\Observers\CuotasCreditosObserver;
use Greenter\Model\Sale\Cuota;
use Illuminate\Database\Eloquent\Model;

class Cuotas_credito extends Model
{
    protected $table = 'cuotas_creditos';

    protected $guarded = [];

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

    // protected static function boot()
    // {
    //     parent::boot();
    //     Cuotas_credito::observe(new CuotasCreditosObserver());
    // }

    public static function monto_convertido($id_cuota, $moneda_id, $tipo_cambio)
    {
        $cuota = Cuotas_credito::find($id_cuota);
        $moneda_comprobante = Moneda::find($moneda_id);
        $monedas = Moneda::get();
        $data = [];
        // return $monedas;
        foreach ($monedas as $moneda) {
            // Moneda igual → no convertir
            if ($moneda->id == $moneda_comprobante->id) {
                $data["igual"] = $moneda->simbolo . " " . $cuota->monto;
                // continue;
            } else {

                // Si comprobante NO está en soles → convertir a soles
                if ($moneda_comprobante->simbolo != "S/") {
                    $data["diferente"] = $moneda->simbolo . " " . round($cuota->monto * $tipo_cambio, 2);
                } else {
                    // Convertir a dólares
                    $data["diferente"] = $moneda->simbolo . " " . round($cuota->monto / $tipo_cambio, 2);
                }
            }
        }
        return $data;
    }

    public static function saldo_convertido($id_cuota)
    {
        $registro = ComprobantesPagosRegistros::where('id_cuota_credito', $id_cuota)->take(2)->get();
        return $registro;
    }

    // public function 
}
