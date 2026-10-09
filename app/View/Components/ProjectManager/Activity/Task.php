<?php

namespace App\View\Components\ProjectManager\Activity;

use Illuminate\View\Component;
use Str;

class Task extends Component
{
    public $user_foto;
    public $user_name;
    public $contenido;
    public $fecha_inicio;
    public $barra_progreso;
    public $url_buttons;

    public function __construct(public $task)
    {
        $this->task = $task;
        if ($task->user) {
            $this->user_name = Str::ucfirst($task->user->nombre ?? $task->user->personal->nombres . ' ' . $task->user->personal->apellidos);
            $this->user_foto = getImageUrl($task->user->avatar, 1);
        } else {
            $this->user_name = 'Sin responsable';
            $this->user_foto = getImageUrl('defecto_avatar.jpg', 1);
        }
        $this->contenido = $task->contenido ?? 'Sin contenido';
        $this->fecha_inicio = $task->fecha_inicio->format('d/m/Y');
        $this->barra_progreso = progressDate($task->fecha_inicio, $task->fecha_cierre);

        $project_id = $task->activity->project_manager->id;
        $activity_id = $task->activity->id;
        $this->url_buttons['edit_task'] = route('project_managers.cards.tasks.edit', [$project_id, $activity_id, $task]);
        $this->url_buttons['delete_task'] = route('project_managers.cards.tasks.destroy', [$project_id, $activity_id, $task]);
        $this->url_buttons['load_comments'] = route('project_managers.cards.tasks.comments.index', [$project_id, $activity_id, $task]);
    }

    public function render()
    {
        return view('components.project-manager.activity.task');
    }
}
