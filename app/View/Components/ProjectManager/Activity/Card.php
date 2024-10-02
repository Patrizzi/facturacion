<?php

namespace App\View\Components\ProjectManager\Activity;

use Illuminate\View\Component;
use Str;

class Card extends Component
{
    public $titulo;
    public $card_foto;
    public $responsable;
    public $responsable_foto;
    public $fecha_inicio;
    public $barra_progreso;

    public function __construct(public $card)
    {
        $this->card = $card;
        $this->titulo = Str::ucfirst($card->nombre);
        $this->card_foto = getImageUrl($card->foto, 2);
        if ($card->responsable) {
            $this->responsable = Str::ucfirst($card->responsable->nombre ?? $card->responsable->name);
            $this->responsable_foto = getImageUrl($card->responsable->avatar, 1);
        } else {
            $this->responsable = 'Sin responsable';
            $this->responsable_foto = getImageUrl('defecto_avatar.jpg', 1);
        }

        $this->fecha_inicio = $card->fecha_inicio->format('d/m/Y');
        $this->barra_progreso = progressDate($card->fecha_inicio, $card->fecha_cierre);

    }

    public function render()
    {
        return view('components.project-manager.activity.card');
    }
}
