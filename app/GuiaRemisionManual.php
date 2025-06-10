<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class GuiaRemisionManual extends Model
{
    protected $table = 'guia_remision_manual';

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

    public static function count_month_comprobantes($fecha)
    {
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha
        $remision_M  = GuiaRemisionManual::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
        $total_cli = $remision_M->pluck('cliente_id')->unique()->count();
        $mes = array(
            "cantidad" => $remision_M->count(),
            "clientes" => $total_cli
        );
        return $mes;
    }
}
