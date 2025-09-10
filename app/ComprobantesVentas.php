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
        $fechaYmd = Carbon::createFromFormat('Y-m-d', $fecha)->format('d-m-Y');
        $fechadmy = Carbon::createFromFormat('Y-m-d', $fecha)->format('Y-m-d');
        $igv = Igv::first();
        $empresa = Empresa::first();
        if (!isset($cliente_search)) {
            return [
                'success' => false,
                'error' => 'Datos no coinciden'
            ];
        }

        $boleta = Boleta::where('codigo_boleta', $codigo)
            ->where('cliente_id', $cliente_search->id)
            ->where(function ($query) use ($fechaYmd, $fechadmy) {
                $query->where('fecha_emision', $fechaYmd)
                    ->orWhere('fecha_emision', $fechadmy);
            })
            ->first();
        $esBoletaM = false;

        if (!$boleta) {
            $boleta = Boleta_m::where('codigo_boleta', $codigo)
                ->where('cliente_id', $cliente_search->id)
                ->where(function ($query) use ($fechaYmd, $fechadmy) {
                    $query->where('fecha_emision', $fechaYmd)
                        ->orWhere('fecha_emision', $fechadmy);
                })
                ->first();
            if (!$boleta) {
                return [
                    'success' => false,
                    'error' => 'Datos no coinciden'
                ];
            }
            $esBoletaM = true;
        }
        $total = explode(' ', $boleta->total_precio);
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
            $subtotal = $reg->precio_unitario_comi ?? $reg->precio * $reg->cantidad;

            $items[] = [
                'item'            => $reg->articulo_descripcion,
                'cantidad'        => $reg->cantidad,
                'precio_unitario' => number_format(round((($reg->precio_unitario_comi ?? $reg->precio)), 2), 2),
                'precio_total'    => number_format(round($subtotal, 2), 2),
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
                'pdf_link'   => $esBoletaM ? route('pdf_bol', ['id' => $boleta->id, 'name' => $boleta->codigo_boleta]) : route('boleta_manual.pdf', ['id' => $boleta->id, 'name' => $boleta->codigo_boleta]),
                'xml_link'   => asset('facturas_electronicas/') . '/' . $empresa->ruc . '-03-' . $boleta->codigo_boleta . '.xml',
                'print_link' => $esBoletaM ? route('boleta.print', $boleta->id) : route('boleta.print', $boleta->id),
            ]
        ];
    }

    public static function validar_factura($cliente, $codigo, $fecha, $monto_total)
    {
        $cliente_search = Cliente::where('numero_documento', $cliente)->first();
        $fechaYmd = Carbon::createFromFormat('Y-m-d', $fecha)->format('d-m-Y');
        $fechadmy = Carbon::createFromFormat('Y-m-d', $fecha)->format('Y-m-d');
        $igv = Igv::first();
        $empresa = Empresa::first();
        if (!isset($cliente_search)) {
            return [
                'success' => false,
                'error' => 'Datos no coinciden 1'
            ];
        }
        $factura = Facturacion::where('codigo_fac', $codigo)
            ->where('cliente_id', $cliente_search->id)
            ->where(function ($query) use ($fechaYmd, $fechadmy) {
                $query->where('fecha_emision', $fechaYmd)
                    ->orWhere('fecha_emision', $fechadmy);
            })
            ->first();
        $esFacturaM = false;
        if (!$factura) {
            $factura = Facturacion_m::where('codigo_fac', $codigo)
                ->where('cliente_id', $cliente_search->id)
                ->where(function ($query) use ($fechaYmd, $fechadmy) {
                    $query->where('fecha_emision', $fechaYmd)
                        ->orWhere('fecha_emision', $fechadmy);
                })

                ->first();
            if (!$factura) {
                return [
                    'success' => false,
                    'error' => 'Datos no coinciden 2'
                ];
            }
            $esFacturaM = true;
        }
        $total = explode(' ', $factura->total_precio);
        if ($total[1] != $monto_total) {
            return [
                'success' => false,
                'error' => 'Datos no coinciden 3'
            ];
        }
        $registros = $esFacturaM
            ? $factura->registros_m
            : $factura->registros;

        $items = [];
        foreach ($registros as $reg) {
            $subtotal = $reg->precio_unitario_comi ?? $reg->precio * $reg->cantidad;

            $items[] = [
                'item'            => $reg->articulo_descripcion,
                'cantidad'        => $reg->cantidad,
                'precio_unitario' => number_format(round((($reg->precio_unitario_comi ?? $reg->precio)), 2), 2),
                'precio_total'    => number_format(round($subtotal, 2), 2),
            ];
        }

        return [
            'success' => true,
            'data' => [
                'codigo'     => $factura->codigo_fac,
                'fecha'      => $factura->fecha_emision,
                'cliente'    => optional($factura->cliente)->nombre,
                'total'      => $factura->total_precio,
                'tipo'       => $esFacturaM ? 'Factura Manual' : 'Factura',
                'registros'  => $items,
                'pdf_link'   => $esFacturaM ? route('pdf_fac_m', ['id' => $factura->id, 'name' => $factura->codigo_fac]) : route('pdf_fac', ['id' => $factura->id, 'name' => $factura->codigo_fac]),
                'xml_link'   => asset('facturas_electronicas/') . '/' . $empresa->ruc . '-01-' . $factura->codigo_fac . '.xml',
                'print_link' =>  $esFacturaM ? route('pdf_fac_m', $factura->id) : route('facturacion.print', $factura->id),
            ]
        ];
    }

    public static function validar_remision($cliente, $codigo, $fecha)
    {
        $cliente_search = Cliente::where('numero_documento', $cliente)->first();
        $fecha_emision = Carbon::createFromFormat('Y-m-d', $fecha)->format('Y/m/d');

        // dd($fecha_emision);
        $igv = Igv::first();
        $empresa = Empresa::first();
        if (!isset($cliente_search)) {
            return [
                'success' => false,
                'error' => 'Datos no coinciden'
            ];
        }
        $guia = Guia_remision::where('cod_guia', $codigo)
            ->where('cliente_id', $cliente_search->id)
            ->where('fecha_emision', $fecha_emision)
            ->first();
        // dd($guia);
        $esGuiaM = false;

        if (!$guia) {
            $fecha_emision = Carbon::createFromFormat('Y-m-d', $fecha)->format('d/m/Y');
            $guia = GuiaRemisionManual::where('cod_guia', $codigo)
                ->where('cliente_id', $cliente_search->id)
                ->where('fecha_emision', $fecha_emision)
                ->first();
            if (!$guia) {
                return [
                    'success' => false,
                    'error' => 'Datos no coinciden'
                ];
            }
            $esGuiaM = true;
        }
        $registros = $esGuiaM
            ? $guia->registros_m
            : $guia->registros;
        // dd($registros);
        $items = [];
        foreach ($registros as $reg) {
            $peso_total = $reg->peso ?? $reg->peso * $reg->cantidad;

            $items[] = [
                'item'            => $reg->producto->nombre.' '.$reg->descripcion,
                'cantidad'        => $reg->cantidad,
                'peso_unitario' => $reg->peso,
                'peso_total'    => $peso_total,
            ];
        }
        return [
            'success' => true,
            'data' => [
                'codigo'     => $guia->cod_guia,
                'fecha'      => $guia->fecha_emision,
                'cliente'    => optional($guia->cliente)->nombre,
                'total'      => $guia->peso_total,
                'tipo'       => $esGuiaM ? 'Guia Manual' : 'Guia',
                'registros'  => $items,
                'pdf_link'   => $esGuiaM ? route('remision_m.pdf', $guia->id) :  route('pdf_guia', $guia->id),
                'xml_link'   => asset('facturas_electronicas/') . '/R-' . $empresa->ruc . '-09-' . $guia->cod_guia . '.xml',
                'print_link' =>  $esGuiaM ? route('remision_m', $guia->id) : route('guia_remision.print', $guia->id),
            ]
        ];
    }

    public static function validar_debito($cliente, $codigo, $fecha, $monto_total)
    {
        $cliente_search = Cliente::where('numero_documento', $cliente)->first();
        $fecha_emision = Carbon::createFromFormat('Y-m-d', $fecha)->format('Y-m-d');
        $igv = Igv::first();
        $empresa = Empresa::first();
        if (!isset($cliente_search)) {
            return [
                'success' => false,
                'error' => 'Datos no coinciden'
            ];
        }

        $debito = Nota_Debito::where('codigo_n_d', $codigo)
            ->whereDate('fecha_emision', $fecha_emision)
            ->first();
        if (!$debito) {
            return [
                'success' => false,
                'error' => 'Datos no coinciden 2'
            ];
        }
        if ($cliente_search->id != $debito->cliente) {
            return [
                'success' => false,
                'error' => 'Datos no coinciden'
            ];
        }
        $total = explode(' ', $debito->total_precio);
        // dd($total[0]);
        if ($total[1] != $monto_total) {
            return [
                'success' => false,
                'error' => 'Datos no coinciden'
            ];
        }
        $registros = $debito->detalles;
        $items = [];
        foreach ($registros as $reg) {
            $subtotal = $reg->precio_unitario_comi ?? $reg->precio * $reg->cantidad;

            $items[] = [
                'item'            => $reg->producto->nombre,
                'cantidad'        => $reg->cantidad,
                'precio_unitario' => number_format(round((($reg->precio_unitario_comi ?? $reg->precio)), 2), 2),
                'precio_total'    => number_format(round($subtotal, 2), 2),
            ];
        }

        return [
            'success' => true,
            'data' => [
                'codigo'     => $debito->codigo_n_d,
                'fecha'      => $debito->fecha_emision,
                'cliente'    => optional($cliente_search)->nombre,
                'total'      => $debito->total_precio,
                'registros'  => $items,
                'pdf_link'   => route('nota_debito.pdf', ['id' => $debito->id, 'name' => $debito->codigo_n_d]),
                'xml_link'   => asset('facturas_electronicas/') . '/R-' . $empresa->ruc . '-07-' . $debito->codigo_n_c . '.xml',
                'print_link' => route('nota_debito.print', $debito->id),
            ]
        ];
    }

    public static function validar_credito($cliente, $codigo, $fecha, $monto_total)
    {
        $cliente_search = Cliente::where('numero_documento', $cliente)->first();
        $fecha_emision = Carbon::createFromFormat('Y-m-d', $fecha)->format('Y-m-d');
        $igv = Igv::first();
        $empresa = Empresa::first();
        if (!isset($cliente_search)) {
            return response()->json([
                'success' => false,
                'error' => 'Datos no coinciden'
            ], 400);
        }

        $credito = Nota_Credito::where('codigo_n_c', $codigo)
            ->whereDate('fecha_emision', $fecha_emision)
            ->first();
        if (!$credito) {
            return [
                'success' => false,
                'error' => 'Datos no coinciden 2'
            ];
        }
        if ($cliente_search->id != $credito->cliente) {
            return [
                'success' => false,
                'error' => 'Datos no coinciden'
            ];
        }
        $total = explode(' ', $credito->total_precio);
        // dd($total[0]);
        if ($total[1] != $monto_total) {
            return [
                'success' => false,
                'error' => 'Datos no coinciden'
            ];
        }
        $registros = $credito->detalles;
        $items = [];
        foreach ($registros as $reg) {
            $subtotal = $reg->precio * $reg->cantidad;

            $items[] = [
                'item'            => $reg->articulo_descripcion,
                'cantidad'        => $reg->cantidad,
                'precio_unitario' => number_format(round((($reg->precio)), 2), 2),
                'precio_total'    => number_format(round($subtotal, 2), 2),
            ];
        }

        return [
            'success' => true,
            'data' => [
                'codigo'     => $credito->codigo_n_c,
                'fecha'      => $credito->fecha_emision,
                'cliente'    => optional($cliente_search)->nombre,
                'total'      => $credito->total_precio,
                'registros'  => $items,
                'pdf_link'   => route('nota_credito.pdf', ['id' => $credito->id, 'name' => $credito->codigo_n_c]),
                'xml_link'   => asset('facturas_electronicas/') . '/R-' . $empresa->ruc . '-07-' . $credito->codigo_n_c . '.xml',
                'print_link' => route('nota_credito.print', $credito->id),
            ]
        ];
    }
}
