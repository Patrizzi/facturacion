<?php

namespace App\View\Components\ProjectManager\Activity;

use Illuminate\View\Component;
use Str;

class Card extends Component
{
    public $titulo;
    public $responsable;
    public $fecha_inicio;
    public $barra_progreso;

    public function __construct(public $card)
    {
        $this->card = $card;
        $this->titulo = Str::ucfirst($card->nombre);
        $this->responsable = Str::ucfirst($card->responsable->nombre ?? $card->responsable->name);
        $this->fecha_inicio = $card->fecha_inicio->format('d/m/Y');
        $this->barra_progreso = progressDate($card->fecha_inicio, $card->fecha_cierre);
    }

    public function render()
    {
        return view('components.project_manager.activity.card');
    }
}
