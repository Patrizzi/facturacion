<?php

namespace App\Data\Menu;

class MenuItemData {
    public string $text;
    public string $url;
    public ?string $icon;
    public array $subMenus;

    public function __construct(
        string $text,
        ?string $url = '#',
        ?string $icon = null,
        array $subMenus = []
    ) {
        $this->text = $text;
        $this->url = $url;
        $this->icon = $icon;
        $this->subMenus = array_map(function ($subMenu) {
            // Si es un array, creamos una nueva instancia de MenuItemData
            if (is_array($subMenu)) {
                return new self(
                    $subMenu['text'] ?? 'Unnamed',
                    $subMenu['url'] ?? '#',
                    $subMenu['icon'] ?? null,
                    $subMenu['subMenus'] ?? []
                );
            }

            // Si es una instancia de MenuItemData, simplemente la devolvemos
            if ($subMenu instanceof self) {
                return $subMenu;
            }

            throw new \InvalidArgumentException('Invalid subMenu item');
        }, $subMenus);
    }
}
