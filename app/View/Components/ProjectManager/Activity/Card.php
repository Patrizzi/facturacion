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
    public $contenido;
    public $fecha_inicio;
    public $barra_progreso;
    public $url_buttons;

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
        $this->contenido = $card->contenido ?? 'Sin contenido';
        $this->fecha_inicio = $card->fecha_inicio->format('d/m/Y');
        $this->barra_progreso = progressDate($card->fecha_inicio, $card->fecha_cierre);
        $this->url_buttons['create_task'] = route('project_managers.cards.tasks.create', [$card->project_manager, $card->id]);
        $this->url_buttons['edit_card'] = route('project_managers.cards.edit', [$card->project_manager, $card->id]);
        $this->url_buttons['delete_card'] = route('project_managers.cards.destroy', [$card->project_manager, $card->id]);
        $this->url_buttons['tasks_card'] = route('project_managers.cards.tasks.index', [$card->project_manager, $card->id]);
    }

    public function render()
    {
        return view('components.project-manager.activity.card');
    }
}
