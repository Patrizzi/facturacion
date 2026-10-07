<?php

declare(strict_types=1);

namespace App\Services;

use App\SerieProducto;
use Carbon\Carbon;

class GarantiaService
{
    /**
     * @var GarantiaRulesEngineService
     */
    private $garantiaRulesEngineService;

    public function __construct(GarantiaRulesEngineService $garantiaRulesEngineService)
    {
        $this->garantiaRulesEngineService = $garantiaRulesEngineService;
    }

    /**
     * Calcula la vigencia y estatus de una garantía a partir de la fecha de compra.
     */
    public function calcularVigencia($fechaCompra, $mesesGarantia = 12): array
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

    /**
     * Evalúa el reclamo de una serie mediante el motor de reglas de garantía.
     */
    public function evaluarReclamo(SerieProducto $serie, array $datosReclamo = []): array
    {
        return $this->garantiaRulesEngineService->evaluarReclamo($serie, $datosReclamo);
    }
}
