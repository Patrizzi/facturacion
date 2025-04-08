<?php

namespace App;

use App\Observers\TipoCambioObserver;
use Illuminate\Database\Eloquent\Model;

class TipoCambio extends Model
{
    protected $table = 'tipo_cambio';

    protected $guarded = [];

    protected static function boot(){
    	parent::boot();
    	TipoCambio::observe(new TipoCambioObserver());
    }

    public static function get_statics(){
        $max_compra = TipoCambio::max('compra');
        $max_venta = TipoCambio::max('venta');

        return array(
            'max_compra' => $max_compra,
            'max_venta' => $max_venta,
        );
    }
}
