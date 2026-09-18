<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoTransaccion extends Model
{
    protected $table = 'tipo_transacciones';

    protected $fillable = [
        'nombre',
        'es_interno'
    ];

    public function transacciones() {
        return $this->hasMany(Transaccion::class, 'tipo_transaccion_id', 'id');
    }
}
