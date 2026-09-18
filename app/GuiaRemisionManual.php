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

    public function registros_m(){
        return $this->hasMany(GuiaRemisionMRegistros::class, 'guia_remision_m_id');
    }
    public function getFechaEmisionAttribute(){
        if (empty($this->attributes['fecha_emision'])) {
            return null;
        }

        try {
            $fecha_raw = $this->attributes['fecha_emision'];

            // Si ya está en formato DD/MM/YYYY, devolverlo tal como está
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $fecha_raw)) {
                return $fecha_raw;
            }

            // Si está en formato YYYY-MM-DD, convertir a DD/MM/YYYY
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_raw)) {
                return Carbon::createFromFormat('Y-m-d', $fecha_raw)->format('d/m/Y');
            }

            // Si está en formato DD-MM-YYYY, convertir a DD/MM/YYYY
            if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $fecha_raw)) {
                return Carbon::createFromFormat('d-m-Y', $fecha_raw)->format('d/m/Y');
            }

            // Para otros formatos, intentar parsing automático
            return Carbon::parse($fecha_raw)->format('d/m/Y');

        } catch (\Exception $e) {
            return $this->attributes['fecha_emision'];
        }
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

    public static function estado_sunat($id)
    {
        $guia_remision = GuiaRemisionManual::find($id);
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
    public static function normalizar_fechas($fecha)
    {
        if (empty($fecha)) {
            return null;
        }

        $formatos = ['Y-m-d', 'd/m/Y', 'Y-m-d H:i:s', 'd-m-Y'];
        foreach ($formatos as $formato) {
            try {
                return Carbon::createFromFormat($formato, $fecha)->format('d-m-Y');
            } catch (\Exception $e) {
                // sigue probando con el siguiente formato
            }
        }
    }
}
