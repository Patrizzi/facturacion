<?php

namespace App\View\Components\ProjectManager\Activity;

use Illuminate\View\Component;
use Str;

class Comment extends Component
{
    public $user_name;
    public $user_foto;
    public $message_side;

    public function __construct(public $comment)
    {
        $this->comment = $comment;
        if ($comment->user) {
            $this->user_name = Str::ucfirst($comment->user->nombre ?? $comment->user->name);
            $this->user_foto = getImageUrl($comment->user->avatar, 1);
        } else {
            $this->user_name = 'Sin responsable';
            $this->user_foto = getImageUrl('defecto_avatar.jpg', 1);
        }
        $this->message_side = $comment->user_id == auth()->id() ? 'right' : 'left';
    }

    public function render()
    {
        return view('components.project-manager.activity.comment');
    }
}
