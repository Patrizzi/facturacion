<?php

namespace App;

use App\Observers\TipoCambioObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TipoCambio extends Model
{
    protected $table = 'tipo_cambio';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        TipoCambio::observe(new TipoCambioObserver());
    }

    public static function get_statics()
    {
        $mes_ac = TipoCambio::where('fecha', '>=', now()->startOfMonth())->get();
        $max_compra =  TipoCambio::where('paralelo', TipoCambio::min('paralelo'))->first();
        $max_venta = TipoCambio::where('paralelo', TipoCambio::max('paralelo'))->first();
        $datos = [];

        foreach ($mes_ac as $month_v) {
            $datos[] = [
                'dia_str' => Carbon::parse($month_v->fecha)->format('Y-m-d'),
                'Monto' => $month_v->paralelo
            ];
        }

        $valores = array_column($datos, 'Monto');
        
        $minY = number_format(min($valores) - 0.05, 2, '.', '');
        $maxY = number_format(max($valores) + 0.05, 2, '.', '');

        return array(
            'data' => $datos,
            'minY' => $minY,
            'maxY' => $maxY,
            'day_compra_max' => Carbon::parse($max_compra->fecha)->format('d-m-Y'),
            'max_compra' => $max_compra->paralelo,
            'day_venta_max' => Carbon::parse($max_venta->fecha)->format('d-m-Y'),
            'max_venta' => $max_venta->paralelo,
        );

    }
}
