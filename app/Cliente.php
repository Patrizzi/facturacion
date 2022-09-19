<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    
    protected $guarded = [];

    public static function cliente_update($id_cliente){
        $cliente = Cliente::where('id',$id_cliente)->first();
        if(empty($cliente->empresa)){
            $cliente->empresa = $cliente->nombre;
            $cliente->save();
        }
        if(empty($cliente->ubigeo)){
            $cliente->cod_postal = '150101';
            $cliente->save();
        }
    }
}
