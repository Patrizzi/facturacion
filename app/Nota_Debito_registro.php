<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota_Debito_registro extends Model
{
    protected $table  = 'nota_debito_registro';

    protected $guarded = [];

    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }

    public function servicio(){
        return $this->belongsTo(Servicios::class,'servicio_id');
    }

    public function factura_ids(){
        return $this->belongsTo(Facturacion::class,'facturacion_id');
    }
    public function nota_id(){
        return $this->belongsTo(Nota_Debito::class,'nota_debito_id');
    }
}
