<?php

namespace App\Services;

class MenuService
{
    public function generate($user, $inventarioInicial = null): array
    {
        $menus = [];

        if (!$user) {
            return $menus;
        }

        $config = config('menu');

        foreach ($config as $menu) {

            /*
            |--------------------------------------------------------------------------
            | CASO 1: INVENTARIO INICIAL
            |--------------------------------------------------------------------------
            */
            if (isset($menu['initial'])) {

                if ($user->can($menu['initial']['permission'])) {

                    // No existe → crear
                    if (empty($inventarioInicial)) {
                        $menus[] = [
                            'type' => 'single',
                            'label' => 'Inventario Inicial',
                            'icon'  => $menu['icon'],
                            'route' => route($menu['initial']['route_create']),
                        ];
                        continue;
                    }

                    // Existe activo → show
                    if ($inventarioInicial->estado == 1) {
                        $menus[] = [
                            'type' => 'single',
                            'label' => 'Inventario Inicial',
                            'icon'  => $menu['icon'],
                            'route' => route(
                                $menu['initial']['route_show'],
                                $inventarioInicial->id
                            ),
                        ];
                        continue;
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | CASO 2: permission simple
            |--------------------------------------------------------------------------
            */
            if (isset($menu['permission'])) {

                if ($user->can($menu['permission'])) {
                    $menus[] = [
                        'type' => 'single',
                        'label' => $menu['label'],
                        'icon'  => $menu['icon'],
                        'route' => route($menu['route']),
                    ];
                }

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | CASO 3: routes dinámicas
            |--------------------------------------------------------------------------
            */
            if (isset($menu['routes'])) {

                $route = null;

                foreach ($menu['routes'] as $permission => $routeName) {
                    if ($user->can($permission)) {
                        $route = route($routeName);
                        break;
                    }
                }

                if ($route) {
                    $menus[] = [
                        'type' => 'single',
                        'label' => $menu['label'],
                        'icon'  => $menu['icon'],
                        'route' => $route,
                    ];
                }

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | CASO 4: permission_any
            |--------------------------------------------------------------------------
            */
            if (isset($menu['permission_any'])) {

                if ($this->hasAnyPermission($user, $menu['permission_any'])) {
                    $menus[] = [
                        'type' => 'single',
                        'label' => $menu['label'],
                        'icon'  => $menu['icon'],
                        'route' => route($menu['route']),
                    ];
                }

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | CASO 5: items (árbol)
            |--------------------------------------------------------------------------
            */
            if (isset($menu['items'])) {

                $children = $this->buildItems($user, $menu['items']);

                if (!empty($children)) {
                    $menus[] = [
                        'type' => 'tree',
                        'label' => $menu['label'],
                        'icon'  => $menu['icon'],
                        'children' => $children,
                    ];
                }
            }
        }

        return $menus;
    }

    /*
    |--------------------------------------------------------------------------
    | Construcción recursiva
    |--------------------------------------------------------------------------
    */
    private function buildItems($user, array $items): array
    {
        $result = [];

        foreach ($items as $item) {

            // permission_any
            if (
                isset($item['permission_any']) &&
                !$this->hasAnyPermission($user, $item['permission_any'])
            ) {
                continue;
            }

            // routes dinámicas (IMPORTANTE)
            if (isset($item['routes'])) {

                $route = null;

                foreach ($item['routes'] as $permission => $routeName) {
                    if ($user->can($permission)) {
                        $route = route($routeName);
                        break;
                    }
                }

                if ($route) {
                    $result[] = [
                        'label' => $item['label'],
                        'route' => $route,
                    ];
                }

                continue;
            }

            // children (recursivo)
            if (isset($item['children'])) {

                $children = $this->buildItems($user, $item['children']);

                if (!empty($children)) {
                    $result[] = [
                        'label' => $item['label'],
                        'children' => $children,
                    ];
                }

                continue;
            }

            // permission
            if (
                isset($item['permission']) &&
                !$user->can($item['permission'])
            ) {
                continue;
            }

            // route simple
            if (isset($item['route'])) {
                $result[] = [
                    'label' => $item['label'],
                    'route' => route($item['route']),
                ];
            }
        }

        return $result;
    }

    private function hasAnyPermission($user, array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($user->can($permission)) {
                return true;
            }
        }
        return false;
    }
}
