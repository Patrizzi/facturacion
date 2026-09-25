<?php

namespace App\Http\Controllers\LotesGarantias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lote;
use App\Producto;
use App\Almacen;
use App\Provedor;
use App\SerieProducto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DetalleLoteController extends Controller
{
    /**
     * Procesa la consulta AJAX para el listado de lotes (activos y vencidos),
     * filtros dinámicos y métricas para Detalle de Lote.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxLotes(Request $request)
    {
        $codigoProducto = trim((string) $request->input('codigo_producto', ''));
        $almacenId = $request->filled('almacen') ? (int) $request->input('almacen') : 0;
        $proveedorId = $request->filled('proveedor') ? (int) $request->input('proveedor') : 0;
        $estado = trim((string) $request->input('estado', ''));
        $textoBuscar = trim((string) $request->input('texto_buscar', ''));
        $fechaDesde = $request->input('fecha_desde');
        $fechaHasta = $request->input('fecha_hasta');
        $cantMin = $request->input('cant_min');
        $cantMax = $request->input('cant_max');
        $dispMin = $request->input('disp_min');
        $dispMax = $request->input('disp_max');
        $tab = $request->input('tab', 'activos'); // 'activos' o 'vencidos'
        $perPage = (int) $request->input('per_page', 15);
        $hoy = Carbon::today()->toDateString();

        // 1. Obtener información de contexto del producto y almacén
        $producto = null;
        if (!empty($codigoProducto)) {
            $producto = Producto::where('codigo_producto', $codigoProducto)->first();
        }

        // Si no se proporcionó código de producto pero hay lotes, tomar el primer producto disponible
        if (!$producto) {
            $primerLote = Lote::first();
            if ($primerLote) {
                $producto = Producto::find($primerLote->producto_id);
                if ($producto) {
                    $codigoProducto = $producto->codigo_producto;
                }
            }
        }

        $productoInfo = [
            'codigo' => $producto ? $producto->codigo_producto : ($codigoProducto ?: '--'),
            'nombre' => $producto ? $producto->nombre : 'Todos los productos',
            'modelo' => $producto && !empty($producto->modelo) ? $producto->modelo : ($producto ? $producto->nombre : '--'),
            'almacen' => 'Todos los almacenes',
        ];

        if ($almacenId > 0) {
            $almObj = Almacen::find($almacenId);
            if ($almObj) {
                $productoInfo['almacen'] = $almObj->nombre;
            }
        }

        // 2. Construcción de Query Base de Lotes con Filtros
        $baseQuery = Lote::with(['proveedor', 'almacen', 'producto']);

        if (!empty($codigoProducto)) {
            $baseQuery->where('codigo_producto', $codigoProducto);
        }

        if ($almacenId > 0) {
            $baseQuery->where('almacen_id', $almacenId);
        }

        if ($proveedorId > 0) {
            $baseQuery->where('proveedor_id', $proveedorId);
        }

        if (!empty($estado)) {
            $baseQuery->where('estado', $estado);
        }

        if (!empty($textoBuscar)) {
            $baseQuery->where(function ($q) use ($textoBuscar) {
                $q->where('lote', 'LIKE', "%{$textoBuscar}%")
                  ->orWhere('proveedor_nombre', 'LIKE', "%{$textoBuscar}%")
                  ->orWhereHas('series', function ($sq) use ($textoBuscar) {
                      $sq->where('numero_serie', 'LIKE', "%{$textoBuscar}%");
                  });
            });
        }

        if (!empty($fechaDesde)) {
            $baseQuery->where(function ($q) use ($fechaDesde) {
                $q->whereDate('fecha_produccion', '>=', $fechaDesde)
                  ->orWhereDate('fecha_vencimiento', '>=', $fechaDesde);
            });
        }

        if (!empty($fechaHasta)) {
            $baseQuery->where(function ($q) use ($fechaHasta) {
                $q->whereDate('fecha_produccion', '<=', $fechaHasta)
                  ->orWhereDate('fecha_vencimiento', '<=', $fechaHasta);
            });
        }

        if ($cantMin !== null && $cantMin !== '') {
            $baseQuery->where('cantidad', '>=', (int) $cantMin);
        }
        if ($cantMax !== null && $cantMax !== '') {
            $baseQuery->where('cantidad', '<=', (int) $cantMax);
        }

        if ($dispMin !== null && $dispMin !== '') {
            $baseQuery->where('cantidad_disponible', '>=', (int) $dispMin);
        }
        if ($dispMax !== null && $dispMax !== '') {
            $baseQuery->where('cantidad_disponible', '<=', (int) $dispMax);
        }

        // 3. Métricas Globales y Conteos para Tabs
        $queryConteos = clone $baseQuery;
        $totalLotes = (clone $queryConteos)->count();
        $unidadesDisponibles = (int) (clone $queryConteos)
            ->where(function ($q) use ($hoy) {
                $q->whereNull('fecha_vencimiento')->orWhere('fecha_vencimiento', '>=', $hoy);
            })
            ->sum('cantidad_disponible');

        $conteoActivos = (clone $queryConteos)
            ->where(function ($q) use ($hoy) {
                $q->whereNull('fecha_vencimiento')->orWhere('fecha_vencimiento', '>=', $hoy);
            })
            ->count();

        $conteoVencidos = (clone $queryConteos)
            ->whereNotNull('fecha_vencimiento')
            ->where('fecha_vencimiento', '<', $hoy)
            ->count();

        // 4. Filtrar por Tab seleccionado (Activos vs Vencidos)
        $queryTab = clone $baseQuery;
        if ($tab === 'vencidos') {
            $queryTab->whereNotNull('fecha_vencimiento')
                     ->where('fecha_vencimiento', '<', $hoy)
                     ->orderBy('fecha_vencimiento', 'asc');
        } else {
            $queryTab->where(function ($q) use ($hoy) {
                $q->whereNull('fecha_vencimiento')->orWhere('fecha_vencimiento', '>=', $hoy);
            })->orderBy('fecha_vencimiento', 'asc')
              ->orderBy('id', 'desc');
        }

        $lotesPaginados = $queryTab->paginate($perPage);

        // 5. Formateo de Lotes para la tabla
        $items = [];
        foreach ($lotesPaginados as $item) {
            $esVencido = $item->fecha_vencimiento && Carbon::parse($item->fecha_vencimiento)->toDateString() < $hoy;
            $proveedorNombre = $item->proveedor_nombre;
            if (!$proveedorNombre && $item->proveedor) {
                $proveedorNombre = $item->proveedor->empresa ?? $item->proveedor->nombre;
            }

            $items[] = [
                'id' => $item->id,
                'lote' => $item->lote,
                'codigo_producto' => $item->codigo_producto,
                'cantidad' => (int) $item->cantidad,
                'cantidad_disponible' => (int) $item->cantidad_disponible,
                'costo_individual' => number_format((float) $item->costo_individual, 2),
                'fecha_produccion' => $item->fecha_produccion ? Carbon::parse($item->fecha_produccion)->format('Y-m-d') : '--',
                'fecha_vencimiento' => $item->fecha_vencimiento ? Carbon::parse($item->fecha_vencimiento)->format('Y-m-d') : '--',
                'proveedor' => $proveedorNombre ?: '--',
                'estado' => $esVencido ? 'Vencido' : $item->estado,
                'total_series' => $item->series()->count(),
                'es_vencido' => $esVencido,
            ];
        }

        return response()->json([
            'success' => true,
            'producto_info' => $productoInfo,
            'metricas' => [
                'total_lotes' => $totalLotes,
                'unidades_disponibles' => $unidadesDisponibles,
                'conteo_activos' => $conteoActivos,
                'conteo_vencidos' => $conteoVencidos,
            ],
            'lotes' => $items,
            'paginacion' => [
                'total' => $lotesPaginados->total(),
                'per_page' => $lotesPaginados->perPage(),
                'current_page' => $lotesPaginados->currentPage(),
                'last_page' => $lotesPaginados->lastPage(),
            ],
        ]);
    }

    /**
     * Retorna el listado de números de serie pertenecientes a un lote específico.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxSeriesPorLote(Request $request)
    {
        $loteId = (int) $request->input('lote_id', 0);

        if ($loteId <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Identificador de lote inválido.',
            ], 422);
        }

        $lote = Lote::find($loteId);
        if (!$lote) {
            return response()->json([
                'success' => false,
                'message' => 'Lote no encontrado.',
            ], 404);
        }

        $series = SerieProducto::where('lote_id', $loteId)
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($serie) {
                return [
                    'id' => $serie->id,
                    'numero_serie' => $serie->numero_serie,
                    'estado' => $serie->estado ?: 'En Stock',
                    'ubicacion' => $serie->ubicacion ?: 'Almacén Principal',
                    'calidad' => $serie->calidad ?: 'A',
                    'fecha_venta' => $serie->fecha_venta ? Carbon::parse($serie->fecha_venta)->format('Y-m-d') : '--',
                    'fecha_vencimiento_garantia' => $serie->fecha_vencimiento_garantia ? Carbon::parse($serie->fecha_vencimiento_garantia)->format('Y-m-d') : '--',
                ];
            });

        return response()->json([
            'success' => true,
            'lote' => [
                'id' => $lote->id,
                'codigo' => $lote->lote,
                'codigo_producto' => $lote->codigo_producto,
                'cantidad' => $lote->cantidad,
                'cantidad_disponible' => $lote->cantidad_disponible,
            ],
            'series' => $series,
        ]);
    }
}
