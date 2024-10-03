<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Data\Menu\MenuItemData;

class MenuItem extends Component {
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public MenuItemData $menuItem
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.menu-item');
    }
}
