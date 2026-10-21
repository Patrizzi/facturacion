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
use Illuminate\Support\Facades\Schema;

class DetalleLoteController extends Controller
{
    public function paginaSeries($loteId)
    {
        $lote = Lote::with(['producto', 'proveedor'])->findOrFail($loteId);
        $hayTablaGarantias = Schema::hasTable('garantias');
        $consultaSeries = SerieProducto::with('estadoProducto')
            ->where('lote_id', $lote->id);

        if ($hayTablaGarantias) {
            $consultaSeries->with('garantiaActual');
        }

        $series = $consultaSeries->orderBy('id')->get();
        $seriesEditables = $this->seriesEditables($series);

        return view('inventario.lotes_garantias.series_lote', compact(
            'lote',
            'series',
            'seriesEditables',
            'hayTablaGarantias'
        ));
    }

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
        $baseQuery = Lote::with(['proveedor', 'almacen', 'producto'])
            ->withCount('series');

        if (!empty($codigoProducto)) {
            $baseQuery->where('codigo_producto', $codigoProducto);
        }

        if ($almacenId > 0) {
            $baseQuery->where('almacen_id', $almacenId);
        }

        if ($proveedorId > 0) {
            $baseQuery->where('proveedor_id', $proveedorId);
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

        // La disponibilidad agregada por almacén es la fuente actualizada por las salidas.
        $lotesFiltrados = (clone $baseQuery)->get();
        $disponibilidad = $this->disponibilidadActualPorLote($lotesFiltrados);
        $disponiblePorLote = $disponibilidad['por_lote'];
        $stockPorPar = $disponibilidad['por_par'];
        $estadoPorLote = [];
        foreach ($lotesFiltrados as $lote) {
            $esVencido = $lote->fecha_vencimiento
                && Carbon::parse($lote->fecha_vencimiento)->toDateString() < $hoy;
            $cantidadDisponible = (int) ($disponiblePorLote[$lote->id] ?? 0);
            $estadoPorLote[$lote->id] = $esVencido
                ? 'Vencido'
                : ($cantidadDisponible <= 0
                    ? 'Terminado'
                    : ($cantidadDisponible < (int) $lote->cantidad ? 'En Proceso' : 'Completo'));
        }

        if (!empty($estado)) {
            $lotesFiltrados = $lotesFiltrados->filter(function ($lote) use ($estado, $estadoPorLote) {
                return ($estadoPorLote[$lote->id] ?? null) === $estado;
            })->values();
        }

        if ($dispMin !== null && $dispMin !== '') {
            $lotesFiltrados = $lotesFiltrados->filter(function ($lote) use ($dispMin, $disponiblePorLote) {
                return ($disponiblePorLote[$lote->id] ?? 0) >= (int) $dispMin;
            })->values();
        }
        if ($dispMax !== null && $dispMax !== '') {
            $lotesFiltrados = $lotesFiltrados->filter(function ($lote) use ($dispMax, $disponiblePorLote) {
                return ($disponiblePorLote[$lote->id] ?? 0) <= (int) $dispMax;
            })->values();
        }

        $totalLotes = $lotesFiltrados->count();
        $lotesActivos = $lotesFiltrados->filter(function ($lote) use ($hoy) {
            return !$lote->fecha_vencimiento || Carbon::parse($lote->fecha_vencimiento)->toDateString() >= $hoy;
        });
        $lotesVencidos = $lotesFiltrados->filter(function ($lote) use ($hoy) {
            return $lote->fecha_vencimiento && Carbon::parse($lote->fecha_vencimiento)->toDateString() < $hoy;
        });
        $conteoActivos = $lotesActivos->count();
        $conteoVencidos = $lotesVencidos->count();
        $paresActivos = [];
        foreach ($lotesActivos as $loteActivo) {
            $paresActivos[$loteActivo->producto_id . ':' . $loteActivo->almacen_id] = true;
        }
        $unidadesDisponibles = 0;
        foreach (array_keys($paresActivos) as $par) {
            $unidadesDisponibles += $stockPorPar[$par] ?? 0;
        }

        // 4. Filtrar por pestaña y paginar después de aplicar la disponibilidad real.
        if ($tab === 'vencidos') {
            $lotesDePestana = $lotesVencidos->sort(function ($a, $b) {
                return Carbon::parse($a->fecha_vencimiento)->timestamp <=> Carbon::parse($b->fecha_vencimiento)->timestamp;
            });
        } else {
            $lotesDePestana = $lotesActivos->sort(function ($a, $b) {
                $fechaA = $a->fecha_vencimiento ? Carbon::parse($a->fecha_vencimiento)->timestamp : PHP_INT_MAX;
                $fechaB = $b->fecha_vencimiento ? Carbon::parse($b->fecha_vencimiento)->timestamp : PHP_INT_MAX;
                return ($fechaA <=> $fechaB) ?: ($b->id <=> $a->id);
            });
        }

        $perPage = max(1, $perPage);
        $totalEnPestana = $lotesDePestana->count();
        $ultimaPagina = max(1, (int) ceil($totalEnPestana / $perPage));
        $paginaActual = min(max(1, (int) $request->input('page', 1)), $ultimaPagina);
        $lotesPaginados = $lotesDePestana
            ->slice(($paginaActual - 1) * $perPage, $perPage)
            ->values();

        // 5. Formateo de Lotes para la tabla
        $items = [];
        $simboloMoneda = DB::table('monedas')
            ->where('principal', 1)
            ->value('simbolo') ?: 'S/';

        foreach ($lotesPaginados as $item) {
            $esVencido = $item->fecha_vencimiento && Carbon::parse($item->fecha_vencimiento)->toDateString() < $hoy;
            $cantidadDisponible = (int) ($disponiblePorLote[$item->id] ?? 0);
            $proveedorNombre = $item->proveedor
                ? ($item->proveedor->empresa ?: $item->proveedor->nombre)
                : $item->proveedor_nombre;
            $items[] = [
                'id' => $item->id,
                'lote' => $item->lote,
                'codigo_producto' => $item->codigo_producto,
                'cantidad' => (int) $item->cantidad,
                'cantidad_disponible' => $cantidadDisponible,
                'costo_individual' => (float) $item->costo_individual,
                'simbolo_moneda' => $simboloMoneda,
                'fecha_produccion' => $item->fecha_produccion ? Carbon::parse($item->fecha_produccion)->format('d/m/Y') : '--',
                'fecha_vencimiento' => $item->fecha_vencimiento ? Carbon::parse($item->fecha_vencimiento)->format('d/m/Y') : '--',
                'proveedor' => $proveedorNombre ?: '--',
                'estado' => $estadoPorLote[$item->id] ?? 'Desconocido',
                'total_series' => (int) $item->series_count,
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
                'total' => $totalEnPestana,
                'per_page' => $perPage,
                'current_page' => $paginaActual,
                'last_page' => $ultimaPagina,
            ],
        ]);
    }

    private function disponibilidadActualPorLote($lotesFiltrados)
    {
        $pares = [];
        foreach ($lotesFiltrados as $lote) {
            $pares[$lote->producto_id . ':' . $lote->almacen_id] = [
                'producto_id' => (int) $lote->producto_id,
                'almacen_id' => (int) $lote->almacen_id,
            ];
        }

        if (!$pares) {
            return ['por_lote' => [], 'por_par' => []];
        }

        $productoIds = array_values(array_unique(array_column($pares, 'producto_id')));
        $almacenIds = array_values(array_unique(array_column($pares, 'almacen_id')));
        $lotesInventario = Lote::whereIn('producto_id', $productoIds)
            ->whereIn('almacen_id', $almacenIds)
            ->orderByRaw('fecha_vencimiento IS NULL, fecha_vencimiento ASC')
            ->orderBy('id', 'asc')
            ->get(['id', 'producto_id', 'almacen_id', 'cantidad', 'cantidad_disponible']);

        $stockPorPar = [];
        foreach (DB::table('stock_almacen')
            ->whereIn('producto_id', $productoIds)
            ->whereIn('almacen_id', $almacenIds)
            ->get(['producto_id', 'almacen_id', 'stock']) as $stock) {
            $stockPorPar[$stock->producto_id . ':' . $stock->almacen_id] = max(0, (int) $stock->stock);
        }

        $lotesPorPar = $lotesInventario->groupBy(function ($lote) {
            return $lote->producto_id . ':' . $lote->almacen_id;
        });
        $disponiblePorLote = [];

        foreach ($pares as $par => $ids) {
            $lotesDelPar = $lotesPorPar->get($par, collect())->values();
            if (!array_key_exists($par, $stockPorPar)) {
                $stockPorPar[$par] = (int) $lotesDelPar->sum('cantidad_disponible');
            }

            $pendiente = $stockPorPar[$par];
            foreach ($lotesDelPar->reverse() as $lote) {
                $disponible = min(max(0, (int) $lote->cantidad), $pendiente);
                $disponiblePorLote[$lote->id] = $disponible;
                $pendiente -= $disponible;
            }
        }

        return [
            'por_lote' => $disponiblePorLote,
            'por_par' => $stockPorPar,
        ];
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

        $hayTablaGarantias = Schema::hasTable('garantias');
        $consultaSeries = SerieProducto::with('estadoProducto')
            ->where('lote_id', $loteId);

        if ($hayTablaGarantias) {
            $consultaSeries->with('garantiaActual');
        }

        $series = $consultaSeries
            ->orderBy('id', 'asc')
            ->get();
        $seriesEditables = $this->seriesEditables($series);
        $series = $series->map(function (SerieProducto $serie) use ($hayTablaGarantias, $seriesEditables) {
                $garantia = $hayTablaGarantias ? $serie->garantiaActual : null;
                $fechaVenta = $garantia ? $garantia->fecha_venta : null;
                $fechaVencimiento = $garantia ? $garantia->fecha_vencimiento : null;

                return [
                    'id' => $serie->id,
                    'numero_serie' => $serie->numero_serie,
                    'estado' => $serie->estadoProducto?->nombre_estado ?? 'En Stock',
                    'ubicacion' => $serie->estadoProducto?->ubicacion ?? 'Almacén Principal',
                    'calidad' => $serie->estadoProducto?->calidad ?? 'A',
                    'fecha_venta' => $fechaVenta ? Carbon::parse($fechaVenta)->format('Y-m-d') : '--',
                    'fecha_vencimiento_garantia' => $fechaVencimiento ? Carbon::parse($fechaVencimiento)->format('Y-m-d') : '--',
                    'editable' => $seriesEditables[$serie->id] ?? false,
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

    public function actualizarNumeroSerie(Request $request)
    {
        $request->merge([
            'numero_serie' => trim((string) $request->input('numero_serie', '')),
        ]);

        $validated = $request->validate([
            'lote_id' => ['required', 'integer', 'exists:lotes,id'],
            'serie_id' => ['required', 'integer', 'exists:series_productos,id'],
            'numero_serie' => [
                'required',
                'string',
                'max:50',
                'unique:series_productos,numero_serie,' . (int) $request->input('serie_id'),
            ],
        ]);

        $serie = DB::transaction(function () use ($validated) {
            $lote = Lote::whereKey($validated['lote_id'])->lockForUpdate()->firstOrFail();
            $serie = SerieProducto::whereKey($validated['serie_id'])
                ->where('lote_id', $lote->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (!$this->serieEditable($serie)) {
                abort(422, 'No se puede modificar una serie vendida o vinculada a un comprobante, garantía o reclamo.');
            }

            $serie->numero_serie = $validated['numero_serie'];
            $serie->save();

            return $serie;
        });

        return response()->json([
            'success' => true,
            'message' => 'Número de serie actualizado correctamente.',
            'numero_serie' => $serie->numero_serie,
        ]);
    }

    private function serieEditable(SerieProducto $serie)
    {
        $editables = $this->seriesEditables(collect([$serie]));
        return $editables[$serie->id] ?? false;
    }

    private function seriesEditables($series)
    {
        $serieIds = $series->pluck('id')->all();
        $numerosSerie = $series->pluck('numero_serie')->all();
        $editables = [];

        foreach ($series as $serie) {
            $editables[$serie->id] = !$serie->estadoProducto
                || $serie->estadoProducto->nombre_estado === 'En Stock';
        }

        $referencias = [
            'facturacion_registro',
            'facturacion_registro_m',
            'boleta_registro',
            'boleta_registros_m',
            'nota_venta_registro',
            'reclamos_garantia',
            'garantias',
        ];

        foreach ($referencias as $tabla) {
            if (!Schema::hasTable($tabla)) {
                continue;
            }

            if ($serieIds && Schema::hasColumn($tabla, 'serie_id')) {
                $idsReferenciados = DB::table($tabla)
                    ->whereIn('serie_id', $serieIds)
                    ->pluck('serie_id')
                    ->all();

                foreach ($idsReferenciados as $id) {
                    $editables[$id] = false;
                }
            }

            if ($numerosSerie && Schema::hasColumn($tabla, 'numero_serie')) {
                $seriesReferenciadas = DB::table($tabla)
                    ->whereIn('numero_serie', $numerosSerie)
                    ->pluck('numero_serie')
                    ->all();

                $numerosReferenciados = array_flip($seriesReferenciadas);
                foreach ($series as $serie) {
                    if (isset($numerosReferenciados[$serie->numero_serie])) {
                        $editables[$serie->id] = false;
                    }
                }
            }
        }

        return $editables;
    }
}
