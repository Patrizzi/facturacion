<?php

declare(strict_types=1);

namespace App\Observers;

use App\EstadoProducto;
use App\GarantiaSerie;
use App\Lote;
use App\NotaVentaRegistro;
use App\SerieProducto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class NotaVentaRegistroObserver
{
    /**
     * Se ejecuta automáticamente al persistir un registro de Nota de Venta.
     * Decrementa el stock disponible del lote vinculado con bloqueo pesimista,
     * actualiza la serie a "Vendido" y persiste el registro de garantía.
     *
     * @param NotaVentaRegistro $registro
     * @return void
     * @throws Throwable
     */
    public function created(NotaVentaRegistro $registro): void
    {
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
                                'Stock insuficiente en el lote #%s para la Nota de Venta. Solicitado: %d, Disponible: %d',
                                (string) $registro->lote_id,
                                $cantidadVenta,
                                $lote ? (int) $lote->cantidad_disponible : 0
                            )
                        );
                    }

                    $lote->cantidad_disponible -= $cantidadVenta;
                    $lote->recalcularEstado();
                } else {
                    // Estrategia FIFO en el almacén de la nota de venta si la serie identifica el producto
                    $notaVenta = $registro->notaVenta;
                    $almacenId = $notaVenta ? $notaVenta->almacen_id : null;

                    $productoId = null;
                    if (!empty($registro->serie_id)) {
                        $serieRef = SerieProducto::find($registro->serie_id);
                        $productoId = $serieRef ? $serieRef->producto_id : null;
                    } elseif (!empty($registro->numero_serie)) {
                        $serieRef = SerieProducto::where('numero_serie', $registro->numero_serie)->first();
                        $productoId = $serieRef ? $serieRef->producto_id : null;
                    }

                    if ($productoId) {
                        $lotes = Lote::where('producto_id', $productoId)
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
                                    'Stock insuficiente en lotes para el producto ID %d en Nota de Venta. Faltante: %d unidades.',
                                    (int) $productoId,
                                    $pendiente
                                )
                            );
                        }
                    }
                }

                // 2. Modificar el estado de la serie física vinculada a "Vendido"
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
                        ->lockForUpdate()
                        ->first();
                }

                if ($serie) {
                    $serie->estado_id = $estadoVendidoId;
                    $serie->fecha_ultimo_movimiento = $now;
                    $serie->save();

                    // 3. Crear o actualizar el registro de garantía en GarantiaSerie
                    $producto = $serie->producto;
                    $notaVenta = $registro->notaVenta;

                    $mesesGarantia = (int) (
                        optional($notaVenta)->garantia 
                        ?? optional($producto)->garantia 
                        ?? optional($producto)->garantia_meses 
                        ?? 12
                    );
                    if ($mesesGarantia <= 0) {
                        $mesesGarantia = 12;
                    }

                    $fechaEmisionRaw = $notaVenta ? ($notaVenta->getOriginal('fecha_emision') ?? $notaVenta->fecha_emision) : null;
                    $fechaVenta = $fechaEmisionRaw
                        ? Carbon::parse($fechaEmisionRaw)->toDateString()
                        : ($registro->created_at ? Carbon::parse($registro->created_at)->toDateString() : Carbon::today()->toDateString());

                    $fechaVencimiento = Carbon::parse($fechaVenta)->addMonths($mesesGarantia)->toDateString();

                    GarantiaSerie::updateOrCreate(
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
                sprintf('Error en NotaVentaRegistroObserver para registro #%s: %s', (string) ($registro->id ?? 'N/A'), $e->getMessage()),
                [
                    'exception'   => $e,
                    'registro_id' => $registro->id ?? null,
                ]
            );

            throw $e;
        }
    }
}
