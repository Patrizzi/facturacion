<?php

namespace App\View\Components\ProjectManager\Activity;

use Illuminate\View\Component;

class TasksChatView extends Component
{
    public $prueba;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $data)
    {
        $this->data = $data;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.project-manager.activity.tasks-chat-view', [
            'data' => $this->data
        ]);
    }
}
