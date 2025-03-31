<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
     protected $table = 'servicios';

    protected $guarded = [];

	 public function moneda(){
        return $this->belongsTo(Moneda::class,'moneda_id');
    }
     public function familia(){
        return $this->belongsTo(Familia::class,'familia_id');
    }
    public function subfamilia_i_serv(){
        return $this->belongsTo(Subfamilia::class,'subfamilia_id');
    } 
     public function marca(){
        return $this->belongsTo(Marca::class,'marca_id');
    }
    public function tipo_afec_i_serv(){
        return $this->belongsTo(Tipo_afectacion::class,'tipo_afectacion_id');
    }

    public static function porcentaje_servicios(){
        $servicios = Servicios::count();
        if ($servicios === 0) {
            $data = [
                'total' => $servicios,
                'activos' => 0,
                'inactivos' => 0,
                'anulados' => 0
            ];
            return $data;
        }
        $servicio_activos = Servicios::where('estado_activo', 0)->where('estado_anular', '0')->count();
        $servicio_inactivos = Servicios::where('estado_activo', 1)->count();
        $servicio_anulados = Servicios::where('estado_anular', 1)->count();

        $data = [
            'total' => $servicios,
            'activos' => round(($servicio_activos / $servicios) * 100, 1),
            'inactivos' => round(($servicio_inactivos / $servicios) * 100, 1),
            'anulados' => round(($servicio_anulados / $servicios) * 100, 1)
        ];
        return $data;
    }
}
