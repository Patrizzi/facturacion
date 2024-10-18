<?php

namespace App\View\Components\ProjectManager\Activity;

use Illuminate\View\Component;
use Str;

class Task extends Component
{
    public $user_name;
    public $user_foto;
    public $fecha_inicio;
    public $barra_progreso;
    public $url_buttons;

    public function __construct(public $task)
    {
        $this->task = $task;
        if ($task->user) {
            $this->user_name = Str::ucfirst($task->user->nombre ?? $task->user->name);
            $this->user_foto = getImageUrl($task->user->avatar, 1);
        } else {
            $this->user_name = 'Sin responsable';
            $this->user_foto = getImageUrl('defecto_avatar.jpg', 1);
        }
        $this->fecha_inicio = $task->fecha_inicio->format('d/m/Y');
        $this->barra_progreso = progressDate($task->fecha_inicio, $task->fecha_cierre);
        $this->url_buttons['edit_task'] = route('project_managers.cards.tasks.edit', [$task->activity->project_manager, $task->activity, $task]);
        $this->url_buttons['delete_task'] = route('project_managers.cards.tasks.destroy', [$task->activity->project_manager, $task->activity, $task]);
    }

    public function render()
    {
        return view('components.project-manager.activity.task');
    }
}
