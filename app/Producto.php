<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $guarded = [];
    // protected $table = 'productos';
/*
    public function categorias(){
        return $this->belongsTo(categorias::class,'categoria_id');
    }
*/

    public function marcas_i_producto(){
        return $this->belongsTo(Marca::class,'marca_id');
    }  
    public function categoria_i_producto(){
        return $this->belongsTo(Categoria::class,'categoria_id');
    }   
    public function familia_i_producto(){
        return $this->belongsTo(Familia::class,'familia_id');
    }  
    public function subfamilia_i_producto(){
        return $this->belongsTo(Subfamilia::class,'subfamilia_id');
    } 
    public function moneda_i_producto(){
        return $this->belongsTo(Moneda::class,'monedas_id');
    } 
    public function estado_i_producto(){
        return $this->belongsTo(Estado::class,'estado_id');
    }
    public function unidad_i_producto(){
        return $this->belongsTo(Unidad_medida::class,'unidad_medida_id');
    }
    public function tipo_afec_i_producto(){
        return $this->belongsTo(Tipo_afectacion::class,'tipo_afectacion_id');
    }

    public static function porcentaje_productos(){
        $productos = Producto::count();
        if ($productos === 0) {
            $data = [
                'total' => $productos,
                'activos' => 0,
                'inactivos' => 0,
                'anulados' => 0
            ];
            return $data;
        }
        $servicio_activos = Producto::where('estado', 1)->where('estado_anular', '0')->count();
        $servicio_inactivos = Producto::where('estado_activo', 1)->count();
        $servicio_anulados = Producto::where('estado_anular', 1)->count();

        $data = [
            'total' => $productos,
            'activos' => round(($servicio_activos / $productos) * 100, 1),
            'inactivos' => round(($servicio_inactivos / $productos) * 100, 1),
            'anulados' => round(($servicio_anulados / $productos) * 100, 1)
        ];
        return $data;
    }
}
