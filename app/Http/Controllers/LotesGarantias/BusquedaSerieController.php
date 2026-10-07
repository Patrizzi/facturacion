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
        $query = SerieProducto::with('facturacionRegistro.facturacion.cliente');

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

        if ($serie->fecha_vencimiento_garantia) {
            $vencimiento = Carbon::parse($serie->fecha_vencimiento_garantia);
            if (Carbon::today()->lte($vencimiento)) {
                $estadoGarantia = 'Vigente';
                $diasRestantes = Carbon::today()->diffInDays($vencimiento);
            } else {
                $estadoGarantia = 'Vencido';
            }
        }

        // 2. Extracción de Datos (Null Safety con PHP 8)
        $clienteData = [
            'nombre_cliente' => $serie->facturacionRegistro?->facturacion?->cliente?->nombre ?? 'En Stock',
            'telefono'       => $serie->facturacionRegistro?->facturacion?->cliente?->telefono ?? '--',
            'email'          => $serie->facturacionRegistro?->facturacion?->cliente?->email ?? $serie->facturacionRegistro?->facturacion?->cliente?->correo ?? '--',
            'numero_factura' => $serie->facturacionRegistro?->facturacion?->codigo_fac ?? 'No asignado',
        ];

        $historial = SerieProducto::where('codigo_producto', $serie->codigo_producto)
            ->where('id', '!=', $serie->id)
            ->latest()
            ->take(10)
            ->get()
            ->map(function (SerieProducto $relacionada) {
                return [
                    'id' => $relacionada->id,
                    'numero_serie' => $relacionada->numero_serie,
                    'codigo_producto' => $relacionada->codigo_producto,
                    'codigo_lote' => $relacionada->codigo_lote,
                    'estado' => $relacionada->estado,
                    'fecha_venta' => $relacionada->fecha_venta,
                    'fecha_vencimiento_garantia' => $relacionada->fecha_vencimiento_garantia,
                    'ubicacion' => $relacionada->ubicacion,
                    'calidad' => $relacionada->calidad,
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
                    'fecha_venta' => $serie->fecha_venta ?: '--',
                    'fecha_vencimiento' => $serie->fecha_vencimiento_garantia ?: '--',
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
}
