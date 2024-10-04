<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Carbon;
use \Illuminate\Support\Facades\Gate;
use App\Data\Menu\MenuItemData;
use App\EventosUsers;
use App\Kardex_entrada;
use App\Almacen;

class SideMenu extends Component
{
    public array $menuItems;

    public function __construct()
    {
        $inventario_inicial = Kardex_entrada::first();
        $conteo_almacen = Almacen::count();

        $this->menuItems = [
            new MenuItemData(
                'inicio',
                route('inicio'),
                asset('/archivos/imagenes/layout/inicio.svg'),
                [],
                ['inicio']
            ),
            new MenuItemData(
                'Comercialización',
                '#',
                asset('/archivos/imagenes/layout/comercializacion.svg'),
                array_merge(
                    [
                        new MenuItemData('Cotizaciones', route('cotizacion.index')),
                        new MenuItemData('Cotizaciones M.', route('cotizacion_manual.index')),
                        new MenuItemData('Facturación', route('facturacion.index')),
                        new MenuItemData('Facturación M.', route('facturacion_manual.index')),
                        new MenuItemData('Boleta', route('boleta.index')),
                        new MenuItemData('Boleta M.', route('boleta_manual.index')),
                        new MenuItemData('Nota Venta', route('nota_venta.index')),
                        new MenuItemData('Nota Crédito', route('nota-credito.index')),
                    ],
                    !empty($inventario_inicial) ? [
                        new MenuItemData('Guía Remisión', route('guia_remision.index')),
                        new MenuItemData('Guía Remisión M.', route('guia_remision_manual.index')),
                        new MenuItemData('Nota Débito', route('nota-debito.index')),
                    ] : []
                ),
                ['transacciones']
            ),
            
            new MenuItemData(
                'Servicio Técnico',
                '#',
                asset('/archivos/imagenes/layout/servicio_tecnico.png'),
                [
                    new MenuItemData('Guía Ingreso', route('garantia_guia_ingreso.index'), null, [], ['transacciones-garantias-guias_ingreso.index']),
                    new MenuItemData('Guía Egreso', route('garantia_guia_egreso.index'), null, [], ['transacciones-garantias-guias_egreso.index']),
                    new MenuItemData('Informe Técnico', route('garantia_informe_tecnico.index'), null, [], ['transacciones-garantias-informe_tecnico.index']),
                ],
                ['transacciones']
            ),

            new MenuItemData(
                'Inventario'.(empty($inventario_inicial) || $inventario_inicial->estado == 1 ? ' Inicial' : ''),
                !empty($inventario_inicial) ? (
                    $inventario_inicial->estado == 1 
                    ? route('kardex-entrada.show', $inventario_inicial->id) 
                    : route('kardex-entrada.create')
                ) : route('kardex-entrada.create'),
                asset('/archivos/imagenes/layout/inventario.svg'),
                !empty($inventario_inicial) && $inventario_inicial->estado != 1 ? [
                    new MenuItemData(
                        'Kardex-Producto',
                        '#',
                        null,
                        [
                            new MenuItemData(
                                'Entrada Producto',
                                route('kardex-entrada.index'),
                                null,
                                [],
                                ['inventario-productos_kardex-entrada_producto.index']
                            ),
                            new MenuItemData(
                                'Distribución Producto',
                                route('kardex-entrada-Distribucion.index'),
                                null
                            ),
                            new MenuItemData(
                                'Traslado de Almacén',
                                route('kardex-entrada-Traslado-almacen.index'),
                                null
                            ),
                            new MenuItemData(
                                'Salida Producto',
                                route('kardex-salida.index'),
                                null,
                                [],
                                ['inventario-productos_kardex-salida_producto.index']
                            ),
                        ],
                        ['inventario-productos_kardex']
                    ),
                    new MenuItemData(
                        'Consultas de inventario',
                        route('periodo-consulta.index'),
                        null,
                        [],
                        ['inventario-toma_de_inventario.index']
                    ),
                    new MenuItemData('Cierre Periodo', route('cierre-periodo.index')),
                    new MenuItemData('Movimiento Consulta', route('movimiento-consulta.index')),
                ] : [],
                ['transacciones', 'inventario']
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
                    new MenuItemData('Personal', route('personal.index'), null, [], ['planilla-datos_generales.index']),
                    new MenuItemData('Vendedores', route('vendedores.index'), null, [], ['planilla-vendedores.index']),
                    new MenuItemData('Vehículos', route('vehiculo.index')),
                ],
                ['planilla']
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
                            new MenuItemData('Guia Ingreso', route('consultas.garantias.guias_ingreso'), null, [], ['consultas-garantias-guia_ingreso.index']),
                            new MenuItemData('Guia Egreso', route('consultas.garantias.guias_egreso'), null, [], ['consultas-garantias-guia_egreso.index']),
                            new MenuItemData('Informe Técnico', route('consultas.garantias.informe_tecnico'), null, [], ['consultas-garantias-informe_tecnico.index']),
                        ],
                        ['consultas-garantias']
                    ),
                    new MenuItemData('Productos', route('cantidad_precio.index')),
                    new MenuItemData('Servicios', route('cantidad_precio.index_servicio')),
                ],
                ['consultas']
            ),

            new MenuItemData(
                'Registros Sunat',
                '#',
                asset('/archivos/imagenes/layout/logo_sunat.png'),
                [
                    new MenuItemData('Facturas', route('facturacion_electronica.index')),
                    new MenuItemData('Boletas', route('facturacion_electronica.index_boleta')),
                    new MenuItemData('Guía Remisión', route('facturacion_electronica.index_guia_remision')),
                    new MenuItemData('Nota de créditos', route('facturacion_electronica.index_nota_credito')),
                    new MenuItemData('Nota de débitos', route('facturacion_electronica.index_nota_debito')),
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
                route('eventos.user_indes'),
                asset('/archivos/imagenes/layout/calendario.png'),
                [],
                [],
                EventosUsers::whereDate('start',Carbon::parse()->now())->where('user_id',auth()->user()->id)->count()
            ),

            new MenuItemData(
                'Auxiliares',
                '#',
                asset('/archivos/imagenes/layout/auxiliar.svg'),
                [
                    new MenuItemData('Clientes', route('cliente.index'), null, [], ['auxiliares-clientes.index']),
                    new MenuItemData('Proveedores', route('provedor.index'), null, [], ['auxiliares-provedores.index']),
                ],
                ['auxiliares']
            ),

            new MenuItemData(
                'Productos y Servicios',
                '#',
                asset('/archivos/imagenes/layout/productos.svg'),
                [
                    new MenuItemData('Productos', route('productos.index')),
                    new MenuItemData('Servicios', route('servicios.index')),
                ],
                ['maestro']
            ),

            new MenuItemData(
                'Configuración',
                '#',
                asset('/archivos/imagenes/layout/configuracion.svg'),
                [
                    new MenuItemData('Configuración del Sistema', route('Configuracion'), null, [], ['maestro-catalogo-clasificacion']),
                    new MenuItemData('Mi Empresa', route('empresa.index'), null, [], ['maestro-configuracion_general.mi_empresa.index']),
                ],
                ['maestro']
            ),

            new MenuItemData(
                'Gestion de Proyectos',
                route('project_managers.index'),
                asset('/archivos/imagenes/project_manager/icon/pm-icon.png'),
                [
                    new MenuItemData('Lista de proyectos', route('project_managers.index')),
                    new MenuItemData('Tabla Gantt', route('project_managers.gantt.index')),
                ]
            ),
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
