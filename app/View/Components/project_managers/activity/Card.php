<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $card;
    
    public function __construct($card)
    {
        $this->card = $card;
    }

    public function render()
    {
        return view('components.activity.card');
    }
}
