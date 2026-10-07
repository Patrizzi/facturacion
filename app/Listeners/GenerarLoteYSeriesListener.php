<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\KardexEntradaProcesado;
use App\EstadoProducto;
use App\Kardex_entrada;
use App\Lote;
use App\Producto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class GenerarLoteYSeriesListener
{
    /**
     * Procesa el evento de entrada en Kardex generando el lote correspondiente
     * e insertando masivamente las series de los productos involucrados.
     *
     * @param KardexEntradaProcesado $event
     * @return void
     * @throws Throwable
     */
    public function handle(KardexEntradaProcesado $event): void
    {
        try {
            DB::transaction(function () use ($event): void {
                $registro = $event->kardexRegistro;

                // 1. Obtener información de producto y proveedor
                $producto = Producto::find($registro->producto_id);
                $codigoProducto = $producto ? $producto->codigo_producto : ('PROD-' . $registro->producto_id);

                $kardexEntrada = Kardex_entrada::with('proveedor')->find($registro->kardex_entrada_id);
                $proveedorId = $kardexEntrada ? $kardexEntrada->provedor_id : null;
                $proveedorNombre = ($kardexEntrada && $kardexEntrada->proveedor)
                    ? $kardexEntrada->proveedor->empresa
                    : null;

                $cantidad = (int) ($registro->cantidad ?? $registro->unidad_cantidad ?? 1);
                $costoUnitario = (float) ($registro->precio_nacional ?? 0.0);

                // Generación de código único de Lote
                $codigoLote = sprintf('LOT-%s-%04d', Carbon::now()->format('Ymd'), (int) $registro->id);

                // 2. Creación del registro en la tabla `lotes`
                $lote = Lote::create([
                    'lote'                       => $codigoLote,
                    'producto_id'                => $registro->producto_id,
                    'codigo_producto'           => $codigoProducto,
                    'almacen_id'                 => $registro->almacen_id,
                    'proveedor_id'               => $proveedorId,
                    'proveedor_nombre'           => $proveedorNombre,
                    'cantidad'                   => $cantidad,
                    'cantidad_disponible'        => $cantidad,
                    'costo_individual'           => $costoUnitario,
                    'fecha_produccion'           => Carbon::now()->toDateString(),
                    'fecha_vencimiento'          => Carbon::now()->addYears(2)->toDateString(),
                    'estado'                     => 'Completo',
                    'kardex_entrada_registro_id' => $registro->id,
                ]);

                // 3. Inserción masiva en `series_productos`
                $estadoEnStock = EstadoProducto::where('nombre_estado', 'En Stock')->first();
                $estadoId = $estadoEnStock ? $estadoEnStock->id : null;

                $now = Carbon::now()->toDateTimeString();
                $seriesBatch = [];

                for ($i = 1; $i <= $cantidad; $i++) {
                    $numeroSerie = sprintf('SN-%s-%s-%04d', $codigoProducto, $codigoLote, $i);

                    $seriesBatch[] = [
                        'numero_serie'            => $numeroSerie,
                        'producto_id'             => $registro->producto_id,
                        'codigo_producto'         => $codigoProducto,
                        'lote_id'                 => $lote->id,
                        'codigo_lote'             => $codigoLote,
                        'estado_id'               => $estadoId,
                        'fecha_ultimo_movimiento' => $now,
                        'created_at'              => $now,
                        'updated_at'              => $now,
                    ];
                }

                // Inserción en lotes optimizados (chunks de 500 registros)
                foreach (array_chunk($seriesBatch, 500) as $chunk) {
                    DB::table('series_productos')->insert($chunk);
                }
            });
        } catch (Throwable $e) {
            Log::error(
                sprintf('Error en GenerarLoteYSeriesListener para kardex_registro #%s: %s', $event->kardexRegistro->id ?? 'N/A', $e->getMessage()),
                [
                    'exception'   => $e,
                    'registro_id' => $event->kardexRegistro->id ?? null,
                ]
            );

            throw $e;
        }
    }
}
