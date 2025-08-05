<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UserProfile extends Component
{
    public $foto;
    public $nombre;
    public $area;

    public function __construct($foto = null, $nombre = null, $area = null)
    {
        $this->foto = $foto ?? auth()->user()->avatar;
        $this->nombre = $nombre ?? auth()->user()->nombre;
        $this->area = $area ?? auth()->user()->name;
    }

    public function render()
    {
        return view('components.user-profile');
    }
}
