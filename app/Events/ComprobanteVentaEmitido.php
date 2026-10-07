<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ComprobanteVentaEmitido
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Instancia del comprobante de venta emitido (Factura, Boleta, etc.).
     *
     * @var Model
     */
    public Model $comprobante;

    /**
     * Crea una nueva instancia del evento.
     *
     * @param Model $comprobante
     */
    public function __construct(Model $comprobante)
    {
        $this->comprobante = $comprobante;
    }
}
