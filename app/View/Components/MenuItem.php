<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Data\MenuItemData;

class MenuItem extends Component {
    static $MIN_LEVEL = 1;
    static $MAX_LEVEL = 3;
    public string $text;
    public string $url;
    public ?string $icon;
    public array $submenus;

    /**
     * Component for SideMenu
     * @param \App\Data\MenuItemData $menu
     * @param int $level
     */
    public function __construct(public MenuItemData $menu, public int $nextLevel = 2) {
        $this->text = $menu->getText();
        $this->url = $menu->getRoute();
        $this->icon = $menu->getIcon();
        $this->submenus = $menu->getSubmenus();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.menu-item');
    }

    public function getClass(): ?string {
        $classes = [
            2 => 'nav nav-second-level collapse',
            3 => 'nav nav-third-level collapse',
        ];

        return $classes[$this->nextLevel]
            ? 'class="' . $classes[$this->nextLevel] . '"'
            : null;
    }
}
