<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BancoRegistro extends Model
{
    protected $table = 'banco_registros';

    protected $guarded = [];

    // public function clientes(){
    //   return $this->belongsTo(Cliente::class);
    // }

    public function bancos_i(){
        return $this->belongsTo(Banco::class,'banco_id');
    }

}


