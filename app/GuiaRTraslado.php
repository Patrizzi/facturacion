<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class GuiaRTraslado extends Model
{
    protected $table = 'guia_r_traslados';

	protected $guarded = [];

    public function kardex(){
        return $this->belongsTo(Kardex_entrada::class,'kardex_id');
    }
    public function almc_receptor(){
        return $this->belongsTo(Almacen::class,'almacen_receptor');
    }
    public function almc_emisor(){
        return $this->belongsTo(Almacen::class,'almacen_emisor');
    }
    public function vehiculo(){
        return $this->belongsTo(Vehiculo::class,'vehiculo_id');
    }
     public function personal(){
        return $this->belongsTo(Personal::class,'conductor_id');
    }
    public function vehiculo_publicos(){
        return $this->belongsTo(TransportePublico::class,'vehiculo_publico');
    }

    public static function codigo_guia_tr(){
        $ultima_entrada = GuiaRTraslado::orderby('created_at','DESC')->first();
        if(isset($ultima_entrada)){
            $numero = substr(strstr($ultima_entrada->cod_guia, '-'), 1);
            $numero++;
            $cantidad_registro=str_pad($numero, 8, "0", STR_PAD_LEFT);
            $codigo_guia='GRT'.'-'.$cantidad_registro;
        }else{
            $cantidad_registro=str_pad('1', 8, "0", STR_PAD_LEFT);
            $codigo_guia='GRT'.'-'.$cantidad_registro;
        }
        return $codigo_guia;
    }

}
