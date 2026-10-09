<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'configs';

	protected $guarded = [];

    public static function default_config(){

        $apariencia=new Config();
        $apariencia->fondo_perfil='paisaje_noche.jpg';
        $apariencia->borde_foto="3px" ;
        $apariencia->color_borde_foto='#ffffff';
        $apariencia->foto_icono="defecto.png" ;
        $apariencia->foto_perfil= "0" ;
        $apariencia->letra="none" ;
        $apariencia->tamano_letra=" " ;
        $apariencia->color_sombra_nombre="#000000 " ;
        $apariencia->color_nombre= "#ffffff " ;
        $apariencia->tamano_letra_perfil= "12px " ;
        $apariencia->save();

        return $apariencia;
    }
}
