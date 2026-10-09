<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'cajas';

    protected $fillable = [
        'semana',
        'anio',
        'fecha_apertura',
        'fecha_cierre',
        'estado'
    ];

    public function transacciones() {
        return $this->hasMany(Transaccion::class, 'caja_id', 'id');
    }
}
