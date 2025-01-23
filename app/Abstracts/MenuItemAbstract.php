<?php

namespace App\Abstracts;

abstract class MenuItemAbstract {
    protected $attributes = [
        'text' => '',
        'route' => '#',
        'icon' => null,
        'count' => 0,
        'permissions' => [],
        'submenus' => [],
    ];
}
