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
        return $this->belongsTo(Facturacion::class, 'facturacion_m_id');
    }

    public function nota_i_boleta()
    {
        return $this->belongsTo(Boleta::class, 'boleta_id');
    }
    public function nota_i_boleta_manual()
    {
        return $this->belongsTo(Facturacion::class, 'boleta_m_id');
    }

    public static function count_month_comprobantes($fecha)
    {
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha
        $notas_credito  = Nota_Credito::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
        $mes = array(
            "cantidad" => $notas_credito->count()
        );
        return $mes;
    }
}
