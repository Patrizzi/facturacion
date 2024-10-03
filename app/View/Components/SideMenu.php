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
                    new MenuItemData('Cotizaciones', route('cotizacion.index')),
                    new MenuItemData('Cotizaciones M.', route('cotizacion_manual.index')),
                    new MenuItemData('Facturación', route('facturacion.index')),
                    new MenuItemData('Facturación M.', route('facturacion_manual.index')),
                    new MenuItemData('Boleta', route('boleta.index')),
                    new MenuItemData('Boleta M.', route('boleta_manual.index')),
                    new MenuItemData('Nota Venta', route('nota_venta.index')),
                    new MenuItemData('Nota Crédito', route('nota-credito.index')),
                ]
            ),
            
            new MenuItemData(
                'Servicio Técnico',
                '#',
                asset('/archivos/imagenes/layout/servicio_tecnico.png'),
                [
                    new MenuItemData('Guía Ingreso', route('garantia_guia_ingreso.index')),
                    new MenuItemData('Guía Egreso', route('garantia_guia_egreso.index')),
                    new MenuItemData('Informe Técnico', route('garantia_informe_tecnico.index')),
                ]
            ),

            new MenuItemData(
                'Inventario Inicial',
                route('kardex-entrada.create'),
                asset('/archivos/imagenes/layout/inventario.svg'),
                []
            ),

            new MenuItemData(
                'Créditos',
                '#',
                asset('/archivos/imagenes/layout/payment.png'),
                [
                    new MenuItemData('Facturas', route('pagos.view_facturas')),
                    new MenuItemData('Facturas M.', route('pagos.view_boletas')),
                    new MenuItemData('Boletas', route('pagos.view_boletas')),
                    new MenuItemData('Boletas M.', route('pagos.view_boletas_m')),
                    new MenuItemData('Nota de Venta', route('pagos.view_nota_venta')),
                ]
            ),

            new MenuItemData(
                'Planilla',
                '#',
                asset('/archivos/imagenes/layout/planilla.svg'),
                [
                    new MenuItemData('Personal', route('personal.index')),
                    new MenuItemData('Vendedores', route('vendedores.index')),
                    new MenuItemData('Vehículos', route('vehiculo.index')),
                ]
            ),

            new MenuItemData(
                'Consultas',
                '#',
                asset('/archivos/imagenes/layout/consultas.svg'),
                [
                    new MenuItemData(
                        'Garantias',
                        '#',
                        '',
                        [
                            new MenuItemData('Guia Ingreso', route('consultas.garantias.guias_ingreso')),
                            new MenuItemData('Guia Egreso', route('consultas.garantias.guias_egreso')),
                            new MenuItemData('Informe Técnico', route('consultas.garantias.informe_tecnico')),
                        ]
                    ),
                    new MenuItemData('Productos', route('cantidad_precio.index')),
                    new MenuItemData('Servicios', route('cantidad_precio.index_servicio')),
                ]
            ),

            new MenuItemData(
                'Registros Sunat',
                '#',
                asset('/archivos/imagenes/layout/logo_sunat.png'),
                [
                    new MenuItemData('Facturas', route('facturacion_electronica.index')),
                    new MenuItemData('Boletas', route('facturacion_electronica.index_boleta')),
                    new MenuItemData('Guia Remision', route('facturacion_electronica.index_guia_remision')),
                    new MenuItemData('Nota Credito', route('facturacion_electronica.index_nota_credito')),
                    new MenuItemData('Nota Debito', route('facturacion_electronica.index_nota_debito')),
                ]
            ),

            new MenuItemData(
                'Correo',
                '#',
                asset('/archivos/imagenes/layout/correo.svg'),
                [
                    new MenuItemData('Bandeja de Entrada', route('email.index')),
                    new MenuItemData('Configuración', route('configuracion_email.index')),
                    new MenuItemData('Papelera', route('email.trash'))
                ]
            ),

            new MenuItemData(
                'Calendario',
                '#',
                asset('/archivos/imagenes/layout/calendario.png'),
                [],
            ),

            new MenuItemData(
                'Auxiliares',
                '#',
                asset('/archivos/imagenes/layout/auxiliar.svg'),
                [
                    new MenuItemData('Clientes', route('cliente.index')),
                    new MenuItemData('Proveedores', route('provedor.index')),
                ]
            ),

            new MenuItemData(
                'Productos y Servicios',
                '#',
                asset('/archivos/imagenes/layout/productos.svg'),
                [
                    new MenuItemData('Productos', route('productos.index')),
                    new MenuItemData('Servicios', route('servicios.index')),
                ]
            ),

            new MenuItemData(
                'Configuración',
                '#',
                asset('/archivos/imagenes/layout/configuracion.svg'),
                [
                    new MenuItemData('Configuración del Sistema', route('Configuracion')),
                    new MenuItemData('Mi Empresa', route('empresa.index')),
                ]
            ),

            new MenuItemData(
                'Cerrar Session',
                route('logout'),
                asset('/archivos/imagenes/layout/logout.png'),
                []
            )
        ];
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
