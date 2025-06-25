<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Guia_remision extends Model
{
    protected $table = 'guia_remision';

    protected $guarded = [];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function user_personal()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }
    public function personal()
    {
        return $this->belongsTo(Personal::class, 'conductor_id');
    }
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }
    public function vehiculo_publicos()
    {
        return $this->belongsTo(TransportePublico::class, 'vehiculo_publico');
    }
    // public function motivo_traslado(){
    //     return $this->belongsTo(MotivoTraslado::class,'cliente_id');
    // }   
    public static function count_month_comprobantes($fecha)
    {
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha
        $remision  = Guia_remision::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
        $total_cli = $remision->pluck('cliente_id')->unique()->count();

        $mes = array(
            "cantidad" => $remision->count(),
            "clientes" => $total_cli
        );
        return $mes;
    }
        public static function estado_sunat($id)
        {
            $guia_remision = Guia_remision::find($id);
            switch ($guia_remision->g_electronica) {
                case '1':
                    // $estado_sunat = "Enviado";
                    $estado_sunat = 1;
                    break;
                case '2':
                    // $estado_sunat = "Anulado";
                    $estado_sunat = 2;
                    break;
                default:
                    // $estado_sunat = "Sin enviar";
                    $estado_sunat = 0;
                    break;
            }
            return $estado_sunat;
        }
}
