<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresoEgresoTransaccion extends Model
{
    protected $table = 'ingreso_egreso_transacciones';

    protected $fillable = [
        'transaccion_id',
        'monto',
        'tipo',
        'fecha'
    ];

    public function transaccion() {
        return $this->belongsTo(Transaccion::class, 'transaccion_id', 'id');
    }
}
