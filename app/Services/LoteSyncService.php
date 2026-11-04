<?php

declare(strict_types=1);

namespace App\Services;

use App\EstadoProducto;
use App\Lote;
use App\Producto;
use App\SerieProducto;
use App\Stock_almacen;
use App\Stock_producto;
use App\kardex_entrada_registro;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoteSyncService
{
    /**
     * Sincroniza todos los registros de Kardex y existencias físicas de almacén
     * hacia la tabla de lotes y números de serie.
     *
     * @return array Resumen de registros creados y sincronizados.
     */
    public static function sincronizarTodo(): array
    {
        $kardexSinLote = kardex_entrada_registro::whereNotIn('id', function ($q) {
            $q->select('kardex_entrada_registro_id')
              ->from('lotes')
              ->whereNotNull('kardex_entrada_registro_id');
        })
        ->with(['kardex_entrada.provedor', 'producto'])
        ->orderBy('id', 'asc')
        ->get();

        $lotesKardexCreados = 0;
        $seriesCreadas = 0;

        $estadoEnStock = EstadoProducto::where('nombre_estado', 'En Stock')->first();
        $estadoVendido = EstadoProducto::where('nombre_estado', 'Vendido')->first();
        $enStockId = $estadoEnStock ? $estadoEnStock->id : 1;
        $vendidoId = $estadoVendido ? $estadoVendido->id : 2;
        $hoy = Carbon::today();

        DB::transaction(function () use ($kardexSinLote, &$lotesKardexCreados, &$seriesCreadas, $enStockId, $vendidoId, $hoy) {
            $seriesBuffer = [];

            foreach ($kardexSinLote as $registro) {
                $producto = $registro->producto ?: Producto::find($registro->producto_id);
                if (!$producto) {
                    continue;
                }

                $codigoProducto = $producto->codigo_producto ?: ('PROD-' . $producto->id);
                $kardexEntrada = $registro->kardex_entrada;
                $proveedorId = $kardexEntrada ? $kardexEntrada->provedor_id : null;
                $proveedorNombre = ($kardexEntrada && $kardexEntrada->provedor) ? $kardexEntrada->provedor->empresa : null;

                $cantidad = max(1, (int) ($registro->cantidad_inicial ?: $registro->cantidad ?: 1));
                $cantDisp = max(0, min($cantidad, (int) $registro->cantidad));
                $costoUnitario = (float) ($registro->precio_nacional ?? 0.0);
                $fechaEntrada = $registro->created_at ? Carbon::parse($registro->created_at) : Carbon::now();
                $codigoLote = sprintf('LOT-%s-%04d', $fechaEntrada->format('Ymd'), (int) $registro->id);

                if (Lote::where('lote', $codigoLote)->exists()) {
                    continue;
                }

                if ($cantDisp > 0) {
                    $fechaVenc = $hoy->copy()->addYears(2);
                } else {
                    $fechaVenc = $fechaEntrada->copy()->addYears(2);
                }
                $esVencido = $fechaVenc->lt($hoy);

                $estadoLote = $esVencido ? 'Vencido' : ($cantDisp <= 0 ? 'Terminado' : ($cantDisp < $cantidad ? 'En Proceso' : 'Completo'));

                $lote = Lote::create([
                    'lote'                       => $codigoLote,
                    'producto_id'                => $producto->id,
                    'codigo_producto'           => $codigoProducto,
                    'almacen_id'                 => $registro->almacen_id ?: 1,
                    'proveedor_id'               => $proveedorId,
                    'proveedor_nombre'           => $proveedorNombre,
                    'cantidad'                   => $cantidad,
                    'cantidad_disponible'        => $cantDisp,
                    'costo_individual'           => $costoUnitario,
                    'fecha_produccion'           => $fechaEntrada->toDateString(),
                    'fecha_vencimiento'          => $fechaVenc->toDateString(),
                    'estado'                     => $estadoLote,
                    'kardex_entrada_registro_id' => $registro->id,
                    'created_at'                 => $fechaEntrada,
                    'updated_at'                 => $fechaEntrada,
                ]);
                $lotesKardexCreados++;

                $now = $fechaEntrada->toDateTimeString();
                for ($i = 1; $i <= $cantidad; $i++) {
                    $numSerie = self::generarNumeroSerieSeguro($codigoProducto, $codigoLote, $i);
                    $isEnStock = ($i <= $cantDisp && !$esVencido);

                    $seriesBuffer[] = [
                        'numero_serie'            => $numSerie,
                        'producto_id'             => $producto->id,
                        'codigo_producto'         => $codigoProducto,
                        'lote_id'                 => $lote->id,
                        'codigo_lote'             => $codigoLote,
                        'estado_id'               => $isEnStock ? $enStockId : $vendidoId,
                        'fecha_ultimo_movimiento' => $now,
                        'created_at'              => $now,
                        'updated_at'              => $now,
                    ];

                    if (count($seriesBuffer) >= 500) {
                        DB::table('series_productos')->insertOrIgnore($seriesBuffer);
                        $seriesCreadas += count($seriesBuffer);
                        $seriesBuffer = [];
                    }
                }
            }

            if (!empty($seriesBuffer)) {
                DB::table('series_productos')->insertOrIgnore($seriesBuffer);
                $seriesCreadas += count($seriesBuffer);
                $seriesBuffer = [];
            }
        });

        // 2. Verificar y respaldar cualquier stock en stock_almacen que no tenga lote
        $stocksAlmacen = Stock_almacen::where('stock', '>', 0)->get();
        $lotesInicialesCreados = 0;

        foreach ($stocksAlmacen as $st) {
            $almId = (int) $st->almacen_id;
            $prodId = (int) $st->producto_id;
            $stockActual = (int) $st->stock;

            $lotesExistentes = Lote::where('producto_id', $prodId)
                ->where('almacen_id', $almId)
                ->get();
            $capacidad = (int) $lotesExistentes->sum('cantidad');

            if ($capacidad < $stockActual) {
                $faltante = $stockActual - $capacidad;
                $producto = Producto::find($prodId);
                $codigoProducto = $producto ? $producto->codigo_producto : ('PROD-' . $prodId);
                $costo = (float) (optional(Stock_producto::where('producto_id', $prodId)->first())->precio_nacional ?? 0.0);
                $fechaHoy = Carbon::now();
                $codigoLote = sprintf('LOT-INI-%s-%04d-%02d', $fechaHoy->format('Ymd'), $prodId, $almId);

                $lote = Lote::firstOrCreate(
                    ['lote' => $codigoLote],
                    [
                        'producto_id'                => $prodId,
                        'codigo_producto'           => $codigoProducto,
                        'almacen_id'                 => $almId,
                        'proveedor_id'               => null,
                        'proveedor_nombre'           => 'Inventario Inicial',
                        'cantidad'                   => $faltante,
                        'cantidad_disponible'        => $faltante,
                        'costo_individual'           => $costo,
                        'fecha_produccion'           => $fechaHoy->toDateString(),
                        'fecha_vencimiento'          => $hoy->copy()->addYears(2)->toDateString(),
                        'estado'                     => 'Completo',
                        'kardex_entrada_registro_id' => null,
                        'created_at'                 => $fechaHoy,
                        'updated_at'                 => $fechaHoy,
                    ]
                );
                $lotesInicialesCreados++;

                $seriesInit = [];
                $conteoSeries = SerieProducto::where('lote_id', $lote->id)->count();
                $now = $fechaHoy->toDateTimeString();

                for ($i = 1; $i <= $faltante; $i++) {
                    $numSerie = self::generarNumeroSerieSeguro($codigoProducto, $codigoLote, $conteoSeries + $i);
                    $seriesInit[] = [
                        'numero_serie'            => $numSerie,
                        'producto_id'             => $prodId,
                        'codigo_producto'         => $codigoProducto,
                        'lote_id'                 => $lote->id,
                        'codigo_lote'             => $codigoLote,
                        'estado_id'               => $enStockId,
                        'fecha_ultimo_movimiento' => $now,
                        'created_at'              => $now,
                        'updated_at'              => $now,
                    ];
                }

                if (!empty($seriesInit)) {
                    DB::table('series_productos')->insertOrIgnore($seriesInit);
                    $seriesCreadas += count($seriesInit);
                }
            }

            // Sincronizar cantidades disponibles exactas con el stock físico del almacén
            Stock_almacen::sincronizarLotesConStock($almId, $prodId, $stockActual);
        }

        return [
            'lotes_kardex' => $lotesKardexCreados,
            'lotes_iniciales' => $lotesInicialesCreados,
            'series_creadas' => $seriesCreadas,
        ];
    }

    /**
     * Asegura de forma reactiva e idempotente que un producto tenga sus lotes
     * y series generados y sincronizados con su inventario físico en stock_almacen.
     *
     * @param Producto|int $producto
     * @param int $almacenId Opcional, ID de almacén
     * @return void
     */
    public static function asegurarLotesParaProducto($producto, int $almacenId = 0): void
    {
        try {
            if (!$producto instanceof Producto) {
                $producto = Producto::find($producto);
            }

            if (!$producto) {
                return;
            }

            $productoId = (int) $producto->id;
            $codigoProducto = $producto->codigo_producto ?: ('PROD-' . $productoId);

            // 1. Sincronizar entradas de Kardex existentes sin lote
            $kardexSinLote = kardex_entrada_registro::where('producto_id', $productoId)
                ->whereNotIn('id', function ($q) {
                    $q->select('kardex_entrada_registro_id')
                      ->from('lotes')
                      ->whereNotNull('kardex_entrada_registro_id');
                })
                ->with(['kardex_entrada.provedor'])
                ->orderBy('id', 'asc')
                ->get();

            $estadoEnStock = EstadoProducto::where('nombre_estado', 'En Stock')->first();
            $estadoVendido = EstadoProducto::where('nombre_estado', 'Vendido')->first();
            $enStockId = $estadoEnStock ? $estadoEnStock->id : 1;
            $vendidoId = $estadoVendido ? $estadoVendido->id : 2;
            $hoy = Carbon::today();

            if ($kardexSinLote->isNotEmpty()) {
                DB::transaction(function () use ($kardexSinLote, $producto, $codigoProducto, $enStockId, $vendidoId, $hoy) {
                    foreach ($kardexSinLote as $registro) {
                        $kardexEntrada = $registro->kardex_entrada;
                        $proveedorId = $kardexEntrada ? $kardexEntrada->provedor_id : null;
                        $proveedorNombre = ($kardexEntrada && $kardexEntrada->provedor) ? $kardexEntrada->provedor->empresa : null;

                        $cantidad = max(1, (int) ($registro->cantidad_inicial ?: $registro->cantidad ?: 1));
                        $cantDisp = max(0, min($cantidad, (int) $registro->cantidad));
                        $costoUnitario = (float) ($registro->precio_nacional ?? 0.0);
                        $fechaEntrada = $registro->created_at ? Carbon::parse($registro->created_at) : Carbon::now();
                        $codigoLote = sprintf('LOT-%s-%04d', $fechaEntrada->format('Ymd'), (int) $registro->id);

                        if (Lote::where('lote', $codigoLote)->exists()) {
                            continue;
                        }

                        $fechaVenc = $cantDisp > 0 ? $hoy->copy()->addYears(2) : $fechaEntrada->copy()->addYears(2);
                        $esVencido = $fechaVenc->lt($hoy);
                        $estadoLote = $esVencido ? 'Vencido' : ($cantDisp <= 0 ? 'Terminado' : ($cantDisp < $cantidad ? 'En Proceso' : 'Completo'));

                        $lote = Lote::create([
                            'lote'                       => $codigoLote,
                            'producto_id'                => $producto->id,
                            'codigo_producto'           => $codigoProducto,
                            'almacen_id'                 => $registro->almacen_id ?: 1,
                            'proveedor_id'               => $proveedorId,
                            'proveedor_nombre'           => $proveedorNombre,
                            'cantidad'                   => $cantidad,
                            'cantidad_disponible'        => $cantDisp,
                            'costo_individual'           => $costoUnitario,
                            'fecha_produccion'           => $fechaEntrada->toDateString(),
                            'fecha_vencimiento'          => $fechaVenc->toDateString(),
                            'estado'                     => $estadoLote,
                            'kardex_entrada_registro_id' => $registro->id,
                            'created_at'                 => $fechaEntrada,
                            'updated_at'                 => $fechaEntrada,
                        ]);

                        $seriesBatch = [];
                        $now = $fechaEntrada->toDateTimeString();
                        for ($i = 1; $i <= $cantidad; $i++) {
                            $isEnStock = ($i <= $cantDisp && !$esVencido);
                            $seriesBatch[] = [
                                'numero_serie'            => self::generarNumeroSerieSeguro($codigoProducto, $codigoLote, $i),
                                'producto_id'             => $producto->id,
                                'codigo_producto'         => $codigoProducto,
                                'lote_id'                 => $lote->id,
                                'codigo_lote'             => $codigoLote,
                                'estado_id'               => $isEnStock ? $enStockId : $vendidoId,
                                'fecha_ultimo_movimiento' => $now,
                                'created_at'              => $now,
                                'updated_at'              => $now,
                            ];

                            if (count($seriesBatch) >= 500) {
                                DB::table('series_productos')->insertOrIgnore($seriesBatch);
                                $seriesBatch = [];
                            }
                        }

                        if (!empty($seriesBatch)) {
                            DB::table('series_productos')->insertOrIgnore($seriesBatch);
                        }
                    }
                });
            }

            // 2. Verificar y sincronizar existencias físicas en todos los almacenes para este producto.
            // Sincronizar todos los almacenes evita inconsistencias al alternar filtros en Detalle de Lote.
            $stocksAlmacen = Stock_almacen::where('producto_id', $productoId)->get();

            foreach ($stocksAlmacen as $stockRow) {
                $almId = (int) $stockRow->almacen_id;
                $stockActual = max(0, (int) $stockRow->stock);

                $lotesExistentes = Lote::where('producto_id', $productoId)
                    ->where('almacen_id', $almId)
                    ->get();
                $capacidadLotes = (int) $lotesExistentes->sum('cantidad');

                if ($stockActual > 0 && $capacidadLotes < $stockActual) {
                    $faltante = $stockActual - $capacidadLotes;

                    DB::transaction(function () use ($productoId, $codigoProducto, $almId, $faltante, $enStockId, $hoy) {
                        $fechaHoy = Carbon::now();
                        $codigoLote = sprintf('LOT-INI-%s-%04d-%02d', $fechaHoy->format('Ymd'), $productoId, $almId);

                        $lote = Lote::where('lote', $codigoLote)->first();
                        if ($lote) {
                            $lote->cantidad += $faltante;
                            $lote->cantidad_disponible += $faltante;
                            $lote->recalcularEstado();
                        } else {
                            $costoUnitario = (float) (optional(Stock_producto::where('producto_id', $productoId)->first())->precio_nacional ?? 0.0);
                            $lote = Lote::create([
                                'lote'                       => $codigoLote,
                                'producto_id'                => $productoId,
                                'codigo_producto'           => $codigoProducto,
                                'almacen_id'                 => $almId,
                                'proveedor_id'               => null,
                                'proveedor_nombre'           => 'Inventario Inicial',
                                'cantidad'                   => $faltante,
                                'cantidad_disponible'        => $faltante,
                                'costo_individual'           => $costoUnitario,
                                'fecha_produccion'           => $fechaHoy->toDateString(),
                                'fecha_vencimiento'          => $hoy->copy()->addYears(2)->toDateString(),
                                'estado'                     => 'Completo',
                                'kardex_entrada_registro_id' => null,
                                'created_at'                 => $fechaHoy,
                                'updated_at'                 => $fechaHoy,
                            ]);
                        }

                        $conteoActualSeries = SerieProducto::where('lote_id', $lote->id)->count();
                        $seriesBatch = [];
                        $now = $fechaHoy->toDateTimeString();

                        for ($i = 1; $i <= $faltante; $i++) {
                            $numSerieIndex = $conteoActualSeries + $i;
                            $seriesBatch[] = [
                                'numero_serie'            => self::generarNumeroSerieSeguro($codigoProducto, $lote->lote, $numSerieIndex),
                                'producto_id'             => $productoId,
                                'codigo_producto'         => $codigoProducto,
                                'lote_id'                 => $lote->id,
                                'codigo_lote'             => $lote->lote,
                                'estado_id'               => $enStockId,
                                'fecha_ultimo_movimiento' => $now,
                                'created_at'              => $now,
                                'updated_at'              => $now,
                            ];
                        }

                        if (!empty($seriesBatch)) {
                            DB::table('series_productos')->insertOrIgnore($seriesBatch);
                        }
                    });
                }

                // Sincronizar disponibilidad con stock físico del almacén
                Stock_almacen::sincronizarLotesConStock($almId, $productoId, $stockActual);
            }
        } catch (\Throwable $e) {
            Log::error('Error en LoteSyncService::asegurarLotesParaProducto: ' . $e->getMessage(), [
                'exception' => $e,
                'producto_id' => $producto->id ?? null,
                'almacen_id' => $almacenId,
            ]);
        }
    }

    /**
     * Genera un número de serie seguro garantizado para no superar los 50 caracteres
     * permitidos por la columna numero_serie de la tabla series_productos.
     *
     * @param string $codigoProducto
     * @param string $codigoLote
     * @param int $index
     * @return string
     */
    public static function generarNumeroSerieSeguro(string $codigoProducto, string $codigoLote, int $index): string
    {
        $skuLimpio = (string) preg_replace('/[^A-Za-z0-9_-]/', '', $codigoProducto);
        if ($skuLimpio === '') {
            $skuLimpio = 'PRD';
        }
        $skuCorto = substr($skuLimpio, 0, 16);
        $loteCorto = substr($codigoLote, 0, 24);
        $serie = sprintf('SN-%s-%s-%04d', $skuCorto, $loteCorto, $index);

        if (strlen($serie) > 50) {
            $serie = substr($serie, 0, 50);
        }

        return $serie;
    }
}
