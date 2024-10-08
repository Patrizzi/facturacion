<?php

namespace App\Builders;

use App\Abstracts\MenuItemAbstract;
use App\Data\MenuItemData;

class MenuItemBuilder extends MenuItemAbstract {

    public function __call($name, $arguments) {
        if (empty($arguments)) {
            throw new \InvalidArgumentException("El parámetro es obligatorio y no se proporcionó.");
        }

        if (!array_key_exists($name, $this->attributes)) {
            throw new \BadMethodCallException("El método o atributo $name no está permitido.");
        }

        $this->attributes[$name] = count($arguments) > 1 ? $arguments : $arguments[0];

        return $this;
    }

    public function reset(): self {
        $this->attributes = [
            'text' => '',
            'route' => '#',
            'icon' => '',
            'count' => 0,
            'permissions' => [],
            'submenus' => [],
        ];
        return $this;
    }

    public function build(): MenuItemData {
        return new MenuItemData($this->attributes);;
    }
}