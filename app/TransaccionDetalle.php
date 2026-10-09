<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaccionDetalle extends Model
{
    protected $table = 'transaccion_detalles';

    protected $fillable = [
        'metodo_pago',
        'transaccion_id',
        'nro_operacion',
        'comprobante'
    ];

    public function transaccion() {
        return $this->belongsTo(Transaccion::class, 'transaccion_id', 'id');
    }
}
