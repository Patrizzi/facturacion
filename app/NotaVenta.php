<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaVenta extends Model
{
    protected $table = 'nota_venta';

    protected $guarded = [];
       public function almacen(){
        return $this->belongsTo(Almacen::class,'almacen_id');
    }
     public function user(){
        return $this->belongsTo(User::class,'user_registrado');
    }
     public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }
     public function forma_pago(){
        return $this->belongsTo(Forma_pago::class,'forma_pago');
    }
     public function moneda(){
        return $this->belongsTo(Moneda::class,'moneda_id');
    }

}
