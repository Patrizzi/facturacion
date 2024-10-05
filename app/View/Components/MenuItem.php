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
        public MenuItemData $menuItem,
        public int $level = 1
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

    public function getNextLevelMenu(): string {
        return match ($this->level) {
            1 => 'second',
            2 => 'third',
            default => '',
        };
    }

    public function hasNotifications(): bool {
        return $this->menuItem->notifications > 0;
    }

    public function notificationCount(): string {
        return $this->menuItem->notifications > 99 ? '+99' : $this->menuItem->notifications;
    }
}
