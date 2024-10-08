<?php

namespace App\Data;

use App\Abstracts\MenuItemAbstract;

class MenuItemData extends MenuItemAbstract {

    protected string $text;
    protected string $route;
    protected ?string $icon;
    protected array $submenus;
    protected array $permissions;
    protected int $count;

    public function __call($name, $arguments) {
        if (strpos($name, 'get') === 0) {
            $attribute = strtolower(substr($name, 3));
            if (array_key_exists($attribute, $this->attributes)) {
                return $this->$attribute;
            }
        }
    }

    public function __construct(private array $data) {
        $data = array_merge($this->attributes, $data);
        $this->text = $data['text'];
        $this->route = is_array($data['route'])
            ? route(...$data['route'])
            : ($data['route'] !== "#" ? route($data['route']) : "#");
        $this->icon = !empty($data['icon']) ? asset($data['icon']) : '';
        $this->permissions = array_filter((array) $data['permissions']);
        $this->count = $data['count'];

        $this->submenus = array_map(function ($sm): MenuItemData {
            if (is_array($sm)) {
                return new self(array_merge($this->attributes, $sm));
            }

            if ($sm instanceof self) {
                return $sm;
            }

            throw new \InvalidArgumentException('Invalid subMenu[] item');
        }, $data['submenus'] ?? []);
    }

    public function hasAlerts(): bool {
        return $this->count > 0;
    }

    public function alertsFormat(): string {
        $count = $this->count;

        return $count > 99 ? '+99' : (string) $count;
    }

    public function hasAccess(): bool {

        /** @var \App\User $user */
        $user = auth()->user();

        return empty($this->permissions) || $user->hasAnyPermission($this->permissions);
    }
}
