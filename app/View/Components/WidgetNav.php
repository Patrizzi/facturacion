<?php

namespace App\View\Components;

use Illuminate\View\Component;

class WidgetNav extends Component {
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $icon = "fa-check",
        public string $span,
        public string $text
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.widget-nav');
    }
}
