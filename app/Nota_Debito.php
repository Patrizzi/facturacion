<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Nota_Debito extends Model
{
    protected $table  = 'nota_debito';

    protected $guarded = [];

    public function nota_i_facturacion()
    {
        return $this->belongsTo(Facturacion::class, 'facturacion_id');
    }

    public function nota_i_fac_manual()
    {
        return $this->belongsTo(Facturacion_m::class, 'facturacion_m_id');
    }

    public function nota_i_boleta()
    {
        return $this->belongsTo(Boleta::class, 'boleta_id');
    }
    public function nota_i_boleta_manual()
    {
        return $this->belongsTo(Boleta_m::class, 'boleta_m_id');
    }

    public static function count_month_comprobantes($fecha)
    {
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha
        $notas_debitos  = Nota_Debito::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
        $mes = array(
            "cantidad" => $notas_debitos->count()
        );
        return $mes;
    }
    public static function estado_sunat($id)
    {
        $nota_debito = Nota_Debito::find($id);
        switch ($nota_debito->n_electronica) {
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

    public static function revision_tipo(){

    }
}
