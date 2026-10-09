<?php

declare(strict_types=1);

namespace App\Observers;

use App\EstadoProducto;
use App\Facturacion_registro;
use App\Lote;
use App\SerieProducto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class FacturacionRegistroObserver
{
    /**
     * Se ejecuta automáticamente al persistir un registro de factura.
     * Decrementa el stock disponible del lote vinculado y actualiza las series a "Vendido".
     *
     * @param Facturacion_registro $registro
     * @return void
     * @throws Throwable
     */
    public function created(Facturacion_registro $registro): void
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
                    // Estrategia FIFO en el almacén del comprobante
                    $factura = $registro->factura_ids;
                    $almacenId = $factura ? $factura->almacen_id : null;

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

                // 2. Actualizar estado de las series asociadas a "Vendido" y persistir Garantía
                $estadoVendido = EstadoProducto::where('nombre_estado', 'Vendido')->first();
                $estadoVendidoId = $estadoVendido ? $estadoVendido->id : null;
                $now = Carbon::now();

                $serie = null;
                if (!empty($registro->serie_id)) {
                    $serie = SerieProducto::where('id', $registro->serie_id)
                        ->lockForUpdate()
                        ->first();
                } elseif (!empty($registro->numero_serie)) {
                    $serie = SerieProducto::where('numero_serie', $registro->numero_serie)
                        ->where('producto_id', $registro->producto_id)
                        ->lockForUpdate()
                        ->first();
                }

                if ($serie) {
                    $serie->estado_id = $estadoVendidoId;
                    $serie->fecha_ultimo_movimiento = $now;
                    $serie->save();

                    // Persistencia transaccional de la garantía de la serie
                    $producto = $registro->producto;
                    $mesesGarantia = (int) (optional($producto)->garantia ?? optional($producto)->garantia_meses ?? 12);
                    if ($mesesGarantia <= 0) {
                        $mesesGarantia = 12;
                    }

                    $factura = $registro->factura_ids;
                    $fechaVenta = $factura && $factura->fecha_emision
                        ? Carbon::parse($factura->fecha_emision)->toDateString()
                        : ($registro->created_at ? Carbon::parse($registro->created_at)->toDateString() : Carbon::today()->toDateString());
                    $fechaVencimiento = Carbon::parse($fechaVenta)->addMonths($mesesGarantia)->toDateString();

                    \App\GarantiaSerie::updateOrCreate(
                        ['serie_id' => $serie->id],
                        [
                            'estado_garantia'   => 'Vigente',
                            'fecha_venta'       => $fechaVenta,
                            'fecha_vencimiento' => $fechaVencimiento,
                            'duracion_meses'    => $mesesGarantia,
                        ]
                    );
                }
            });
        } catch (Throwable $e) {
            Log::error(
                sprintf('Error en FacturacionRegistroObserver para registro #%s: %s', (string) ($registro->id ?? 'N/A'), $e->getMessage()),
                [
                    'exception'   => $e,
                    'registro_id' => $registro->id ?? null,
                ]
            );

            throw $e;
        }
    }
}
