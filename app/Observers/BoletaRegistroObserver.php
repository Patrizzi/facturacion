<?php

declare(strict_types=1);

namespace App\Observers;

use App\Boleta_registro;
use App\EstadoProducto;
use App\Lote;
use App\SerieProducto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class BoletaRegistroObserver
{
    /**
     * Se ejecuta automáticamente al persistir un registro de boleta.
     * Decrementa el stock disponible del lote vinculado y actualiza las series a "Vendido".
     *
     * @param Boleta_registro $registro
     * @return void
     * @throws Throwable
     */
    public function created(Boleta_registro $registro): void
    {
        // Omitir si el ítem corresponde a un servicio o no tiene producto físico
        if (empty($registro->producto_id)) {
            return;
        }

        try {
            DB::transaction(function () use ($registro): void {
                $cantidadVenta = (int) ($registro->cantidad ?? 1);

                // 1. Decrementar stock disponible del lote con bloqueo pesimista
                if (!empty($registro->lote_id)) {
                    $lote = Lote::where('id', $registro->lote_id)
                        ->lockForUpdate()
                        ->first();

                    if (!$lote || $lote->cantidad_disponible < $cantidadVenta) {
                        throw new RuntimeException(
                            sprintf(
                                'Stock insuficiente en el lote #%s para el producto ID %d. Solicitado: %d, Disponible: %d',
                                (string) $registro->lote_id,
                                (int) $registro->producto_id,
                                $cantidadVenta,
                                $lote ? (int) $lote->cantidad_disponible : 0
                            )
                        );
                    }

                    $lote->cantidad_disponible -= $cantidadVenta;
                    $lote->recalcularEstado();
                } else {
                    // Estrategia FIFO en el almacén de la boleta
                    $boleta = $registro->boleta_i;
                    $almacenId = $boleta ? $boleta->almacen_id : null;

                    $lotes = Lote::where('producto_id', $registro->producto_id)
                        ->when($almacenId, static function ($q) use ($almacenId) {
                            $q->where('almacen_id', $almacenId);
                        })
                        ->where('cantidad_disponible', '>', 0)
                        ->orderByRaw('fecha_vencimiento IS NULL, fecha_vencimiento ASC')
                        ->orderBy('id', 'ASC')
                        ->lockForUpdate()
                        ->get();

                    $pendiente = $cantidadVenta;
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
                                'Stock insuficiente en lotes para el producto ID %d. Faltante: %d unidades.',
                                (int) $registro->producto_id,
                                $pendiente
                            )
                        );
                    }
                }

                // 2. Actualizar estado de las series asociadas a "Vendido"
                $estadoVendido = EstadoProducto::where('nombre_estado', 'Vendido')->first();
                $estadoVendidoId = $estadoVendido ? $estadoVendido->id : null;
                $now = Carbon::now();

                if (!empty($registro->serie_id)) {
                    $serie = SerieProducto::where('id', $registro->serie_id)
                        ->lockForUpdate()
                        ->first();

                    if ($serie) {
                        $serie->estado_id = $estadoVendidoId;
                        $serie->fecha_ultimo_movimiento = $now;
                        $serie->save();
                    }
                } elseif (!empty($registro->numero_serie)) {
                    $serie = SerieProducto::where('numero_serie', $registro->numero_serie)
                        ->where('producto_id', $registro->producto_id)
                        ->lockForUpdate()
                        ->first();

                    if ($serie) {
                        $serie->estado_id = $estadoVendidoId;
                        $serie->fecha_ultimo_movimiento = $now;
                        $serie->save();
                    }
                }
            });
        } catch (Throwable $e) {
            Log::error(
                sprintf('Error en BoletaRegistroObserver para registro #%s: %s', (string) ($registro->id ?? 'N/A'), $e->getMessage()),
                [
                    'exception'   => $e,
                    'registro_id' => $registro->id ?? null,
                ]
            );

            throw $e;
        }
    }
}
