<?php

declare(strict_types=1);

namespace App\ValueObjects;

final class VeredictoGarantia
{
    public const APROBADO_AUTOMATICO = 'APROBADO_AUTOMATICO';
    public const RECHAZADO_EXCLUSION = 'RECHAZADO_EXCLUSION';
    public const ESCALAR_TECNICO = 'ESCALAR_TECNICO';

    /**
     * @var string
     */
    private $estado;

    /**
     * @var string
     */
    private $mensaje;

    public function __construct(string $estado, string $mensaje)
    {
        $estadosValidos = [
            self::APROBADO_AUTOMATICO,
            self::RECHAZADO_EXCLUSION,
            self::ESCALAR_TECNICO,
        ];

        if (!in_array($estado, $estadosValidos, true)) {
            throw new \InvalidArgumentException(sprintf('Estado de garantía inválido: %s', $estado));
        }

        $this->estado = $estado;
        $this->mensaje = $mensaje;
    }

    public static function aprobadoAutomatico(string $mensaje = 'Defecto de fábrica validado automáticamente.')
    {
        return new self(self::APROBADO_AUTOMATICO, $mensaje);
    }

    public static function rechazadoExclusion(string $mensaje = 'Rechazado por exclusión de garantía.')
    {
        return new self(self::RECHAZADO_EXCLUSION, $mensaje);
    }

    public static function escalarTecnico(string $mensaje = 'Se requiere revisión técnica por evidencia insuficiente.')
    {
        return new self(self::ESCALAR_TECNICO, $mensaje);
    }

    public function estado(): string
    {
        return $this->estado;
    }

    public function mensaje(): string
    {
        return $this->mensaje;
    }

    public function toArray(): array
    {
        return [
            'estado' => $this->estado,
            'mensaje' => $this->mensaje,
        ];
    }

    public function __toString(): string
    {
        return $this->estado;
    }
}
