<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormDinamico extends Component
{
    public $name;
    public $label;
    public $type;
    public $value;
    public $placeholder;
    public function __construct($name,$label,$type,$placeholder,$value)
    {
        $this->name=$name;
        $this->label=$label;
        $this->type=$type;
        $this->value=$value;
        $this->placeholder=$placeholder;
    }

    public function render()
    {
        return view('components.form-dinamico');
    }
}
