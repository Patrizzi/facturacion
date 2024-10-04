<?php

namespace App\Data\Menu;
use \Illuminate\Support\Facades\Gate;

class MenuItemData {
    public string $text;
    public string $url;
    public ?string $icon;
    public array $subMenus;
    public ?array $permissions;
    public int $notifications;

    public function __construct(
        string $text,
        ?string $url = '#',
        ?string $icon = null,
        array $subMenus = [],
        array $permissions = [],
        int $notifications = 0
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
                    $subMenu['subMenus'] ?? [],
                    $subMenu['permissions'] ?? [],
                    $subMenu['notifications'] ?? 0
                );
            }

            // Si es una instancia de MenuItemData, simplemente la devolvemos
            if ($subMenu instanceof self) {
                return $subMenu;
            }

            throw new \InvalidArgumentException('Invalid subMenu item');
        }, $subMenus);

        // Asignamos 'all' si no hay permisos definidos
        $this->permissions = empty($permissions) ? ['all'] : $permissions;
        $this->notifications = $notifications;
    }

    public function hasAccess(): bool
    {
        // Si permissions es 'all' o está vacío, permite acceso
        return in_array('all', $this->permissions) || Gate::any($this->permissions);
    }
}
