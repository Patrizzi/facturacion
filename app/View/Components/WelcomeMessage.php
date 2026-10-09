<?php

namespace App\View\Components;

use App\Empresa;
use Illuminate\View\Component;

class WelcomeMessage extends Component {
    public Empresa $company;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct() {
        $this->company = Empresa::first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.welcome-message');
    }
}
