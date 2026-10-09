<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ComprobanteVentaEmitido;
use App\EstadoProducto;
use App\Lote;
use App\SerieProducto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class DescontarStockLoteYSeriesListener
{
    /**
     * Procesa la emisión de un comprobante de venta, descontando stock de los lotes
     * con bloqueo pesimista y actualizando las series involucradas a "Vendido".
     *
     * @param ComprobanteVentaEmitido $event
     * @return void
     * @throws Throwable
     */
    public function handle(ComprobanteVentaEmitido $event): void
    {
        try {
            DB::transaction(function () use ($event): void {
                $comprobante = $event->comprobante;

                // Obtener colección de detalles según el tipo de comprobante (Factura o Boleta)
                $detalles = method_exists($comprobante, 'registros')
                    ? $comprobante->registros()->get()
                    : (method_exists($comprobante, 'registros_m') ? $comprobante->registros_m()->get() : collect());

                $estadoVendido = EstadoProducto::where('nombre_estado', 'Vendido')->first();
                $estadoVendidoId = $estadoVendido ? $estadoVendido->id : null;
                $now = Carbon::now();

                foreach ($detalles as $detalle) {
                    // Si el ítem corresponde a un servicio o no tiene producto físico, omitir
                    if (empty($detalle->producto_id)) {
                        continue;
                    }

                    $cantidadPorDescontar = (int) $detalle->cantidad;

                    // 1. Descuento de stock en Lotes aplicando lockForUpdate()
                    if (!empty($detalle->lote_id)) {
                        // Lote especificado explícitamente en el detalle
                        $lote = Lote::where('id', $detalle->lote_id)
                            ->lockForUpdate()
                            ->first();

                        if (!$lote || $lote->cantidad_disponible < $cantidadPorDescontar) {
                            throw new RuntimeException(
                                sprintf(
                                    'Stock insuficiente en el lote #%s para el producto ID %d. Solicitado: %d, Disponible: %d',
                                    (string) $detalle->lote_id,
                                    (int) $detalle->producto_id,
                                    $cantidadPorDescontar,
                                    $lote ? (int) $lote->cantidad_disponible : 0
                                )
                            );
                        }

                        $lote->cantidad_disponible -= $cantidadPorDescontar;
                        $lote->recalcularEstado();
                    } else {
                        // Estrategia FIFO para lotes disponibles en el almacén del comprobante
                        $lotes = Lote::where('producto_id', $detalle->producto_id)
                            ->where('almacen_id', $comprobante->almacen_id)
                            ->where('cantidad_disponible', '>', 0)
                            ->orderByRaw('fecha_vencimiento IS NULL, fecha_vencimiento ASC')
                            ->orderBy('id', 'ASC')
                            ->lockForUpdate()
                            ->get();

                        $pendiente = $cantidadPorDescontar;

                        foreach ($lotes as $lote) {
                            if ($pendiente <= 0) {
                                break;
                            }

                            $aDescontar = min($lote->cantidad_disponible, $pendiente);
                            $lote->cantidad_disponible -= $aDescontar;
                            $lote->recalcularEstado();
                            $pendiente -= $aDescontar;
                        }

                        if ($pendiente > 0) {
                            throw new RuntimeException(
                                sprintf(
                                    'Stock insuficiente en almacén ID %d para el producto ID %d. Faltante: %d unidades.',
                                    (int) $comprobante->almacen_id,
                                    (int) $detalle->producto_id,
                                    $pendiente
                                )
                            );
                        }
                    }

                    // 2. Bloqueo pesimista y actualización del estado de Series a "Vendido"
                    if (!empty($detalle->serie_id)) {
                        $serie = SerieProducto::where('id', $detalle->serie_id)
                            ->lockForUpdate()
                            ->first();

                        if ($serie) {
                            $serie->estado_id = $estadoVendidoId;
                            $serie->fecha_ultimo_movimiento = $now;
                            $serie->save();
                        }
                    } elseif (!empty($detalle->numero_serie)) {
                        $serie = SerieProducto::where('numero_serie', $detalle->numero_serie)
                            ->where('producto_id', $detalle->producto_id)
                            ->lockForUpdate()
                            ->first();

                        if ($serie) {
                            $serie->estado_id = $estadoVendidoId;
                            $serie->fecha_ultimo_movimiento = $now;
                            $serie->save();
                        }
                    }
                }
            });
        } catch (Throwable $e) {
            Log::error(
                sprintf('Error en DescontarStockLoteYSeriesListener para comprobante #%s: %s', $event->comprobante->id ?? 'N/A', $e->getMessage()),
                [
                    'exception'      => $e,
                    'comprobante_id' => $event->comprobante->id ?? null,
                ]
            );

            throw $e;
        }
    }
}
