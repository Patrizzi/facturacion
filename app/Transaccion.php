<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $table = 'transacciones';

    protected $fillable = [
        'nro_pago',
        'nombres',
        'dni',
        'descripcion',
        'observaciones',
        'monto',
        'fecha',
        'caja_id',
        'tipo_transaccion_id'
    ];

    public function caja() {
        return $this->belongsTo(Caja::class, 'caja_id', 'id');
    }

    public function tipoTransaccion() {
        return $this->belongsTo(TipoTransaccion::class, 'tipo_transaccion_id', 'id');
    }

    public function transaccionDetalle() {
        return $this->hasOne(TransaccionDetalle::class, 'transaccion_id', 'id');
    }

    public function ingresoEgresoTransaccion() {
        return $this->hasOne(IngresoEgresoTransaccion::class, 'transaccion_id', 'id');
    }

    public function saldoTransaccion() {
        return $this->hasMany(SaldoTransaccion::class, 'transaccion_id', 'id');
    }
}
