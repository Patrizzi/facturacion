<?php

namespace App\View\Components\ProjectManager\Activity;

use Illuminate\View\Component;
use Str;

class Task extends Component
{
    public $worker_name;
    public $fecha_inicio;
    public $barra_progreso;

    public function __construct(public $task)
    {
        $this->task = $task;
        $this->worker_name = Str::ucfirst($task->user->nombre ?? $task->user->name);
        $this->fecha_inicio = $task->fecha_inicio->format('d/m/Y');
        $this->barra_progreso = progressDate($task->fecha_inicio, $task->fecha_cierre);
    }

    public function render()
    {
        return view('components.project_manager.activity.task');
    }
}
