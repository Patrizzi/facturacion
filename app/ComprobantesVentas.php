<?php

namespace App;

use App\Http\Controllers\FacturacionMController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ComprobantesVentas extends Model
{
    public static function count_day_comprobantes()
    {
        $fecha_conv = Carbon::now()->format('Y-m-d');
        $boleta_data = Boleta::whereDate('created_at', '=', $fecha_conv)->count();
        $boletaM_data = Boleta_m::whereDate('created_at', '=', $fecha_conv)->count();
        $factura_data = Facturacion::whereDate('created_at', '=', $fecha_conv)->count();
        $facturaM_data = Facturacion_m::whereDate('created_at', '=', $fecha_conv)->count();
        $nota_credito_data = Nota_Credito::whereDate('created_at', '=', $fecha_conv)->count();
        $nota_debito_data = Nota_Debito::whereDate('created_at', '=', $fecha_conv)->count();
        $guia_remision_data = Guia_remision::whereDate('created_at', '=', $fecha_conv)->count();
        $guia_remisionM_data = GuiaRemisionManual::whereDate('created_at', '=', $fecha_conv)->count();

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

    public static function count_month_comprobantes($mes_año)
    {

        $boleta_mes = Boleta::count_month_comprobantes($mes_año);
        $boletaM_mes = Boleta_m::count_month_comprobantes($mes_año);

        $factura_mes = Facturacion::count_month_comprobantes($mes_año);
        $facturaM_mes = Facturacion_m::count_month_comprobantes($mes_año);

        $notaCredito_mes = Nota_Credito::count_month_comprobantes($mes_año);
        $notaDebito_mes = Nota_Debito::count_month_comprobantes($mes_año);

        $guia_remision_data = Guia_remision::count_month_comprobantes($mes_año);
        $guia_remisionM_data = GuiaRemisionManual::count_month_comprobantes($mes_año);

        $count_mes = array(
            "boleta_month_count" => $boleta_mes,
            "boleta_m_month_count" => $boletaM_mes,
            "factura_month_count" => $factura_mes,
            "factura_m_month_count" => $facturaM_mes,
            "nota_credito_month_count" => $notaCredito_mes,
            "nota_debito_month_count" => $notaDebito_mes,
            "guia_remision_month_count" => $guia_remision_data,
            "guia_remisionM_month_count" => $guia_remisionM_data
        );
        return $count_mes;
    }

    public static function count_day_ventas()
    {
        // Fecha de Hoy
        $fecha_conv = Carbon::now()->format('Y-m-d');

        $cotizacion_dia = Cotizacion::whereDate('created_at', '=', $fecha_conv)->count();
        $cotizacion_manual_dia = CotizacionManual::whereDate('created_at', '=', $fecha_conv)->count();
        $nota_venta_dia = NotaVenta::whereDate('created_at', '=', $fecha_conv)->count();


        $count_day_ventas = array(
            "cotizacion_day_count" => $cotizacion_dia,
            "cotizacion_m_day_count" => $cotizacion_manual_dia,
            "nota_venta_day_count" => $nota_venta_dia

        );

        return $count_day_ventas;
    }

    public static function count_month_ventas($mes_año)
    {
        $cotizacion_mes = Cotizacion::count_mes($mes_año);
        $cotizacionM_mes = CotizacionManual::count_mes($mes_año);
        $nota_venta_mes = NotaVenta::count_mes($mes_año);

        $count_mes = array(
            "cotizacion_month_count" => $cotizacion_mes,
            "cotizacion_m_month_count" => $cotizacionM_mes,
            "nota_venta_month_count" => $nota_venta_mes
        );
        return $count_mes;
    }


    public static function moneda_principal_convert($moneda_id, $total)
    {
        $principal = Moneda::where('principal', 1)->first();
        $cambio = TipoCambio::orderBy('created_at', 'desc')->first();
        if ($principal->tipo == "nacional") { //SOLES
            if ($moneda_id == 1) { //SOLES	
                $total_conv = $total;
            } else { //DOLARES
                $total_conv = $total * $cambio->paralelo;
            }
        } else { //DOLAR
            if ($moneda_id == 2) { //DOLAR
                $total_conv = $total;
            } else { //SOLES
                $total_conv = $total / $cambio->paralelo;
            }
        }
        return $total_conv;
    }
}
