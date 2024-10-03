<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Data\Menu\MenuItemData;

class SideMenu extends Component
{
    public array $menuItems;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->menuItems = [
            new MenuItemData(
                'inicio',
                route('inicio'),
                asset('/archivos/imagenes/layout/inicio.svg'),
                []
            ),
            new MenuItemData(
                'Comercialización',
                '#',
                asset('/archivos/imagenes/layout/comercializacion.svg'),
                [
                    new MenuItemData('Cotizaciones',route('cotizacion.index')),
                    new MenuItemData('Cotizaciones M.', route('cotizacion_manual.index')),
                    new MenuItemData('Facturación', route('facturacion.index')),
                    new MenuItemData('Facturación M.', route('facturacion_manual.index')),
                    new MenuItemData('Boleta', route('boleta.index')),
                    new MenuItemData('Boleta M.', route('boleta_manual.index')),
                    new MenuItemData('Nota Venta', route('boleta_manual.index')),
                    new MenuItemData('Nota Crédito', route('nota-credito.index')),
                ]
            ),
        ];;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.side-menu');
    }
}
