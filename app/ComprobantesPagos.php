<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ComprobantesPagos extends Model
{
    public static function count_day_comprobantes(){
        $fecha_conv = Carbon::now()->format('Y-m-d');
        $boleta_data = Boleta::whereDate('created_at', '=', $fecha_conv )->count();
        $boletaM_data = Boleta_m::whereDate('created_at', '=', $fecha_conv )->count();
        $factura_data = Facturacion::whereDate('created_at', '=', $fecha_conv )->count();
        $facturaM_data = Facturacion_m::whereDate('created_at', '=', $fecha_conv )->count();
        $nota_credito_data = Nota_Credito::whereDate('created_at', '=', $fecha_conv )->count();
        $nota_debito_data = Nota_Debito::whereDate('created_at', '=', $fecha_conv )->count();
        $guia_remision_data = Guia_remision::whereDate('created_at', '=', $fecha_conv )->count();
        $guia_remisionM_data = GuiaRemisionManual::whereDate('created_at', '=', $fecha_conv )->count();
        
        $count_mes = array(
            "boleta_day_count" => $boleta_data,
            "boleta_m_day_count" => $boletaM_data,
            "factura_day_count" => $factura_data,
            "factura_m_day_count" => $facturaM_data,
            "n_credito_day_count" => $nota_credito_data,
            "n_debito_day_count" => $nota_debito_data,
            "remision_day_count" => $guia_remision_data,
            "remision_m_day_count" => $guia_remisionM_data    
            
        );

		return $count_mes;
    }

}
