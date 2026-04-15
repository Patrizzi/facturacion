<?php

return [

    // INICIO
    'inicio' => [
        'icon' => 'fa fa-home',
        'label' => 'Inicio',
        'route' => 'inicio',
        'permission' => 'inicio',

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
        'icon' => 'fa fa-tags',
        'label' => 'Ventas',
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
];
