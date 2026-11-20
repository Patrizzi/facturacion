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

                // Enlaza la serie individual con la línea de boleta cuando se vendió una unidad.
                $serie = null;
                if (!empty($registro->serie_id)) {
                    $serie = SerieProducto::where('id', $registro->serie_id)
                        ->lockForUpdate()
                        ->first();
                } elseif ($cantidadVenta === 1 && !empty($registro->numero_serie)) {
                    $serie = SerieProducto::where('numero_serie', trim($registro->numero_serie))
                        ->where('producto_id', $registro->producto_id)
                        ->lockForUpdate()
                        ->first();
                }
                $estadoEnStockId = EstadoProducto::where('nombre_estado', 'En Stock')->value('id');

                if (!empty($registro->numero_serie) && $cantidadVenta !== 1) {
                    throw new RuntimeException('Registra una sola unidad por línea cuando ingreses un número de serie.');
                }
                if (!empty($registro->numero_serie) && !$serie) {
                    throw new RuntimeException('El número de serie no existe para este producto; revisa el número antes de guardar la venta.');
                }
                if ($serie && $cantidadVenta !== 1) {
                    throw new RuntimeException('Una línea con número de serie debe vender exactamente una unidad.');
                }
                if ($serie && (!$estadoEnStockId || (int) $serie->estado_id !== (int) $estadoEnStockId)) {
                    throw new RuntimeException('La serie indicada ya no está disponible para la venta.');
                }

                if ($serie) {
                    $registro->serie_id = $serie->id;
                    if (empty($registro->lote_id) && !empty($serie->lote_id)) {
                        $registro->lote_id = $serie->lote_id;
                    }
                    if (empty($registro->codigo_lote)) {
                        $loteSerie = $serie->lote_id
                            ? Lote::whereKey($serie->lote_id)->first()
                            : null;
                        $registro->codigo_lote = $serie->codigo_lote ?: optional($loteSerie)->lote;
                    }
                    DB::table('boleta_registro')->where('id', $registro->id)->update([
                        'serie_id' => $registro->serie_id,
                        'lote_id' => $registro->lote_id,
                        'codigo_lote' => $registro->codigo_lote,
                    ]);
                }

                // 1. Decrementar stock disponible del lote con bloqueo pesimista
                $loteAsignado = null;
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

                    $loteAsignado = $lote;
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
                    $lotesUsados = [];
                    foreach ($lotes as $lote) {
                        if ($pendiente <= 0) {
                            break;
                        }

                        $aDescontar = min($lote->cantidad_disponible, $pendiente);
                        $lote->cantidad_disponible -= $aDescontar;
                        $lote->recalcularEstado();
                        if ($aDescontar > 0) {
                            $lotesUsados[] = $lote;
                        }
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

                    // Solo se guarda un lote en la línea cuando toda la venta salió de ese lote.
                    if (count($lotesUsados) === 1) {
                        $loteUsado = $lotesUsados[0];
                        $loteAsignado = $loteUsado;
                        $registro->lote_id = $loteUsado->id;
                        $registro->codigo_lote = $loteUsado->lote;
                        DB::table('boleta_registro')->where('id', $registro->id)->update([
                            'lote_id' => $registro->lote_id,
                            'codigo_lote' => $registro->codigo_lote,
                        ]);
                    }
                }

                // Si se vendió una unidad sin indicar su serie, asigna una serie disponible
                // del lote FIFO que acaba de descontarse para registrar fecha y garantía.
                if (!$serie && $cantidadVenta === 1 && $loteAsignado) {
                    if ($estadoEnStockId) {
                        $serie = SerieProducto::where('producto_id', $registro->producto_id)
                            ->where('lote_id', $loteAsignado->id)
                            ->where('estado_id', $estadoEnStockId)
                            ->orderBy('id')
                            ->lockForUpdate()
                            ->first();
                    }

                    if ($serie) {
                        $registro->serie_id = $serie->id;
                        $registro->numero_serie = $serie->numero_serie;
                        $registro->lote_id = $loteAsignado->id;
                        $registro->codigo_lote = $loteAsignado->lote;
                        DB::table('boleta_registro')->where('id', $registro->id)->update([
                            'serie_id' => $registro->serie_id,
                            'numero_serie' => $registro->numero_serie,
                            'lote_id' => $registro->lote_id,
                            'codigo_lote' => $registro->codigo_lote,
                        ]);
                    }
                }

                // 2. Actualizar estado de las series asociadas a "Vendido" y persistir Garantía
                $estadoVendido = EstadoProducto::where('nombre_estado', 'Vendido')->first();
                $estadoVendidoId = $estadoVendido ? $estadoVendido->id : null;
                $now = Carbon::now();

                if ($serie) {
                    $serie->estado_id = $estadoVendidoId;
                    $serie->fecha_ultimo_movimiento = $now;
                    $serie->save();

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
