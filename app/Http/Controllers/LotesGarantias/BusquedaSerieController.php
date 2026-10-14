<?php

namespace App\Http\Controllers\LotesGarantias;

use App\Http\Controllers\Controller;
use App\Http\Requests\LotesGarantias\BusquedaSerieRequest;
use App\SerieProducto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BusquedaSerieController extends Controller
{
    public function ajaxBuscarSerie(BusquedaSerieRequest $request)
    {
        // La validación ya pasó automáticamente mediante BusquedaSerieRequest
        $numeroSerie = trim((string) $request->input('numero_serie', ''));
        $codigoProducto = trim((string) $request->input('codigo_producto', ''));

        // Eager Loading para prevenir N+1 queries
        $query = SerieProducto::with([
            'facturacionRegistro.factura_ids.cliente',
            'boletaRegistro.boleta_i.cliente',
            'notaVentaRegistro.notaVenta.cliente',
            'garantiaActual',
            'estadoProducto',
        ]);

        if ($numeroSerie !== '') {
            $query->where('numero_serie', 'like', '%' . $numeroSerie . '%');
        }

        if ($codigoProducto !== '') {
            $query->where('codigo_producto', 'like', '%' . $codigoProducto . '%');
        }

        $serie = $query
            ->orderByRaw('CASE WHEN numero_serie = ? THEN 0 ELSE 1 END', [$numeroSerie])
            ->orderByRaw('CASE WHEN codigo_producto = ? THEN 0 ELSE 1 END', [$codigoProducto])
            ->first();

        if (!$serie) {
            return response()->json([
                'success' => false,
                'encontrado' => false,
                'message' => 'No se encontró ningún registro para la serie o código ingresado.',
            ], 404);
        }

        $lote = null;
        if ($serie->lote_id && Schema::hasTable('lotes')) {
            $lote = DB::table('lotes')->where('id', $serie->lote_id)->first();
        }

        $estadoGarantia = 'No Aplica';
        $diasRestantes = 0;

        $fechaVencimientoGarantia = $serie->garantiaActual?->fecha_vencimiento
            ? Carbon::parse($serie->garantiaActual->fecha_vencimiento)->toDateString()
            : ($serie->fecha_vencimiento_garantia ? Carbon::parse($serie->fecha_vencimiento_garantia)->toDateString() : null);

        $fechaVentaGarantia = $serie->garantiaActual?->fecha_venta
            ? Carbon::parse($serie->garantiaActual->fecha_venta)->toDateString()
            : ($serie->fecha_venta ? Carbon::parse($serie->fecha_venta)->toDateString() : null);

        if ($fechaVencimientoGarantia) {
            $vencimiento = Carbon::parse($fechaVencimientoGarantia)->endOfDay();
            if (Carbon::today()->lte($vencimiento)) {
                $estadoGarantia = $serie->garantiaActual?->estado_garantia ?? 'Vigente';
                $diasRestantes = Carbon::today()->diffInDays($vencimiento);
            } else {
                $estadoGarantia = 'Vencido';
            }
        }

        $facturacion = $serie->facturacionRegistro?->factura_ids;
        $boleta = $serie->boletaRegistro?->boleta_i;
        $notaVenta = $serie->notaVentaRegistro?->notaVenta;

        $cliente = null;
        $numeroComprobante = null;

        if ($facturacion?->cliente) {
            $cliente = $facturacion->cliente;
            $numeroComprobante = $facturacion->codigo_fac;
        } elseif ($boleta?->cliente) {
            $cliente = $boleta->cliente;
            $numeroComprobante = $boleta->codigo_boleta;
        } elseif ($notaVenta?->cliente) {
            $cliente = $notaVenta->cliente;
            $numeroComprobante = $notaVenta->cod_nota_venta;
        }

        $clienteData = [
            'nombre_cliente' => $cliente?->nombre ?? 'En Stock',
            'telefono'       => $cliente?->telefono ?? '--',
            'email'          => $cliente?->email ?? $cliente?->correo ?? '--',
            'numero_factura' => $numeroComprobante ?? 'No asignado',
        ];

        $historial = SerieProducto::with(['estadoProducto', 'garantiaActual'])
            ->where('codigo_producto', $serie->codigo_producto)
            ->where('id', '!=', $serie->id)
            ->latest()
            ->take(10)
            ->get()
            ->map(function (SerieProducto $relacionada) {
                $fechaVentaRel = $relacionada->garantiaActual?->fecha_venta
                    ? Carbon::parse($relacionada->garantiaActual->fecha_venta)->toDateString()
                    : ($relacionada->fecha_venta ? Carbon::parse($relacionada->fecha_venta)->toDateString() : '--');
                $fechaVencimientoRel = $relacionada->garantiaActual?->fecha_vencimiento
                    ? Carbon::parse($relacionada->garantiaActual->fecha_vencimiento)->toDateString()
                    : ($relacionada->fecha_vencimiento_garantia ? Carbon::parse($relacionada->fecha_vencimiento_garantia)->toDateString() : '--');

                return [
                    'id' => $relacionada->id,
                    'numero_serie' => $relacionada->numero_serie,
                    'codigo_producto' => $relacionada->codigo_producto,
                    'codigo_lote' => $relacionada->codigo_lote,
                    'estado' => $relacionada->estadoProducto?->nombre_estado ?? ($relacionada->estado ?: 'En Stock'),
                    'fecha_venta' => $fechaVentaRel,
                    'fecha_vencimiento_garantia' => $fechaVencimientoRel,
                    'ubicacion' => $relacionada->estadoProducto?->ubicacion ?? ($relacionada->ubicacion ?: 'Almacén Principal'),
                    'calidad' => $relacionada->estadoProducto?->calidad ?? ($relacionada->calidad ?: 'A'),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'encontrado' => true,
            'serie' => [
                'numero_serie' => $serie->numero_serie,
                'codigo_producto' => $serie->codigo_producto,
                'cliente' => $clienteData,
                'lote' => [
                    'codigo' => optional($lote)->lote ?: ($serie->codigo_lote ?: '--'),
                    'proveedor' => optional($lote)->proveedor_nombre ?: '--',
                    'unidades' => optional($lote)->cantidad ?: '--',
                    'fecha_produccion' => optional($lote)->fecha_produccion ?: '--',
                ],
                'garantia' => [
                    'estado' => $estadoGarantia,
                    'fecha_venta' => $fechaVentaGarantia ?: '--',
                    'fecha_vencimiento' => $fechaVencimientoGarantia ?: '--',
                    'dias_restantes' => $diasRestantes . ' días',
                ],
                'estado' => [
                    'condicion' => $serie->estadoProducto?->nombre_estado ?? ($serie->estado ?: 'En Stock'),
                    'ubicacion' => $serie->estadoProducto?->ubicacion ?? ($serie->ubicacion ?: 'Almacén Principal'),
                    'calidad' => $serie->estadoProducto?->calidad ?? ($serie->calidad ?: 'A'),
                    'ultimo_movimiento' => $serie->fecha_ultimo_movimiento
                        ? Carbon::parse($serie->fecha_ultimo_movimiento)->format('Y-m-d H:i')
                        : '--',
                ],
            ],
            'historial_relacionadas' => $historial,
        ]);
    }
}
