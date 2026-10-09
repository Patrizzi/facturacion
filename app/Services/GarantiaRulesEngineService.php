<?php

declare(strict_types=1);

namespace App\Services;

use App\SerieProducto;
use App\ValueObjects\VeredictoGarantia;
use Carbon\Carbon;

class GarantiaRulesEngineService
{
    public function evaluarCobertura(SerieProducto $serie, string $tipoFalla, array $condicionesUso = []): VeredictoGarantia
    {
        try {
            $tipoFallaNormalizado = $this->normalizarTipoFalla($tipoFalla);
            $condiciones = $this->normalizarCondicionesUso($condicionesUso);

            if ($serie->fecha_vencimiento_garantia !== null && $serie->fecha_vencimiento_garantia !== '') {
                $fechaVencimiento = Carbon::parse($serie->fecha_vencimiento_garantia)->endOfDay();
                if (Carbon::now()->greaterThan($fechaVencimiento)) {
                    return VeredictoGarantia::rechazadoExclusion('La garantía está vencida por fecha de vigencia.');
                }
            }

            if ($this->tieneExclusion($tipoFallaNormalizado, $condiciones)) {
                $motivo = $this->motivoExclusion($tipoFallaNormalizado, $condiciones);
                return VeredictoGarantia::rechazadoExclusion($motivo);
            }

            $resultado = match ($tipoFallaNormalizado) {
                'defecto de fabrica', 'defecto_de_fabrica' => VeredictoGarantia::aprobadoAutomatico('Defecto de fábrica detectado dentro del periodo de cobertura.'),
                'falla electrica', 'falla eléctrica' => $this->evaluarFallaElectrica($condiciones),
                'desgaste', 'desgaste normal' => VeredictoGarantia::escalarTecnico('Falla por desgaste, requiere revisión técnica.'),
                'falla no concluyente', 'indeterminado', 'sin evidencia' => VeredictoGarantia::escalarTecnico('La falla no es concluyente y requiere evaluación técnica.'),
                default => VeredictoGarantia::escalarTecnico('Tipo de falla no clasificado; se requiere revisión técnica.')
            };

            return $resultado;
        } catch (\Throwable $exception) {
            return VeredictoGarantia::escalarTecnico(
                sprintf('No fue posible evaluar la cobertura: %s', $exception->getMessage())
            );
        }
    }

    public function evaluarReclamo($serie, array $datosReclamo = []): array
    {
        $tipoFalla = (string) ($datosReclamo['tipo_falla'] ?? 'defecto de fabrica');
        $condicionesUso = (array) ($datosReclamo['condiciones_uso'] ?? []);

        $veredicto = $this->evaluarCobertura($serie, $tipoFalla, $condicionesUso);

        return $veredicto->toArray();
    }

    private function evaluarFallaElectrica(array $condiciones): VeredictoGarantia
    {
        if (($condiciones['evidencia_clearly_weak'] ?? false) || ($condiciones['falta_evidencia'] ?? false)) {
            return VeredictoGarantia::escalarTecnico('Falla eléctrica con evidencia insuficiente; requiere revisión técnica.');
        }

        return VeredictoGarantia::aprobadoAutomatico('Falla eléctrica confirmada dentro de la vigencia.');
    }

    private function tieneExclusion(string $tipoFalla, array $condiciones): bool
    {
        $exclusiones = [
            'daño físico',
            'daño_fisico',
            'derrame de liquidos',
            'derrame de líquidos',
            'derrame_liquido',
            'manipulacion no autorizada',
            'manipulación no autorizada',
            'manipulacion_no_autorizada',
        ];

        if (in_array($tipoFalla, $exclusiones, true)) {
            return true;
        }

        if (($condiciones['sello_roto'] ?? false) || ($condiciones['desmontaje_incorrecto'] ?? false)) {
            return true;
        }

        if (($condiciones['derrame_liquido'] ?? false) || ($condiciones['manipulacion_no_autorizada'] ?? false)) {
            return true;
        }

        return false;
    }

    private function motivoExclusion(string $tipoFalla, array $condiciones): string
    {
        if (in_array($tipoFalla, ['daño físico', 'daño_fisico'], true)) {
            return 'Rechazado por daño físico del equipo.';
        }

        if (in_array($tipoFalla, ['derrame de liquidos', 'derrame de líquidos', 'derrame_liquido'], true)
            || ($condiciones['derrame_liquido'] ?? false)) {
            return 'Rechazado por derrame de líquidos.';
        }

        if (in_array($tipoFalla, ['manipulacion no autorizada', 'manipulación no autorizada', 'manipulacion_no_autorizada'], true)
            || ($condiciones['manipulacion_no_autorizada'] ?? false)) {
            return 'Rechazado por manipulación no autorizada.';
        }

        if (($condiciones['sello_roto'] ?? false) || ($condiciones['desmontaje_incorrecto'] ?? false)) {
            return 'Rechazado por evidencia de negligencia del usuario o manipulación indebida.';
        }

        return 'Rechazado por exclusión de la garantía.';
    }

    private function normalizarTipoFalla(string $tipoFalla): string
    {
        $tipoFalla = strtolower(trim($tipoFalla));

        $mapa = [
            'daño físico' => 'daño físico',
            'daño_fisico' => 'daño físico',
            'derrame de liquidos' => 'derrame de líquidos',
            'derrame de líquidos' => 'derrame de líquidos',
            'derrame_liquido' => 'derrame de líquidos',
            'manipulacion no autorizada' => 'manipulación no autorizada',
            'manipulación no autorizada' => 'manipulación no autorizada',
            'manipulacion_no_autorizada' => 'manipulación no autorizada',
            'defecto de fabrica' => 'defecto de fabrica',
            'defecto_de_fabrica' => 'defecto de fabrica',
            'falla electrica' => 'falla electrica',
            'falla eléctrica' => 'falla electrica',
            'falla_electrica' => 'falla electrica',
            'desgaste' => 'desgaste',
            'desgaste normal' => 'desgaste',
        ];

        return $mapa[$tipoFalla] ?? $tipoFalla;
    }

    private function normalizarCondicionesUso(array $condicionesUso): array
    {
        $normalizadas = [];

        foreach ($condicionesUso as $key => $valor) {
            $normalizadas[strtolower((string) $key)] = (bool) $valor;
        }

        return $normalizadas;
    }
}
