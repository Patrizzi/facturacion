<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditosAdelantosRegistros extends Model
{
    protected $table = 'creditos_adelantos_registros';

    protected $guarded = [];

    public function cuotas(){
        return $this->belongsTo(Cuotas_credito::class,'cuota_cred_id');
    }
}
