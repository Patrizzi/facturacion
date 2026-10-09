<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KardexEntradaProcesado
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Instancia del registro de entrada en Kardex procesado.
     *
     * @var Model
     */
    public Model $kardexRegistro;

    /**
     * Crea una nueva instancia del evento.
     *
     * @param Model $kardexRegistro
     */
    public function __construct(Model $kardexRegistro)
    {
        $this->kardexRegistro = $kardexRegistro;
    }
}
