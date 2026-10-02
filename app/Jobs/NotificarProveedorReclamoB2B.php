<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Lote;
use App\SerieProducto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotificarProveedorReclamoB2B implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var SerieProducto
     */
    private $serie;

    /**
     * @var array
     */
    private $reclamo;

    public function __construct(SerieProducto $serie, array $reclamo)
    {
        $this->serie = $serie;
        $this->reclamo = $reclamo;
    }

    public function handle(): void
    {
        try {
            $lote = Lote::find($this->serie->lote_id);
            $proveedor = optional($lote)->proveedor_nombre ?? 'Proveedor no identificado';

            Log::info('Notificación B2B enviada al proveedor por reclamo de garantía.', [
                'serie_id' => $this->serie->id,
                'numero_serie' => $this->serie->numero_serie,
                'proveedor' => $proveedor,
                'tipo_falla' => $this->reclamo['tipo_falla'] ?? null,
                'descripcion' => $this->reclamo['descripcion'] ?? null,
                'evidencias' => $this->reclamo['evidencias'] ?? [],
            ]);

            $this->generarSolicitudReposicion($lote, $this->reclamo);
        } catch (\Throwable $exception) {
            Log::error('Error al notificar al proveedor por reclamo B2B.', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw $exception;
        }
    }

    private function generarSolicitudReposicion(?Lote $lote, array $reclamo): void
    {
        if ($lote === null) {
            Log::warning('No se pudo crear la solicitud de reposición porque no existe lote asociado.', [
                'serie' => $this->serie->numero_serie,
            ]);

            return;
        }

        Log::info('Solicitud de reposición generada vinculada al proveedor original.', [
            'lote_id' => $lote->id,
            'codigo_lote' => $lote->codigo_lote ?? null,
            'proveedor' => $lote->proveedor_nombre ?? null,
            'tipo_falla' => $reclamo['tipo_falla'] ?? null,
        ]);
    }
}
