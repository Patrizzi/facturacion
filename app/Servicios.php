<?php

namespace App;

use Carbon\Carbon;
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

        // SERVICIOS CREADOS HOY
        $serv_act_count_day = Servicios::where('estado_anular', '0')->whereDate('created_at', Carbon::today())->count();
        $serv_anu_count_day = Servicios::where('estado_anular', '1')->whereDate('created_at', Carbon::today())->count();

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
        $servicio_activos = Servicios::where('estado_anular', '0')->count();
        $servicio_anulados = Servicios::where('estado_anular', 1)->count();

        $data = [
            'total' => $servicios,
            'activos' => $servicio_activos,
            'anulados' => $servicio_anulados,
            'cantidad_hoy_activos' => $serv_act_count_day,
            'cantidad_hoy_anulados' => $serv_anu_count_day,
        ];
        return $data;
    }
}
