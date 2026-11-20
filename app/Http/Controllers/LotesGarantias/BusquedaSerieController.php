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
            'boletaRegistroAgrupado.boleta_i.cliente',
            'notaVentaRegistro.notaVenta.cliente',
            'producto',
            'lote.kardexEntradaRegistro.kardex_entrada',
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

        $facturacionRegistro = $serie->facturacionRegistro;
        $boletaRegistro = $serie->detalle_boleta;
        $notaVentaRegistro = $serie->notaVentaRegistro;
        $factura = $facturacionRegistro ? $facturacionRegistro->factura_ids : null;
        $boleta = $boletaRegistro ? $boletaRegistro->boleta_i : null;
        $notaVenta = $notaVentaRegistro ? $notaVentaRegistro->notaVenta : null;
        $fechaVentaRaw = $factura
            ? ($factura->getOriginal('fecha_emision') ?: $factura->created_at)
            : ($boleta
                ? ($boleta->getOriginal('fecha_emision') ?: $boleta->created_at)
                : ($notaVenta ? ($notaVenta->getOriginal('fecha_emision') ?: $notaVenta->created_at) : null));
        $fechaVenta = $fechaVentaRaw ? Carbon::parse($fechaVentaRaw) : null;
        $mesesGarantia = $this->mesesGarantia(optional($serie->producto)->garantia);
        $vencimiento = $fechaVenta && $mesesGarantia
            ? (clone $fechaVenta)->addMonths($mesesGarantia)
            : null;
        $estadoGarantia = $vencimiento
            ? (Carbon::today()->lte($vencimiento) ? 'Vigente' : 'Vencido')
            : 'No disponible';
        $diasRestantes = $vencimiento && Carbon::today()->lte($vencimiento)
            ? Carbon::today()->diffInDays($vencimiento)
            : 0;

        $facturacion = $serie->facturacionRegistro?->factura_ids;
        $boleta = $serie->detalle_boleta?->boleta_i;
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

        $historial = SerieProducto::with([
            'estadoProducto',
            'facturacionRegistro.factura_ids',
            'boletaRegistro.boleta_i',
            'boletaRegistroAgrupado.boleta_i',
            'notaVentaRegistro.notaVenta',
        ])->where('codigo_producto', $serie->codigo_producto)
            ->where('id', '!=', $serie->id)
            ->latest()
            ->take(10)
            ->get()
            ->map(function (SerieProducto $relacionada) {
                $facturaRelacionada = optional($relacionada->facturacionRegistro)->factura_ids;
                $boletaRelacionada = optional($relacionada->detalle_boleta)->boleta_i;
                $notaVentaRelacionada = optional($relacionada->notaVentaRegistro)->notaVenta;
                $fechaVentaRelacionada = $facturaRelacionada
                    ? ($facturaRelacionada->getOriginal('fecha_emision') ?: $facturaRelacionada->created_at)
                    : ($boletaRelacionada
                        ? ($boletaRelacionada->getOriginal('fecha_emision') ?: $boletaRelacionada->created_at)
                        : ($notaVentaRelacionada ? ($notaVentaRelacionada->getOriginal('fecha_emision') ?: $notaVentaRelacionada->created_at) : null));

                return [
                    'id' => $relacionada->id,
                    'numero_serie' => $relacionada->numero_serie,
                    'codigo_producto' => $relacionada->codigo_producto,
                    'codigo_lote' => $relacionada->codigo_lote,
                    'estado' => optional($relacionada->estadoProducto)->nombre_estado ?? 'En Stock',
                    'fecha_venta' => $fechaVentaRelacionada ? Carbon::parse($fechaVentaRelacionada)->format('Y-m-d') : '--',
                    'fecha_vencimiento_garantia' => '--',
                    'ubicacion' => optional($relacionada->estadoProducto)->ubicacion ?? 'Almacén Principal',
                    'calidad' => optional($relacionada->estadoProducto)->calidad ?? 'A',
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
                    'fecha_venta' => $fechaVenta ? $fechaVenta->format('Y-m-d') : '--',
                    'fecha_vencimiento' => $vencimiento ? $vencimiento->format('Y-m-d') : '--',
                    'dias_restantes' => $diasRestantes . ' días',
                ],
                'estado' => [
                    'condicion' => $serie->estado,
                    'ubicacion' => $serie->ubicacion ?: 'Almacén Principal',
                    'calidad' => $serie->calidad ?: 'A',
                    'ultimo_movimiento' => $serie->fecha_ultimo_movimiento
                        ? Carbon::parse($serie->fecha_ultimo_movimiento)->format('Y-m-d H:i')
                        : '--',
                ],
            ],
            'historial_relacionadas' => $historial,
        ]);
    }

    private function mesesGarantia($garantia): ?int
    {
        if ($garantia === null || trim((string) $garantia) === '' || preg_match('/(\d+)/', (string) $garantia, $coincidencia) !== 1) {
            return null;
        }

        $cantidad = (int) $coincidencia[1];
        $texto = mb_strtolower((string) $garantia);
        if (strpos($texto, 'año') !== false || strpos($texto, 'ano') !== false || strpos($texto, 'year') !== false) {
            $cantidad *= 12;
        } elseif (strpos($texto, 'día') !== false || strpos($texto, 'dia') !== false || strpos($texto, 'day') !== false) {
            $cantidad = (int) ceil($cantidad / 30);
        } elseif (strpos($texto, 'semana') !== false || strpos($texto, 'week') !== false) {
            $cantidad = (int) ceil($cantidad / 4);
        }

        return $cantidad > 0 ? $cantidad : null;
    }
}
