<?php

declare(strict_types=1);

namespace App\Services;

use App\SerieProducto;

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

    public function evaluarReclamo(SerieProducto $serie, array $datosReclamo = []): array
    {
        return $this->garantiaRulesEngineService->evaluarReclamo($serie, $datosReclamo);
    }
}
