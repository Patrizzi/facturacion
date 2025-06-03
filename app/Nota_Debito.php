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

    public function nota_i_fac_manual(){
        return $this->belongsTo(Facturacion::class,'facturacion_m_id');
    }  

    public function nota_i_boleta(){
        return $this->belongsTo(Boleta::class,'boleta_id');
    } 
    public function nota_i_boleta_manual(){
        return $this->belongsTo(Facturacion::class,'boleta_m_id');
    }  

    public static function count_month_comprobantes($mes_año){

    }
}
