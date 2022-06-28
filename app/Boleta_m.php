<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boleta_m extends Model
{
    protected $table = 'boleta_m';

	protected $guarded = [];

    public function forma_pago(){
        return $this->belongsTo(Forma_pago::class,'forma_pago_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }
     public function moneda(){
        return $this->belongsTo(Moneda::class,'moneda_id');
    }

    
}
