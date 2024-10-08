<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Carbon;
use App\EventosUsers;
use App\Kardex_entrada;
use App\Builders\MenuItemBuilder;

class SideMenu extends Component {
    public array $menuItems;

    private function menu() {
        return new MenuItemBuilder();
    }

    public function __construct() {
        $inventarioInicial = Kardex_entrada::first();
        $inventarioText = "Inventario";
        $inventarioRoute = [];
        $inventarioSubmenus = [];
        $inventarioKardexSubmenus = [
            $this->menu()->text('Entrada Producto')->route('kardex-entrada.index')
                ->permissions('inventario-productos_kardex-entrada_producto.index')
                ->build(),
            $this->menu()->text('Distribución Producto')->route('kardex-entrada-Distribucion.index')
                ->build(),
            $this->menu()->text('Traslado de Almacén')->route('kardex-entrada-Traslado-almacen.index')
                ->build(),
            $this->menu()->text('Salida Producto')->route('kardex-salida.index')
                ->permissions('inventario-productos_kardex-entrada_producto.index')
                ->build(),
        ];
        $inventarioComercilizacionSubmenus = [
            $this->menu()->text('Cotizaciones')->route('cotizacion.index')->build(),
            $this->menu()->text('Cotizaciones M.')->route('cotizacion_manual.index')->build(),
            $this->menu()->text('Facturación')->route('facturacion.index')->build(),
            $this->menu()->text('Facturación M.')->route('facturacion_manual.index')->build(),
            $this->menu()->text('Boleta')->route('boleta.index')->build(),
            $this->menu()->text('Boleta M.')->route('boleta_manual.index')->build(),
            $this->menu()->text('Nota Venta')->route('nota_venta.index')->build(),
            $this->menu()->text('Nota Crédito')->route('nota-credito.index')->build(),
        ];

        if (!empty($inventarioInicial) && $inventarioInicial->estado == 1) {
            $inventarioRoute = ['kardex-entrada.show', $inventarioInicial->id];
        } else {
            $inventarioText .= ' Inicial';
            $inventarioRoute = ['kardex-entrada.create'];

            $inventarioComercilizacionSubmenus = array_merge($inventarioComercilizacionSubmenus, [
                $this->menu()->text('Guía Remisión')->route('guia_remision.index')->build(),
                $this->menu()->text('Guía Remisión M.')->route('guia_remision_manual.index')->build(),
                $this->menu()->text('Nota Débito')->route('nota-debito.index')->build(),
            ]);

            $inventarioSubmenus = [
                $this->menu()->text('Kardex-Producto')->permissions('inventario-productos_kardex')
                    ->submenus($inventarioKardexSubmenus)
                    ->build(),
                $this->menu()->text('Consultas de inventario')->route('periodo-consulta.index')
                    ->permissions('inventario-toma_de_inventario.index')
                    ->build(),
                $this->menu()->text('Cierre Periodo')->route('cierre-periodo.index')
                    ->build(),
                $this->menu()->text('Movimiento Consulta')->route('movimiento-consulta.index')
                    ->build(),
            ];
        }

        $this->menuItems = [
            $this->menu()
                ->text('Inicio')
                ->route('inicio')
                ->permissions('inicio')
                ->icon('/archivos/imagenes/layout/inicio.svg')
                ->build(),
            $this->menu()
                ->text('Comercialización')
                ->permissions('transacciones')
                ->icon('/archivos/imagenes/layout/comercializacion.svg')
                ->submenus($inventarioComercilizacionSubmenus)
                ->build(),
            $this->menu()
                ->text('Servicio Técnico')
                ->icon('/archivos/imagenes/layout/servicio_tecnico.png')
                ->permissions('transacciones')
                ->submenus([
                    $this->menu()->text('Guía Ingreso')->route('garantia_guia_ingreso.index')->permissions('transacciones-garantias-guias_ingreso.index')->build(),
                    $this->menu()->text('Guía Egreso')->route('garantia_guia_egreso.index')->permissions('transacciones-garantias-guias_egreso.index')->build(),
                    $this->menu()->text('Informe Técnico')->route('garantia_informe_tecnico.index')->permissions('transacciones-garantias-informe_tecnico.index')->build(),
                ])
                ->build(),
            $this->menu()
                ->text($inventarioText)
                ->route(...$inventarioRoute)
                ->icon('/archivos/imagenes/layout/inventario.svg')
                ->permissions(['transacciones', 'inventario'])
                ->submenus($inventarioSubmenus)
                ->build(),
            $this->menu()
                ->text('Créditos')
                ->icon('/archivos/imagenes/layout/payment.png')
                ->submenus([
                    $this->menu()->text('Facturas')->route('pagos.view_facturas')->build(),
                    $this->menu()->text('Facturas M.')->route('pagos.view_facturas_m')->build(),
                    $this->menu()->text('Boletas')->route('pagos.view_boletas')->build(),
                    $this->menu()->text('Boletas M.')->route('pagos.view_boletas_m')->build(),
                    $this->menu()->text('Nota de Venta')->route('pagos.view_nota_venta')->build(),
                ])
                ->build(),
            $this->menu()
                ->text('Planilla')
                ->icon('/archivos/imagenes/layout/planilla.svg')
                ->permissions('planilla')
                ->submenus([
                    $this->menu()->text('Personal')->route('personal.index')->permissions('planilla-datos_generales.index')->build(),
                    $this->menu()->text('Vendedores')->route('vendedores.index')->permissions('planilla-vendedores.index')->build(),
                    $this->menu()->text('Vehículos')->route('vehiculo.index')->build(),
                ])
                ->build(),
            $this->menu()
                ->text('Consultas')
                ->icon('/archivos/imagenes/layout/consultas.svg')
                ->permissions('consultas')
                ->submenus([
                    $this->menu()->text('Garantias')->permissions('consultas-garantias')->submenus([
                        $this->menu()->text('Guia Ingreso')->route('consultas.garantias.guias_ingreso')->permissions('consultas-garantias-guia_ingreso.index')->build(),
                        $this->menu()->text('Guia Egreso')->route('consultas.garantias.guias_egreso')->permissions('consultas-garantias-guia_egreso.index')->build(),
                        $this->menu()->text('Informe Técnico')->route('consultas.garantias.informe_tecnico')->permissions('consultas-garantias-informe_tecnico.index')->build(),
                    ])->build(),
                    $this->menu()->text('Productos')->route('cantidad_precio.index')->build(),
                    $this->menu()->text('Servicios')->route('cantidad_precio.index_servicio')->build(),
                ])
                ->build(),
            $this->menu()
                ->text('Registros Sunat')
                ->icon('/archivos/imagenes/layout/logo_sunat.png')
                ->submenus([
                    $this->menu()->text('Facturas')->route('facturacion_electronica.index')->build(),
                    $this->menu()->text('Boletas')->route('facturacion_electronica.index_boleta')->build(),
                    $this->menu()->text('Guía Remisión')->route('facturacion_electronica.index_guia_remision')->build(),
                    $this->menu()->text('Nota de créditos')->route('facturacion_electronica.index_nota_credito')->build(),
                    $this->menu()->text('Nota de débitos')->route('facturacion_electronica.index_nota_debito')->build(),
                ])
                ->build(),
            $this->menu()
                ->text('Correo')
                ->icon('/archivos/imagenes/layout/correo.svg')
                ->submenus([
                    $this->menu()->text('Bandeja de Entrada')->route('email.index')->build(),
                    $this->menu()->text('Configuración')->route('configuracion_email.index')->build(),
                    $this->menu()->text('Papelera')->route('email.trash')->build()
                ])
                ->build(),
            $this->menu()
                ->text('Calendario')
                ->route('eventos.user_indes')
                ->icon('/archivos/imagenes/layout/calendario.png')
                ->count(EventosUsers::whereDate('start', Carbon::parse()->now())->where('user_id', auth()->user()->id)->count())
                ->build(),
            $this->menu()
                ->text('Auxiliares')
                ->icon('/archivos/imagenes/layout/auxiliar.svg')
                ->permissions('auxiliares')
                ->submenus([
                    $this->menu()->text('Clientes')->route('cliente.index')->permissions('auxiliares-clientes.index')->build(),
                    $this->menu()->text('Proveedores')->route('provedor.index')->permissions('auxiliares-provedores.index')->build(),
                ])
                ->build(),
            $this->menu()
                ->text('Productos y Servicios')
                ->icon('/archivos/imagenes/layout/productos.svg')
                ->permissions('maestro')
                ->submenus([
                    $this->menu()->text('Productos')->route('productos.index')->build(),
                    $this->menu()->text('Servicios')->route('servicios.index')->build(),
                ])
                ->build(),
            $this->menu()
                ->text('Configuración')
                ->icon('/archivos/imagenes/layout/configuracion.svg')
                ->permissions('maestro')
                ->submenus([
                    $this->menu()->text('Configuración del Sistema')->route('Configuracion')->permissions('maestro-catalogo-clasificacion')->build(),
                    $this->menu()->text('Mi Empresa')->route('empresa.index')->permissions('maestro-configuracion_general.mi_empresa.index')->build(),
                ])
                ->build(),
            $this->menu()
                ->text('Gestion de Proyectos')
                ->route('project_managers.index')
                ->icon('/archivos/imagenes/project_manager/icon/pm-icon.png')
                ->submenus([
                    $this->menu()->text('Lista de proyectos')->route('project_managers.index')->build(),
                    $this->menu()->text('Tabla Gantt')->route('project_managers.gantt.index')->build(),
                ])
                ->build(),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        return view('components.side-menu');
    }
}
