<?php

return [

    // INICIO
    'inicio' => [
        'icon' => 'fa fa-home',
        'label' => 'Inicio',
        'route' => 'inicio',
        'permission' => 'inicio.inicio',

    ],
    'ventas' => [
        'icon' => 'fa fa-tags',
        'label' => 'Ventas',

        'routes' => [
            'cotizacion.listar'     => 'ventas.cotizacion',
            'cotizacion_m.listar'   => 'ventas.cotizacion_manual',
            'nota_venta.listar'     => 'ventas.nota_venta',
            'clientes.listar'       => 'clientes.index',
            'coti_renovacion.listar' => 'ventas.renovacion.index',
        ],
    ],
    'tesoreria' => [
        'icon' => 'fa fa-money',
        'label' => 'Tesorería',
        'route' => 'caja_chica.index',
        'permission_any' => [
            'caja-chica.listar_detalle',
            'caja-chica.abrir_caja',
            'caja-chica.cerrar_caja',
            'caja-chica.depositar',
            'caja-chica.pagar',
        ],
    ],
    'comprobantes' => [
        'icon' => 'fa fa-file',
        'label' => 'Comprobantes',
        'routes' => [
            'factura.listar' => 'comprobantes.index_factura',
            'factura_m.listar' => 'comprobantes.index_factura_manual',
            'boleta.listar' => 'comprobantes.index_boleta',
            'boleta_m.listar' => 'comprobantes.index_boleta_manual',
            'nota_credito.listar' => 'comprobantes.index_nota_credito',
            'nota_debito.listar' => 'comprobantes.index_nota_debito',
            'guia_remision.listar' => 'comprobantes.index_guia_remision',
            'guia_remision_m.listar' => 'comprobantes.index_guia_remision_manual',
        ],
    ],

    'garantias' => [
        'icon' => 'fa fa-check fa-lg',
        'label' => 'Garantias',
        'routes' => [
            'guia_ingreso.listar' => 'garantia_guia_ingreso.index',
            'guia_egreso.listar' => 'garantia_guia_egreso.index',
            'informe_tecnico.listar' => 'garantia_informe_tecnico.index',
        ]
    ],

    'inventario' => [
        'icon' => 'fa fa-archive',
        'label' => 'Inventario ',
        'initial' => [
            'permission'   => 'kardex_entrada.inicial',
            'route_create' => 'kardex-entrada.create',
            'route_show'   => 'kardex-entrada.show',
        ],
        'items' => [
            [
                'label' => 'Kardex-Producto',

                'permission_any' => [
                    'kardex_entrada.listar',
                    'kardex_distribución.listar',
                    'kardex_traslado.listar',
                    'kardex_salida.listar',
                ],

                'children' => [

                    [
                        'permission' => 'kardex_entrada.listar',
                        'label' => 'Entrada Producto',
                        'route' => 'kardex-entrada.index',
                    ],

                    [
                        'permission' => 'kardex_distribución.listar',
                        'label' => 'Distribución Producto',
                        'route' => 'kardex-entrada-Distribucion.index',
                    ],

                    [
                        'permission' => 'kardex_traslado.listar',
                        'label' => 'Traslado de Almacén',
                        'route' => 'kardex-entrada-Traslado-almacen.index',
                    ],

                    [
                        'permission' => 'kardex_salida.listar',
                        'label' => 'Salida Producto',
                        'route' => 'kardex-salida.index',
                    ],

                ],
            ],
            [
                'permission' => 'inventario.consulta',
                'label' => 'Consultas de inventario',
                'route' => 'periodo-consulta.index',
            ],
            [
                'permission' => 'cierre_periodo.listar',
                'label' => 'Cierre Periodo',
                'route' => 'cierre-periodo.index',
            ],
            [
                'permission' => 'inventario.movimiento',
                'label' => 'Movimiento Consulta',
                'route' => 'movimiento-consulta.index',
            ],

        ],
    ],

    'cobranzas' => [
        'icon' => 'fa fa-credit-card',
        'label' => 'Créditos y Cobranzas',

        'items' => [
            [
                'label' => 'Facturas',
                'route' => 'cobranzas.index_factura',
                'permission_any' => [
                    'factura.listar_por_pagar',
                    'factura.listar_pagadas',
                ],
            ],
            [
                'label' => 'Facturas M.',
                'route' => 'cobranzas.index_facturas_m',
                'permission_any' => [
                    'factura_m.listar_por_pagar',
                    'factura_m.listar_pagadas',
                ],
            ],
            [
                'label' => 'Boletas',
                'route' => 'cobranzas.index_boletas',
                'permission_any' => [
                    'boleta.listar_por_pagar',
                    'boleta.listar_pagadas',
                ],
            ],
            [
                'label' => 'Boletas M.',
                'route' => 'cobranzas.index_boletas_manual',
                'permission_any' => [
                    'boleta_m.listar_por_pagar',
                    'boleta_m.listar_pagadas',
                ],
            ],
            [
                'label' => 'Nota de Venta',
                'route' => 'cobranzas.index_nota_venta',
                'permission_any' => [
                    'nota_venta.listar_por_pagar',
                    'nota_venta.listar_pagadas',
                ],
            ],

        ],
    ],

    'servicio_tecnico' => [
        'icon' => 'fa fa-wrench',
        'label' => 'Servicio Técnico',
        'route' => 'servicio-guias.index',
        'permission_any' => [
            'servicio_tecnico.servicios_listar',
            'servicio_tecnico.cotizacion_listar',
            'servicio_tecnico.o_servicio_listar',
            'servicio_tecnico.o_servicio_entregados_listar',
        ],
    ],

    'planilla' => [
        'icon' => 'fa fa-table',
        'label' => 'Planilla',
        'items' => [
            [
                'label' => 'Personal',
                'route' => 'personal.index',
                'permission_any' => [
                    'personal.listar'
                ],
            ],
            [
                'label' => 'Vendedores',
                'route' => 'vendedores.index',
                'permission_any' => [
                    'vendedores.listar'
                ],
            ],
            [
                'label' => 'Vehiculos',
                'route' => 'vehiculo.index',
                'permission_any' => [
                    'transporte_publico.listar',
                    'transporte_privado.listar'
                ],
            ],
        ]
    ],

    'consultas' => [
        'icon' => 'fa fa-comments-o',
        'label' => 'Consultas',
        'items' => [
            [
                'label' => 'Garantías',
                'permission_any' => [
                    'consultas.guia_ingreso',
                    'consultas.guia_egreso',
                    'consultas.informe_tecnico',
                    'consultas.productos',
                    'consultas.servicios',
                    'consultas.reporte_comprobantes'
                ],
                'children' => [

                    [
                        'permission' => 'consultas.guia_ingreso',
                        'label' => 'Guía Ingreso',
                        'route' => 'consultas.garantias.guias_ingreso',
                    ],

                    [
                        'permission' => 'consultas.guia_egreso',
                        'label' => 'Guía Egreso',
                        'route' => 'consultas.garantias.guias_egreso',
                    ],

                    [
                        'permission' => 'consultas.informe_tecnico',
                        'label' => 'Informe Técnica',
                        'route' => 'consultas.garantias.informe_tecnico',
                    ],

                ],
            ],
            [
                'label' => 'Productos',
                'route' => 'cantidad_precio.index',
                'permission_any' => [
                    'consultas.productos'
                ],
            ],
            [
                'label' => 'Servicios',
                'route' => 'cantidad_precio.index_servicio',
                'permission_any' => [
                    'consultas.servicios',
                ],
            ],
            [
                'label' => 'Reporte Comp',
                'route' => 'consultas.servicios',
                'permission_any' => [
                    'reportes.index'
                ],
            ],
        ]
    ],

    'registro_sunat' => [
        'icon' => 'fa fa-registered',
        'label' => 'R. Sunat',
        'items' => [
            [
                'label' => 'Facturas',
                'routes' => [
                    'factura.listar_por_emitir' => 'facturacion_electronica.index',
                    'factura.listar_emitidas' => 'facturacion_electronica.facturas_enviadas_list',
                    'factura_m.listar_por_emitir' => 'facturacion_electronica.index_facturas_manual',
                    'factura_m.listar_emitidas' => 'facturacion_electronica.facturas_manual_enviadas',
                    'detraccion_factura.listar' => 'facturacion_electronica.facturas_detracciones'
                ],
            ],
            [
                'label' => 'Boletas',
                'routes' => [
                    'boleta.listar_por_emitir' => 'boletas_electronicas.index_boleta',
                    'boleta.listar_emitidas' => 'boletas_electronicas.boletas_enviadas_list',
                    'boleta_m.listar_por_emitir' => 'boletas_electronicas.index_boleta_manual',
                    'boleta_m.listar_emitidas' => 'boletas_electronicas.boletas_enviadas_m'
                ],
            ],
            [
                'label' => 'Guias Remision',
                'routes' => [
                    'guia_remision.listar_por_emitir' => 'guias_electronicas.index_guia_remision',
                    'guia_remision.lista_emitidas' => 'guias_electronicas.remision_enviadas',
                    'guia_remision_m.listar_por_emitir' => 'guias_electronicas.index_guia_remision_manual',
                    'guia_remision_m.listar_emitidas' => 'guias_electronicas.remision_m_envidas'
                ],
            ],
            [
                'label' => 'Notas Electrónicas',
                'routes' => [
                    'nota_credito.listar_por_emitir' => 'facturacion_electronica.index_nota_credito',
                    'nota_credito.lista_emitidas' => 'facturacion_electronica.nota_credito_env',
                    'nota_debito.listar_por_emitir' => 'facturacion_electronica.index_nota_debito',
                    'nota_debito.lista_emitidas' => 'facturacion_electronica.nota_debito_env'
                ],
            ],

        ]
    ],
    'productos_servicios' => [
        'icon' => 'fa fa-shopping-bag',
        'label' => 'Productos Y Servicios',
        'items' => [
            'label' => 'Productos',
            'route' => 'productos.index',
            'permission_any' => [
                'productos.listar'
            ],
        ],
        [
            'label' => 'Servicios',
            'route' => 'cantidad_precio.index',
            'permission_any' => [
                'servicios.index'
            ],
        ]
    ],
    'proyectos_pmb' => [
        'icon' => 'fa fa-th-large',
        'label' => 'Proyectos PMB',
        'route' => 'project_managers.index',
        'permission_any' => [
            'proyectos_pmb.listar',
            'proyectos_pmb.gantt',
            'proyectos_pmb.listar_act',
            'proyectos_pmb.listar_tareas',
            'proyectos_pmb.gantt'
        ]
    ],
    'correo' => [
        'icon' => 'fa fa-envelope',
        'label' => 'Correo',
        'items' => [
            [
                'label' => 'Bandeja',
                'route' => 'email.index',
                'permission_any' => [
                    'correo.listar_enviados'
                ],
            ],
            [
                'label' => 'Borradores',
                'route' => 'configuracion_email.index',
                'permission_any' => [
                    'correo.configuracion'
                ],
            ],
            [
                'label' => 'Papelera',
                'route' => 'email.trash',
                'permission_any' => [
                    'correo.papelera'
                ],
            ]
        ],

    ],
    'auxiliar' => [
        'icon' => 'fa fa-group',
        'label' => 'Auxiliar',
        'items' => [
            [
                'label' => 'Clientes',
                'route' => 'ventas.clientes',
                'permission_any' => [
                    'clientes.listar'
                ]
            ],
            [
                'label' => 'Proveedores',
                'route' => 'provedor.index',
                'permission_any' => [
                    'proveedor.listar'
                ]
            ]
        ]
    ],


];
