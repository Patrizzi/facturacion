<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Task extends Component
{
    public $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function render()
    {
        return view('components.activity.task');
    }
}
