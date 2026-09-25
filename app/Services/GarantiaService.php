<?php

namespace App\Services;

use Carbon\Carbon;

class GarantiaService
{
    /**
     * Calcula la vigencia y estatus de una garantía a partir de la fecha de compra.
     */
    public function calcularVigencia($fechaCompra, $mesesGarantia = 12)
    {
        $compra = Carbon::parse($fechaCompra);
        $vencimiento = (clone $compra)->addMonths((int)$mesesGarantia);
        $ahora = Carbon::now();

        $mesesTranscurridos = $compra->diffInMonths($ahora);
        $esVigente = $ahora->lte($vencimiento);

        return [
            'fecha_compra' => $compra->format('Y-m-d'),
            'fecha_vencimiento' => $vencimiento->format('Y-m-d'),
            'tiempo_garantia' => $mesesGarantia . ' meses',
            'garantia_transcurrida' => $mesesTranscurridos . ' mes(es)',
            'estado' => $esVigente ? 'Vigente' : 'Vencido',
            'es_vigente' => $esVigente,
        ];
    }
}
