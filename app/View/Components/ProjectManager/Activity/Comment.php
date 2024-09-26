<?php

namespace App\View\Components\ProjectManager\Activity;

use Illuminate\View\Component;
use Str;

class Comment extends Component
{
    public $user_name;
    public $message_side;

    public function __construct(public $comment)
    {
        $this->comment = $comment;
        $this->user_name = Str::ucfirst($comment->user->nombre ?? $comment->user->name);
        $this->message_side = $comment->user_id == auth()->id() ? 'right' : 'left';
    }

    public function render()
    {
        return view('components.project_manager.activity.comment');
    }
}
