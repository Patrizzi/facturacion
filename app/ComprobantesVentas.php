<?php

namespace App;

use App\Http\Controllers\FacturacionMController;
use Carbon\Carbon;
use Facade\FlareClient\Http\Client;
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
        $clientes_dia = Cliente::whereDate('created_at', '=', $fecha_conv)->count();


        $count_day_ventas = array(
            "cotizacion_day_count" => $cotizacion_dia,
            "cotizacion_m_day_count" => $cotizacion_manual_dia,
            "nota_venta_day_count" => $nota_venta_dia,
            "cliente_day_count" => $clientes_dia

        );

        return $count_day_ventas;
    }

    public static function count_month_ventas($mes_año)
    {
        $cotizacion_mes = Cotizacion::count_mes($mes_año);
        $cotizacionM_mes = CotizacionManual::count_mes($mes_año);
        $nota_venta_mes = NotaVenta::count_mes($mes_año);
        $clientes_mes = Cliente::count_mes($mes_año);

        $count_mes = array(
            "cotizacion_month_count" => $cotizacion_mes,
            "cotizacion_m_month_count" => $cotizacionM_mes,
            "nota_venta_month_count" => $nota_venta_mes,
            "clientes_month_count" => $clientes_mes
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

    public static function validar_boleta($cliente, $codigo, $fecha, $monto_total)
    {
        $cliente_search = Cliente::where('numero_documento', $cliente)->first();
        $fecha_emision = Carbon::createFromFormat('Y-m-d', $fecha)->format('d-m-Y');
        if (!isset($cliente_search)) {
            return [
                'success' => false,
                'error' => 'Datos no coinciden'
            ];
        }

        $boleta = Boleta::where('codigo_boleta', $codigo)
            ->where('cliente_id', $cliente_search->id)
            ->where('fecha_emision', $fecha_emision)
            ->first();
        $esBoletaM = false;

        if (!$boleta) {
            $boleta = Boleta_m::where('codigo_boleta', $codigo)
                ->where('cliente_id', $cliente_search->id)
                ->where('fecha_emision', $fecha_emision)
                ->first();
            if (!$boleta) {
                return [
                    'success' => false,
                    'error' => 'Datos no coinciden'
                ];
            }
            $esBoletaM = true;
        }
        $total = explode(' ',$boleta->total_precio);
        // dd($total[0]);
        if ($total[1] != $monto_total) {
            return [
                'success' => false,
                'error' => 'Datos no coinciden'
            ];
        }

        $registros = $esBoletaM
            ? $boleta->registros_m
            : $boleta->registros;

        $items = [];
        foreach ($registros as $reg) {
            $subtotal = $reg->precio_unitario_comi * $reg->cantidad;

            $items[] = [
                'item'            => optional($reg->producto)->nombre,
                'cantidad'        => $reg->cantidad,
                'precio_unitario' => $reg->precio_unitario_comi,
                'precio_total'    => $subtotal,
            ];
        }

        // return $boleta;

        return [
            'success' => true,
            'data' => [
                'codigo'     => $boleta->codigo_boleta,
                'fecha'      => $boleta->fecha_emision,
                'cliente'    => optional($boleta->cliente)->nombre,
                'total'      => $boleta->total_precio,
                'tipo'       => $esBoletaM ? 'Boleta Manual' : 'Boleta',
                'registros'  => $items,
            ]
        ];
    }

    public static function validar_factura()
    {
        
    }
}
