<?php

namespace App\View\Components\ProjectManager\Activity;

use Illuminate\View\Component;
use Str;
use App\Activity;

class Card extends Component
{
    public $id;
    public $color;
    public $titulo;
    public $foto;
    public $foto_url;
    public $contenido;
    public $fecha_inicio;
    public $tiempo_transcurrido;
    public $progreso;

    public $responsable_id;
    public $responsable_nombre;
    public $responsable_foto;
    
    public $url_buttons;

    public function __construct(public $card = null)
    {
        if (!is_numeric($card) && !($card instanceof Activity)) {
            $this->setDefaultValues();
            return;
        }

        if (is_numeric($card)) {
            $card = Activity::find($card);
        }

        if (!$card instanceof Activity) {
            $this->setDefaultValues();
            return;
        }
        
        $this->card = $card;
        $this->id = $card->id;
        $this->color = $card->color;
        $this->titulo = Str::ucfirst($card->nombre);
        $this->foto = $card->foto;
        $this->foto_url = getImageUrl($card->foto, 2);
        $this->contenido = $card->contenido ?? 'Sin contenido';
        $this->fecha_inicio = $card->fecha_inicio->format('d/m/Y');
        $this->tiempo_transcurrido = createdTime($card);
        $this->progreso = progressDate($card->fecha_inicio, $card->fecha_cierre);

        // Datos de 
        $this->responsable_id = $card->responsable_id;
        if ($card->responsable) {
            $this->responsable_nombre = Str::ucfirst($card->responsable->nombre ?? $card->responsable->name);
            $this->responsable_foto = getImageUrl($card->responsable->avatar, 1);
        } else {
            $this->responsable_nombre = 'Sin responsable';
            $this->responsable_foto = getImageUrl('defecto_avatar.jpg', 1);
        }

        // URLs de los botones
        $this->url_buttons['create_task'] = route('project_managers.cards.tasks.create', [$card->project_manager, $card->id]);
        $this->url_buttons['edit_card'] = route('project_managers.cards.edit', [$card->project_manager, $card->id]);
        $this->url_buttons['delete_card'] = route('project_managers.cards.destroy', [$card->project_manager, $card->id]);
        $this->url_buttons['tasks_card'] = route('project_managers.cards.tasks.index', [$card->project_manager, $card->id]);
    }

    public function cardFound(): bool
    {
        return $this->id !== "not-found";
    }

    private function setDefaultValues()
    {
        $this->id = "not-found";
        $this->titulo = 'Tarjeta no encontrada';
        $this->color = '#1a5eb3';
        $this->foto_url = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRtUVYATWPrDOHE_R5qO_XBS5VyJ6Sx78bSUw&s";
    }

    public function render()
    {
        return view('components.project-manager.activity.card');
    }
}
