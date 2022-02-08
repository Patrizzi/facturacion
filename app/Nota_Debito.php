<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota_Debito extends Model
{
    protected $table  = 'nota_debito';

    protected $guarded = [];

    public function nota_i_facturacion(){
        return $this->belongsTo(Facturacion::class,'facturacion_id');
    }  

    public function nota_i_boleta(){
        return $this->belongsTo(Boleta::class,'boleta_id');
    } 
}
