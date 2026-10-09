<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldoTransaccion extends Model
{
    protected $table = 'saldo_transacciones';

    protected $fillable = [
        'fecha',
        'saldo_actual',
        'transaccion_id'
    ];

    public function transaccion() {
        return $this->belongsTo(Transaccion::class, 'transaccion_id', 'id');
    }
}
