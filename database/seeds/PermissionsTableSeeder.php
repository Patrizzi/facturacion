<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();

        Role::truncate();
        Permission::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        // CREACION DE LAS NUEVOS PERMISOS
        Permission::create(['name' => 'inicio.inicio', 'module' => 'dashboard', 'description' => 'Dashboard Inicio']);
        //* VENTAS
        Permission::create(['name' => 'cotizacion.listar', 'module' => 'ventas', 'description' => 'Lista de Cotizaciones']);
        Permission::create(['name' => 'cotizacion.crear', 'module' => 'ventas', 'description' => 'Crear Cotizacion']);
        Permission::create(['name' => 'cotizacion.ver', 'module' => 'ventas', 'description' => 'Mostrar Cotizacion']);
        Permission::create(['name' => 'cotizacion.editar', 'module' => 'ventas', 'description' => 'Editar Cotizacion']);
        Permission::create(['name' => 'cotizacion.procesar', 'module' => 'ventas', 'description' => 'Procesar Cotizacion']);
        Permission::create(['name' => 'cotizacion.duplicar', 'module' => 'ventas', 'description' => 'Duplicar Cotizacion']);

        Permission::create(['name' => 'cotizacion_m.listar', 'module' => 'ventas', 'description' => 'Lista de Cotizaciones Manuales']);
        Permission::create(['name' => 'cotizacion_m.crear', 'module' => 'ventas', 'description' => 'Crear Cotizacion Manual']);
        Permission::create(['name' => 'cotizacion_m.ver', 'module' => 'ventas', 'description' => 'Mostrar Cotizacion Manual']);
        Permission::create(['name' => 'cotizacion_m.editar', 'module' => 'ventas', 'description' => 'Editar Cotizacion Manual']);
        Permission::create(['name' => 'cotizacion_m.procesar', 'module' => 'ventas', 'description' => 'Procesar Cotizacion Manual']);
        Permission::create(['name' => 'cotizacion_m.duplicar', 'module' => 'ventas', 'description' => 'Duplicar Cotizacion Manual']);

        Permission::create(['name' => 'nota_venta.listar', 'module' => 'ventas', 'description' => 'Lista de Nota de Ventas']);
        Permission::create(['name' => 'nota_venta.crear', 'module' => 'ventas', 'description' => 'Crear Nota de Venta']);
        Permission::create(['name' => 'nota_venta.ver', 'module' => 'ventas', 'description' => 'Mostrar Nota de Venta']);
        Permission::create(['name' => 'nota_venta.editar', 'module' => 'ventas', 'description' => 'Editar Nota de Venta']);

        Permission::create(['name' => 'clientes.listar', 'module' => 'ventas', 'description' => 'Lista de Clientes']);
        Permission::create(['name' => 'clientes.crear', 'module' => 'ventas', 'description' => 'Creacion de Cliente']);
        Permission::create(['name' => 'clientes.ver', 'module' => 'ventas', 'description' => 'Mostrar Cliente']);
        Permission::create(['name' => 'clientes.editar', 'module' => 'ventas', 'description' => 'Editar Cliente']);
        Permission::create(['name' => 'clientes.anular', 'module' => 'ventas', 'description' => 'Anular Cliente']);

        Permission::create(['name' => 'coti_renovacion.listar', 'module' => 'ventas', 'description' => 'Lista de Cotizaciones que se han renovado']); //?
        Permission::create(['name' => 'coti_renovacion.crear', 'module' => 'ventas', 'description' => 'Activar la Renovacion de Comprobantes']);


        //* Tesoreria

        Permission::create(['name' => 'caja-chica.listar_detalle', 'module' => 'tesoreria', 'description' => 'Listar detalle Caja de Tesorería']); //* Vista de lista
        Permission::create(['name' => 'caja-chica.abrir_caja', 'module' => 'tesoreria', 'description' => 'Abrir Caja de Tesorería']);
        Permission::create(['name' => 'caja-chica.cerrar_caja', 'module' => 'tesoreria', 'description' => 'Cerrar Caja de Tesorería']);
        Permission::create(['name' => 'caja-chica.depositar', 'module' => 'tesoreria', 'description' => 'Depositar en Caja de Tesorería']);
        Permission::create(['name' => 'caja-chica.pagar', 'module' => 'tesoreria', 'description' => 'Pagar en Caja de Tesorería']);

        //*Comprobantes
        Permission::create(['name' => 'factura.listar', 'module' => 'comprobantes', 'description' => 'Lista de Facturas']);
        Permission::create(['name' => 'factura.crear', 'module' => 'comprobantes', 'description' => 'Crear Factura']);
        Permission::create(['name' => 'factura.ver', 'module' => 'comprobantes', 'description' => 'Mostrar Factura']);
        Permission::create(['name' => 'factura.editar', 'module' => 'comprobantes', 'description' => 'Editar Factura']);
        Permission::create(['name' => 'factura.anular', 'module' => 'comprobantes', 'description' => 'Anular Factura en el Sistema']);
        Permission::create(['name' => 'factura.pagar_solo', 'module' => 'comprobantes', 'description' => 'Pagar Factura en Comprobantes']);

        Permission::create(['name' => 'factura_m.listar', 'module' => 'comprobantes', 'description' => 'Lista de Facturas Manuales']);
        Permission::create(['name' => 'factura_m.crear', 'module' => 'comprobantes', 'description' => 'Crear Factura Manual']);
        Permission::create(['name' => 'factura_m.ver', 'module' => 'comprobantes', 'description' => 'Mostrar Factura Manual']);
        Permission::create(['name' => 'factura_m.editar', 'module' => 'comprobantes', 'description' => 'Editar Factura Manual']);
        Permission::create(['name' => 'factura_m.anular', 'module' => 'comprobantes', 'description' => 'Anular Factura Manual en el Sistema']);
        Permission::create(['name' => 'factura_m.pagar_solo', 'module' => 'comprobantes', 'description' => 'Pagar Factura Manual en Comprobantes']);

        Permission::create(['name' => 'boleta.listar', 'module' => 'comprobantes', 'description' => 'Lista de Boletas']);
        Permission::create(['name' => 'boleta.crear', 'module' => 'comprobantes', 'description' => 'Crear Boleta']);
        Permission::create(['name' => 'boleta.ver', 'module' => 'comprobantes', 'description' => 'Mostrar Boleta']);
        Permission::create(['name' => 'boleta.editar', 'module' => 'comprobantes', 'description' => 'Editar Boleta']);
        Permission::create(['name' => 'boleta.anular', 'module' => 'comprobantes', 'description' => 'Anular Boleta en el Sistema']);
        Permission::create(['name' => 'boleta.pagar_solo', 'module' => 'comprobantes', 'description' => 'Pagar Boleta en Comprobantes']);

        Permission::create(['name' => 'boleta_m.listar', 'module' => 'comprobantes', 'description' => 'Lista de Boletas Manuales']);
        Permission::create(['name' => 'boleta_m.crear', 'module' => 'comprobantes', 'description' => 'Crear Boleta Manual']);
        Permission::create(['name' => 'boleta_m.ver', 'module' => 'comprobantes', 'description' => 'Mostrar Boleta Manual']);
        Permission::create(['name' => 'boleta_m.editar', 'module' => 'comprobantes', 'description' => 'Editar Boleta Manual']);
        Permission::create(['name' => 'boleta_m.anular', 'module' => 'comprobantes', 'description' => 'Anular Boleta Manual en el Sistema']);
        Permission::create(['name' => 'boleta_m.pagar_solo', 'module' => 'comprobantes', 'description' => 'Pagar Boleta en Comprobantes']);


        Permission::create(['name' => 'nota_credito.listar', 'module' => 'comprobantes', 'description' => 'Lista de Notas de Crédito']);
        Permission::create(['name' => 'nota_credito.crear_factura', 'module' => 'comprobantes', 'description' => 'Crear Nota de Crédito para Factura']);
        Permission::create(['name' => 'nota_credito.crear_factura_m', 'module' => 'comprobantes', 'description' => 'Crear Nota de Crédito para Factura MN']);
        Permission::create(['name' => 'nota_credito.crear_boleta', 'module' => 'comprobantes', 'description' => 'Crear Nota de Crédito']);
        Permission::create(['name' => 'nota_credito.crear_boleta_m', 'module' => 'comprobantes', 'description' => 'Crear Nota de Crédito']);
        Permission::create(['name' => 'nota_credito.ver', 'module' => 'comprobantes', 'description' => 'Mostrar Nota de Crédito']);
        Permission::create(['name' => 'nota_credito.editar', 'module' => 'comprobantes', 'description' => 'Editar Nota de Crédito']);
        Permission::create(['name' => 'nota_credito.anular', 'module' => 'comprobantes', 'description' => 'Anular Nota de Crédito en el Sistema']);

        Permission::create(['name' => 'nota_debito.listar', 'module' => 'comprobantes', 'description' => 'Lista de Notas de Débito']);
        Permission::create(['name' => 'nota_debito.crear_factura', 'module' => 'comprobantes', 'description' => 'Crear Nota de Débito']);
        Permission::create(['name' => 'nota_debito.crear_factura_m', 'module' => 'comprobantes', 'description' => 'Crear Nota de Débito']);
        Permission::create(['name' => 'nota_debito.crear_boleta', 'module' => 'comprobantes', 'description' => 'Crear Nota de Débito']);
        Permission::create(['name' => 'nota_debito.crear_boleta_m', 'module' => 'comprobantes', 'description' => 'Crear Nota de Débito']);
        Permission::create(['name' => 'nota_debito.ver', 'module' => 'comprobantes', 'description' => 'Mostrar Nota de Débito']);
        Permission::create(['name' => 'nota_debito.editar', 'module' => 'comprobantes', 'description' => 'Editar Nota de Débito']);
        Permission::create(['name' => 'nota_debito.anular', 'module' => 'comprobantes', 'description' => 'Anular Nota de Débito en el Sistema']);

        Permission::create(['name' => 'guia_remision.listar', 'module' => 'comprobantes', 'description' => 'Lista de Guías de Remisión']);
        Permission::create(['name' => 'guia_remision.crear', 'module' => 'comprobantes', 'description' => 'Crear Guia de Remisión']);
        Permission::create(['name' => 'guia_remision.ver', 'module' => 'comprobantes', 'description' => 'Mostrar Guia de Remisión']);
        Permission::create(['name' => 'guia_remision.editar', 'module' => 'comprobantes', 'description' => 'Editar Guia de Remisión']);

        Permission::create(['name' => 'guia_remision_m.listar', 'module' => 'comprobantes', 'description' => 'Lista de Guías de Remisión Manuales']);
        Permission::create(['name' => 'guia_remision_m.crear', 'module' => 'comprobantes', 'description' => 'Crear Guia de Remisión Manual']);
        Permission::create(['name' => 'guia_remision_m.ver', 'module' => 'comprobantes', 'description' => 'Mostrar Guia de Remisión Manual']);
        Permission::create(['name' => 'guia_remision_m.editar', 'module' => 'comprobantes', 'description' => 'Editar Guia de Remisión Manual']);
        Permission::create(['name' => 'guia_remision_m.anular', 'module' => 'comprobantes', 'description' => 'Anular Guia de Remisión Manual en el Sistema']);

        //*GARANTIAS    

        Permission::create(['name' => 'guia_ingreso.listar', 'module' => 'garantias', 'description' => 'Lista de Guias de Ingreso de Garantias']);
        Permission::create(['name' => 'guia_ingreso.crear', 'module' => 'garantias', 'description' => 'Crear Guia de Ingreso de Garantia']);
        Permission::create(['name' => 'guia_ingreso.ver', 'module' => 'garantias', 'description' => 'Mostrar Guia de Ingreso de Garantias']);
        Permission::create(['name' => 'guia_ingreso.editar', 'module' => 'garantias', 'description' => 'Editar Guia de Ingreso de Garantias']);
        Permission::create(['name' => 'guia_ingreso.procesar', 'module' => 'garantias', 'description' => 'Procesar Guia de Ingreso a Egreso de Garantias']);
        Permission::create(['name' => 'guia_ingreso.anular', 'module' => 'garantias', 'description' => 'Anular Guia de Ingreso de Garantias en el Sistema']);

        Permission::create(['name' => 'guia_egreso.listar', 'module' => 'garantias', 'description' => 'Lista de Guias de Egreso de Garantias']);
        Permission::create(['name' => 'guia_egreso.ver', 'module' => 'garantias', 'description' => 'Mostrar Guia de Egreso de Garantias']);
        Permission::create(['name' => 'guia_egreso.editar', 'module' => 'garantias', 'description' => 'Editar Guia de Egreso de Garantias']);
        Permission::create(['name' => 'guia_egreso.procesar', 'module' => 'garantias', 'description' => 'Procesar Guia de Egreso a Infome Técnico de Garantias']);
        Permission::create(['name' => 'guia_egreso.anular', 'module' => 'garantias', 'description' => 'Anular Guia de Egreso de Garantias en el Sistema']);

        Permission::create(['name' => 'informe_tecnico.listar', 'module' => 'garantias', 'description' => 'Lista de Informes Técnicos de Garantias']);
        Permission::create(['name' => 'informe_tecnico.ver', 'module' => 'garantias', 'description' => 'Mostrar Informe Técnico de Garantias']);
        Permission::create(['name' => 'informe_tecnico.editar', 'module' => 'garantias', 'description' => 'Editar Informe Técnico de Garantias']);
        Permission::create(['name' => 'informe_tecnico.anular', 'module' => 'garantias', 'description' => 'Anular Informe Técnico de Garantias']);

        //* Inventario
        
        Permission::create(['name' => 'kardex_entrada.inicial', 'module' => 'inventario', 'description' => 'Entrada del Inventario Inicial']);
        
        // ALMACEN 1
        Permission::create(['name' => 'kardex_entrada.listar', 'module' => 'inventario', 'description' => 'Lista de Guías de Entrada en Kardex']);
        Permission::create(['name' => 'kardex_entrada.crear', 'module' => 'inventario', 'description' => 'Crear Guía de Entrada en Kardex']);
        Permission::create(['name' => 'kardex_entrada.ver', 'module' => 'inventario', 'description' => 'Mostrar Guía de Entrada en Kardex']);
        Permission::create(['name' => 'kardex_entrada.anular', 'module' => 'inventario', 'description' => 'Anular Guía de Entrada en Kardex']);

        // ALMACEN 1 A X
        Permission::create(['name' => 'kardex_distribución.listar', 'module' => 'inventario', 'description' => 'Lista de Guías de Distribución en Kardex']);
        Permission::create(['name' => 'kardex_distribución.crear', 'module' => 'inventario', 'description' => 'Crear Guía de Distribución en Kardex']);
        Permission::create(['name' => 'kardex_distribución.ver', 'module' => 'inventario', 'description' => 'Mostrar Guía de Distribución en Kardex']);
        Permission::create(['name' => 'kardex_distribución.anular', 'module' => 'inventario', 'description' => 'Anular Guía de Distribución en Kardex']);

        // ALMACEN X A X
        Permission::create(['name' => 'kardex_traslado.listar', 'module' => 'inventario', 'description' => 'Lista de Guías de Traslado en Kardex']);
        Permission::create(['name' => 'kardex_traslado.crear', 'module' => 'inventario', 'description' => 'Crear Guía de Traslado en Kardex']);
        Permission::create(['name' => 'kardex_traslado.ver', 'module' => 'inventario', 'description' => 'Mostrar Guía de Traslado en Kardex']);
        Permission::create(['name' => 'kardex_traslado.anular', 'module' => 'inventario', 'description' => 'Anular Guía de Traslado en Kardex']);

        Permission::create(['name' => 'kardex_salida.listar', 'module' => 'inventario', 'description' => 'Lista de Guías de Salida en Kardex']);
        Permission::create(['name' => 'kardex_salida.crear', 'module' => 'inventario', 'description' => 'Crear Guía de Salida en Kardex']);
        Permission::create(['name' => 'kardex_salida.ver', 'module' => 'inventario', 'description' => 'Mostrar Guía de Salida en Kardex']);
        Permission::create(['name' => 'kardex_salida.anular', 'module' => 'inventario', 'description' => 'Anular Guía de Salida en Kardex']);

        Permission::create(['name' => 'inventario.consulta', 'module' => 'inventario', 'description' => 'Consulta de Inventario por Producto']);

        Permission::create(['name' => 'cierre_periodo.listar', 'module' => 'inventario', 'description' => 'Lista de los Cierres de Periodo en el Sistema']);
        Permission::create(['name' => 'cierre_periodo.ver', 'module' => 'inventario', 'description' => 'Lista de Guías de Salida en Kardex']);

        Permission::create(['name' => 'inventario.movimiento', 'module' => 'inventario', 'description' => 'Lista de Movimientos por Productos o Servicios']);

        //* Créditos y Cobranzas 

        Permission::create(['name' => 'factura.listar_por_pagar', 'module' => 'creditos_cobranzas', 'description' => 'Lista de Facturas a Pagar']);
        Permission::create(['name' => 'factura.listar_pagadas', 'module' => 'creditos_cobranzas', 'description' => 'Lista de Facturas Pagadas']);
        Permission::create(['name' => 'factura.pagar', 'module' => 'creditos_cobranzas', 'description' => 'Pagar Factura']);
        Permission::create(['name' => 'factura.detalle_pago', 'module' => 'creditos_cobranzas', 'description' => 'Ver detalle de pago de la Factura']);

        Permission::create(['name' => 'factura_m.listar_por_pagar', 'module' => 'creditos_cobranzas', 'description' => 'Lista de Facturas Manuales a Pagar']);
        Permission::create(['name' => 'factura_m.listar_pagadas', 'module' => 'creditos_cobranzas', 'description' => 'Lista de Facturas Manuales Pagadas']);
        Permission::create(['name' => 'factura_m.pagar', 'module' => 'creditos_cobranzas', 'description' => 'Pagar Factura Manual']);
        Permission::create(['name' => 'factura_m.detalle_pago', 'module' => 'creditos_cobranzas', 'description' => 'Ver detalle de pago de la Factura Manual']);

        Permission::create(['name' => 'boleta.listar_por_pagar', 'module' => 'creditos_cobranzas', 'description' => 'Lista de Boletas a Pagar']);
        Permission::create(['name' => 'boleta.listar_pagadas', 'module' => 'creditos_cobranzas', 'description' => 'Lista de Boletas Pagadas']);
        Permission::create(['name' => 'boleta.pagar', 'module' => 'creditos_cobranzas', 'description' => 'Pagar Boleta']);
        Permission::create(['name' => 'boleta.detalle_pago', 'module' => 'creditos_cobranzas', 'description' => 'Ver detalle de pago de la Boleta']);

        Permission::create(['name' => 'boleta_m.listar_por_pagar', 'module' => 'creditos_cobranzas', 'description' => 'Lista de Boletas Manuales a Pagar']);
        Permission::create(['name' => 'boleta_m.listar_pagadas', 'module' => 'creditos_cobranzas', 'description' => 'Lista de Boletas Manuales Pagadas']);
        Permission::create(['name' => 'boleta_m.pagar', 'module' => 'creditos_cobranzas', 'description' => 'Pagar Boleta Manual']);
        Permission::create(['name' => 'boleta_m.detalle_pago', 'module' => 'creditos_cobranzas', 'description' => 'Ver detalle de pago de la Boleta Manual']);

        Permission::create(['name' => 'nota_venta.listar_por_pagar', 'module' => 'creditos_cobranzas', 'description' => 'Lista de Notas de Ventas a Pagar']);
        Permission::create(['name' => 'nota_venta.listar_pagadas', 'module' => 'creditos_cobranzas', 'description' => 'Lista de Notas de Ventas Pagadas']);
        Permission::create(['name' => 'nota_venta.pagar', 'module' => 'creditos_cobranzas', 'description' => 'Pagar Notas de Venta']);
        Permission::create(['name' => 'nota_venta.detalle_pago', 'module' => 'creditos_cobranzas', 'description' => 'Ver detalle de pago de la Notas de Venta']);

        //* Servicio Técnico

        Permission::create(['name' => 'servicio_tecnico.servicios_listar', 'module' => 'servicio_tecnico', 'description' => 'Lista de Servicios']);
        Permission::create(['name' => 'servicio_tecnico.servicios_crear', 'module' => 'servicio_tecnico', 'description' => 'Lista de Servicios']);
        Permission::create(['name' => 'servicio_tecnico.cotizacion_listar', 'module' => 'servicio_tecnico', 'description' => 'Lista de Servicios']);
        Permission::create(['name' => 'servicio_tecnico.cotizacion_ver', 'module' => 'servicio_tecnico', 'description' => 'Lista de Servicios']);
        Permission::create(['name' => 'servicio_tecnico.o_servicio_listar', 'module' => 'servicio_tecnico', 'description' => 'Lista de Servicios']);
        Permission::create(['name' => 'servicio_tecnico.o_servicio_entregados_listar', 'module' => 'servicio_tecnico', 'description' => 'Lista de Servicios']);

        //! Posiblemente falta

        //* Personal

        Permission::create(['name' => 'personal.listar', 'module' => 'personal', 'description' => 'Lista de Personal']);
        Permission::create(['name' => 'personal.crear', 'module' => 'personal', 'description' => 'Crear Personal']);
        Permission::create(['name' => 'personal.ver', 'module' => 'personal', 'description' => 'Mostrar Personal']);
        Permission::create(['name' => 'personal.editar', 'module' => 'personal', 'description' => 'Editar Personal']);
        Permission::create(['name' => 'personal.estado', 'module' => 'personal', 'description' => 'Cambiar el estado de un Personal en el Sistema']);

        Permission::create(['name' => 'vendedores.listar', 'module' => 'personal', 'description' => 'Lista de Vendedores']);
        Permission::create(['name' => 'vendedores.crear', 'module' => 'personal', 'description' => 'Crear Vendedor']);
        Permission::create(['name' => 'vendedores.ver', 'module' => 'personal', 'description' => 'Mostrar Vendedor']);
        Permission::create(['name' => 'vendedores.editar', 'module' => 'personal', 'description' => 'Editar Vendedor']);
        Permission::create(['name' => 'vendedores.estado', 'module' => 'personal', 'description' => 'Cambiar el estado de un Personal en el Sistema']);

        Permission::create(['name' => 'transporte_publico.listar', 'module' => 'personal', 'description' => 'Lista de Vehiculos de Transporte Público']);
        Permission::create(['name' => 'transporte_publico.crear', 'module' => 'personal', 'description' => 'Crear Vehiculo de Transporte Público']);
        Permission::create(['name' => 'transporte_publico.ver', 'module' => 'personal', 'description' => 'Mostrar Vehiculo de Transporte Público']);
        Permission::create(['name' => 'transporte_publico.editar', 'module' => 'personal', 'description' => 'Editar Vehiculo de Transporte Público']);
        Permission::create(['name' => 'transporte_publico.estado', 'module' => 'personal', 'description' => 'Cambiar el estado de un Vehiculo de Transporte Público en el Sistema']);

        Permission::create(['name' => 'transporte_privado.listar', 'module' => 'personal', 'description' => 'Lista de Vehiculos de Transporte Privado']);
        Permission::create(['name' => 'transporte_privado.crear', 'module' => 'personal', 'description' => 'Crear Vehiculo de Transporte Privado']);
        Permission::create(['name' => 'transporte_privado.ver', 'module' => 'personal', 'description' => 'Mostrar Vehiculo de Transporte Privado']);
        Permission::create(['name' => 'transporte_privado.editar', 'module' => 'personal', 'description' => 'Editar Vehiculo de Transporte Privado']);
        Permission::create(['name' => 'transporte_privado.estado', 'module' => 'personal', 'description' => 'Cambiar el estado de un Vehiculo de Transporte Privado en el Sistema']);

        //* Consultas

        Permission::create(['name' => 'consultas.guia_ingreso', 'module' => 'consultas', 'description' => 'Consulta para Guias de Ingreso']);
        Permission::create(['name' => 'consultas.guia_egreso', 'module' => 'consultas', 'description' => 'Consulta para Guias de Egreso']);
        Permission::create(['name' => 'consultas.informe_tecnico', 'module' => 'consultas', 'description' => 'Consulta para Informe Tecnico']);

        Permission::create(['name' => 'consultas.productos', 'module' => 'consultas' ] , ['description' => 'Consulta sobre Productos']);
        Permission::create(['name' => 'consultas.servicios', 'module' => 'consultas' ] , ['description' => 'Consulta sobre Servicios']);
        
        Permission::create(['name' => 'consultas.reporte_comprobantes', 'module' => 'consultas' ] , ['description' => 'Consulta para los Comprobantes']);

        //* Registro Sunat

        Permission::create(['name' => 'factura.listar_por_emitir', 'module' => 'registro_sunat', 'description' => 'Lista de Facturas a Emitir']);
        Permission::create(['name' => 'factura.emitir', 'module' => 'registro_sunat', 'description' => 'Emitir Factura a Sunat']);
        Permission::create(['name' => 'factura.listar_emitidas', 'module' => 'registro_sunat', 'description' => 'Lista de Facturas Emitidas']);
        Permission::create(['name' => 'factura.xml', 'module' => 'registro_sunat', 'description' => 'Descargar XML de Factura Emitida']);
        Permission::create(['name' => 'factura.cdr', 'module' => 'registro_sunat', 'description' => 'Descargar CDR de Factura Emitida']);

        Permission::create(['name' => 'factura_m.listar_por_emitir', 'module' => 'registro_sunat', 'description' => 'Lista de Facturas Manuales a Emitir']);
        Permission::create(['name' => 'factura_m.emitir', 'module' => 'registro_sunat', 'description' => 'Emitir Factura Manual a Sunat']);
        Permission::create(['name' => 'factura_m.listar_emitidas', 'module' => 'registro_sunat', 'description' => 'Lista de Facturas Manuales Emitidas']);
        Permission::create(['name' => 'factura_m.xml', 'module' => 'registro_sunat', 'description' => 'Descargar XML de Factura Manual Emitida']);
        Permission::create(['name' => 'factura_m.cdr', 'module' => 'registro_sunat', 'description' => 'Descargar CDR de Factura Manual Emitida']);

        Permission::create(['name' => 'detraccion_factura.listar', 'module' => 'registro_sunat', 'description' => 'Lista de Facturas con Detraccions']);

        Permission::create(['name' => 'boleta.listar_por_emitir', 'module' => 'registro_sunat', 'description' => 'Lista de Boletas a Emitir']);
        Permission::create(['name' => 'boleta.emitir', 'module' => 'registro_sunat', 'description' => 'Emitir Boleta a Sunat']);
        Permission::create(['name' => 'boleta.listar_emitidas', 'module' => 'registro_sunat', 'description' => 'Lista de Boletas Emitidas']);
        Permission::create(['name' => 'boleta.xml', 'module' => 'registro_sunat', 'description' => 'Descargar XML de Boleta Emitida']);
        Permission::create(['name' => 'boleta.cdr', 'module' => 'registro_sunat', 'description' => 'Descargar CDR de Boleta Emitida']);

        Permission::create(['name' => 'boleta_m.listar_por_emitir', 'module' => 'registro_sunat', 'description' => 'Lista de Boletas Manuales a Emitir']);
        Permission::create(['name' => 'boleta_m.emitir', 'module' => 'registro_sunat', 'description' => 'Emitir Boleta Manual a Sunat']);
        Permission::create(['name' => 'boleta_m.listar_emitidas', 'module' => 'registro_sunat', 'description' => 'Lista de Boletas Manuales Emitidas']);
        Permission::create(['name' => 'boleta_m.xml', 'module' => 'registro_sunat', 'description' => 'Descargar XML de Boleta Manual Emitida']);
        Permission::create(['name' => 'boleta_m.cdr', 'module' => 'registro_sunat', 'description' => 'Descargar CDR de Boleta Manual Emitida']);

        Permission::create(['name' => 'guia_remision.listar_por_emitir', 'module' => 'registro_sunat', 'description' => 'Lista de Guias Electronicas a Emitir']);
        Permission::create(['name' => 'guia_remision.emitir', 'module' => 'registro_sunat', 'description' => 'Emitir Guia Electronica a Sunat']);
        Permission::create(['name' => 'guia_remision.listar_emitidas', 'module' => 'registro_sunat', 'description' => 'Lista de Guias Electronicass Emitidas']);
        Permission::create(['name' => 'guia_remision.xml', 'module' => 'registro_sunat', 'description' => 'Descargar XML de Guia Electronica Emitida']);
        Permission::create(['name' => 'guia_remision.cdr', 'module' => 'registro_sunat', 'description' => 'Descargar CDR de Guia Electronica Emitida']);
        Permission::create(['name' => 'guia_remision.anular', 'module' => 'registro_sunat', 'description' => 'Anular Guia Electronica Emitida']);

        Permission::create(['name' => 'guia_remision_m.listar_por_emitir', 'module' => 'registro_sunat', 'description' => 'Lista de Guias Electronicas M a Emitir']);
        Permission::create(['name' => 'guia_remision_m.emitir', 'module' => 'registro_sunat', 'description' => 'Emitir Guia Electronica a Sunat']);
        Permission::create(['name' => 'guia_remision_m.listar_emitidas', 'module' => 'registro_sunat', 'description' => 'Lista de Guias Electronicas M. Emitidas']);
        Permission::create(['name' => 'guia_remision_m.xml', 'module' => 'registro_sunat', 'description' => 'Descargar XML de Guia Electronica M. Emitida']);
        Permission::create(['name' => 'guia_remision_m.cdr', 'module' => 'registro_sunat', 'description' => 'Descargar CDR de Guia Electronica M. Emitida']);
        // Permission::create(['name' => 'guia_remision_m.anular', 'module' => 'registro_sunat', 'description' => 'Anular Guia Electronica M. Emitida']);

        Permission::create(['name' => 'nota_credito.listar_por_emitir', 'module' => 'registro_sunat', 'description' => 'Lista de Notas de Crédito a Emitir']);
        Permission::create(['name' => 'nota_credito.emitir', 'module' => 'registro_sunat', 'description' => 'Emitir Notas de Crédito a Sunat']);
        Permission::create(['name' => 'nota_credito.lista_emitidas', 'module' => 'registro_sunat', 'description' => 'Lista de Notas de Crédito Emitidas']);
        Permission::create(['name' => 'nota_credito.xml', 'module' => 'registro_sunat', 'description' => 'Descargar XML de Nota de Crédito Emitida']);
        Permission::create(['name' => 'nota_credito.cdr', 'module' => 'registro_sunat', 'description' => 'Descargar XML de Nota de Crédito Emitida']);

        Permission::create(['name' => 'nota_debito.listar_por_emitir', 'module' => 'registro_sunat', 'description' => 'Lista de Notas de Débito a Emitir']);
        Permission::create(['name' => 'nota_debito.emitir', 'module' => 'registro_sunat', 'description' => 'Emitir Notas de Débito a Sunat']);
        Permission::create(['name' => 'nota_debito.lista_emitidas', 'module' => 'registro_sunat', 'description' => 'Lista de Notas de Débito Emitidas']);
        Permission::create(['name' => 'nota_debito.xml', 'module' => 'registro_sunat', 'description' => 'Descargar XML de Nota de Débito Emitida']);
        Permission::create(['name' => 'nota_debito.cdr', 'module' => 'registro_sunat', 'description' => 'Descargar XML de Nota de Débito Emitida']);


        // * Productos y Servicios

        Permission::create(['name' => 'productos.listar', 'module' => 'productos_servicios', 'description' => 'Lista de Productos']);
        Permission::create(['name' => 'productos.crear', 'module' => 'productos_servicios', 'description' => 'Crear Producto']);
        Permission::create(['name' => 'productos.ver', 'module' => 'productos_servicios', 'description' => 'Mostrar Producto']);
        Permission::create(['name' => 'productos.editar', 'module' => 'productos_servicios', 'description' => 'Editar Producto']);
        Permission::create(['name' => 'productos.estado', 'module' => 'productos_servicios', 'description' => 'Cambiar el estado de un Producto']);

        Permission::create(['name' => 'servicios.listar', 'module' => 'productos_servicios', 'description' => 'Lista de Servicios']);
        Permission::create(['name' => 'servicios.crear', 'module' => 'productos_servicios', 'description' => 'Crear Servicio']);
        Permission::create(['name' => 'servicios.ver', 'module' => 'productos_servicios', 'description' => 'Mostrar Servicio']);
        Permission::create(['name' => 'servicios.editar', 'module' => 'productos_servicios', 'description' => 'Editar Servicio']);
        Permission::create(['name' => 'servicios.estado', 'module' => 'productos_servicios', 'description' => 'Cambiar el estado de un Servicio']);

        //* Proyecto PBM

        Permission::create(['name' => 'proyectos_pmb.listar', 'module' => 'proyectos_pmb', 'description' => 'Lista de Proyectos']);
        Permission::create(['name' => 'proyectos_pmb.crear', 'module' => 'proyectos_pmb', 'description' => 'Crear Proyecto']);
        Permission::create(['name' => 'proyectos_pmb.ver', 'module' => 'proyectos_pmb', 'description' => 'Ver el detalle de un Proyecto']);
        Permission::create(['name' => 'proyectos_pmb.editar', 'module' => 'proyectos_pmb', 'description' => 'Editar un Proyecto']);

        Permission::create(['name' => 'proyectos_pmb.listar_act', 'module' => 'proyectos_pmb', 'description' => 'Ver las actividades de un Proyecto']);
        Permission::create(['name' => 'proyectos_pmb.crear_act', 'module' => 'proyectos_pmb', 'description' => 'Crear las actividades de un Proyecto']);
        Permission::create(['name' => 'proyectos_pmb.editar_act', 'module' => 'proyectos_pmb', 'description' => 'Crear las actividades de un Proyecto']);
        Permission::create(['name' => 'proyectos_pmb.borrar_act', 'module' => 'proyectos_pmb', 'description' => 'Borrar actividades de un Proyecto']);

        Permission::create(['name' => 'proyectos_pmb.listar_tareas', 'module' => 'proyectos_pmb', 'description' => 'Listar tareas para una actividad']);
        Permission::create(['name' => 'proyectos_pmb.ver_tareas', 'module' => 'proyectos_pmb', 'description' => 'Ver tareas para una actividad']);
        Permission::create(['name' => 'proyectos_pmb.crear_tarea', 'module' => 'proyectos_pmb', 'description' => 'Crear tareas para una actividad']);
        Permission::create(['name' => 'proyectos_pmb.editar_tarea', 'module' => 'proyectos_pmb', 'description' => 'Editar tareas para una actividad']);
        Permission::create(['name' => 'proyectos_pmb.borrar_tarea', 'module' => 'proyectos_pmb', 'description' => 'Crear las actividades de un Proyecto']);

        Permission::create(['name' => 'proyectos_pmb.crear_comentario', 'module' => 'proyectos_pmb', 'description' => 'Crear comentario a las tareas de una actividades de un Proyecto']);

        Permission::create(['name' => 'proyectos_pmb.reporte', 'module' => 'proyectos_pmb', 'description' => 'Ver el Reporte General']);

        Permission::create(['name' => 'proyectos_pmb.gantt', 'module' => 'proyectos_pmb', 'description' => 'Ver en Gráfico Gantt un Proyectos']);

        //* Correo

        Permission::create(['name' => 'correo.listar_enviados', 'module' => 'correo', 'description' => 'Lista de Correos Enviados']);
        Permission::create(['name' => 'correo.enviar', 'module' => 'correo', 'description' => 'Enviar Correo']);
        Permission::create(['name' => 'correo.lista_borradores', 'module' => 'correo', 'description' => 'Lista de Borradores de Correos']);
        Permission::create(['name' => 'correo.configuracion', 'module' => 'correo', 'description' => 'Mostrar Servicio']);
        Permission::create(['name' => 'correo.eliminar', 'module' => 'correo', 'description' => 'Mostrar Servicio']);
        Permission::create(['name' => 'correo.papelera', 'module' => 'correo', 'description' => 'Mostrar Servicio']);
        Permission::create(['name' => 'correo.suprimir', 'module' => 'correo', 'description' => 'Mostrar Servicio']);


        //* Auxiliar

        //! Clientes existe 

        Permission::create(['name' => 'proveedor.listar', 'module' => 'auxiliar', 'description' => 'Lista de Proveedores']);
        Permission::create(['name' => 'proveedor.crear', 'module' => 'auxiliar', 'description' => 'Crear Proveedor']);
        Permission::create(['name' => 'proveedor.ver', 'module' => 'auxiliar', 'description' => 'Mostrar Proveedor']);
        Permission::create(['name' => 'proveedor.editar', 'module' => 'auxiliar', 'description' => 'Editar Proveedor']);
        Permission::create(['name' => 'proveedor.anular', 'module' => 'auxiliar', 'description' => 'Anular Proveedor']);

        //* Perfil de Usuario

        Permission::create(['name' => 'perfil_usuario.ver', 'module' => 'perfil_usuario', 'description' => 'Ver informacion del Perfil del Usuario']);
        Permission::create(['name' => 'perfil_usuario.editar', 'module' => 'perfil_usuario', 'description' => 'Editar informacion del Perfil del Usuario']);
        
            //* Mi empresa

        Permission::create(['name' => 'empresa.ver', 'module' => 'empresa', 'description' => 'Ver informacion de la Empresa']);
        Permission::create(['name' => 'empresa.editar', 'module' => 'empresa', 'description' => 'Editar informacion de la Empresa']);

        Permission::create(['name' => 'bancos.editar', 'module' => 'empresa', 'description' => 'Editar informacion de los Bancos de la Empresa']);

        Permission::create(['name' => 'moneda.editar', 'module' => 'empresa', 'description' => 'Editar la Moneda Principal de la Empresa']);

        // * Configuracion

        Permission::create(['name' => 'almacen.listar', 'module' => 'configuracion_general', 'description' => 'Lista de los Almacenes']);
        Permission::create(['name' => 'almacen.crear', 'module' => 'configuracion_general', 'description' => 'Crear Almacen para el Sistema']);
        Permission::create(['name' => 'almacen.ver', 'module' => 'configuracion_general', 'description' => 'Mostrar informacion del Almacen']);
        Permission::create(['name' => 'almacen.editar', 'module' => 'configuracion_general', 'description' => 'Editar informacion del Almacen']);
        Permission::create(['name' => 'almacen.estado', 'module' => 'configuracion_general', 'description' => 'Cambiar el estado del Almacen']);

        Permission::create(['name' => 'apariencia.ver', 'module' => 'configuracion_general', 'description' => 'Mostrar configuracion de la Apariencia del Sistema']);
        Permission::create(['name' => 'apariencia.editar', 'module' => 'configuracion_general', 'description' => 'Editar configuracion de la Apariencia del Sistema']);

        Permission::create(['name' => 'familia.listar', 'module' => 'configuracion_general', 'description' => 'Lista de las Familias de los Productos y Servicios']);
        Permission::create(['name' => 'familia.crear', 'module' => 'configuracion_general', 'description' => 'Crear Familia para los Productos y Servicios']);
        Permission::create(['name' => 'familia.editar', 'module' => 'configuracion_general', 'description' => 'Editar Familia para los Productos y Servicios']);
        Permission::create(['name' => 'familia.estado', 'module' => 'configuracion_general', 'description' => 'Cambiar el estado de la Familia para los Productos y Servicios']);

        Permission::create(['name' => 'subfamilia.ver', 'module' => 'configuracion_general', 'description' => 'Mostrar Subfamilia']);
        Permission::create(['name' => 'subfamilia.crear', 'module' => 'configuracion_general', 'description' => 'Crear Subfamilia']);
        Permission::create(['name' => 'subfamilia.editar', 'module' => 'configuracion_general', 'description' => 'Editar Subfamilia']);
        Permission::create(['name' => 'subfamilia.estado', 'module' => 'configuracion_general', 'description' => 'Cambiar el estado de la Subfamilia']);

        Permission::create(['name' => 'garantia_doc.listar', 'module' => 'configuracion_general', 'description' => 'Lista de las Garantias para Documentos']);
        Permission::create(['name' => 'garantia_doc.crear', 'module' => 'configuracion_general', 'description' => 'Crear Garantia para Documentos']);
        Permission::create(['name' => 'garantia_doc.editar', 'module' => 'configuracion_general', 'description' => 'Editar Garantia para Documentos']);
        Permission::create(['name' => 'garantia_doc.estado', 'module' => 'configuracion_general', 'description' => 'Cambiar el estado de la Garantia para Documentos']);

        Permission::create(['name' => 'marcas.listar', 'module' => 'configuracion_general', 'description' => 'Lista de las Marcas de los Productos y Servicios']);
        Permission::create(['name' => 'marcas.crear', 'module' => 'configuracion_general', 'description' => 'Crear Marca para los Productos y Servicios']);
        Permission::create(['name' => 'marcas.editar', 'module' => 'configuracion_general', 'description' => 'Editar Marca para los Productos y Servicios']);
        Permission::create(['name' => 'marcas.estado', 'module' => 'configuracion_general', 'description' => 'Cambiar el estado de la Marca para los Productos y Servicios']);

        Permission::create(['name' => 'motivos.listar', 'module' => 'configuracion_general', 'description' => 'Lista de Motivos']);
        Permission::create(['name' => 'motivos.crear', 'module' => 'configuracion_general', 'description' => 'Crear Marca para los Productos y Servicios']);
        Permission::create(['name' => 'motivos.editar', 'module' => 'configuracion_general', 'description' => 'Editar Marca para los Productos y Servicios']);
        Permission::create(['name' => 'motivos.estado', 'module' => 'configuracion_general', 'description' => 'Cambiar el estado de la Marca para los Productos y Servicios']);

        Permission::create(['name' => 'tipo_cambio.listar', 'module' => 'configuracion_general', 'description' => 'Lista de Tipo de Cambio Historico']);
        Permission::create(['name' => 'tipo_cambio.crear', 'module' => 'configuracion_general', 'description' => 'Generar el Tipo de Cambio del Día']);
        Permission::create(['name' => 'tipo_cambio.editar', 'module' => 'configuracion_general', 'description' => 'Editar el Tipo de Cambio del Día']);

        Permission::create(['name' => 'unidad_m.listar', 'module' => 'configuracion_general', 'description' => 'Lista Unidades de Medida']);
        Permission::create(['name' => 'unidad_m.crear', 'module' => 'configuracion_general', 'description' => 'Crear Unidad de Medida']);
        Permission::create(['name' => 'unidad_m.editar', 'module' => 'configuracion_general', 'description' => 'Editar Unidad de Medida']);
        Permission::create(['name' => 'unidad_m.estado', 'module' => 'configuracion_general', 'description' => 'Cambiar estado de Unidad de Medida']);

        Permission::create(['name' => 'usuarios.listar', 'module' => 'configuracion_general', 'description' => 'Listar Usuarios del Sistema']);
        Permission::create(['name' => 'usuarios.crear', 'module' => 'configuracion_general', 'description' => 'Asignar Personal como usuario en el Sistema']);
        Permission::create(['name' => 'usuarios.personalizar_permisos', 'module' => 'configuracion_general', 'description' => 'Asignar Permisos Personalizados a un Usuario']);
        Permission::create(['name' => 'usuarios.editar', 'module' => 'configuracion_general', 'description' => 'Editar Datos de un Usuario']);
        Permission::create(['name' => 'usuarios.estado', 'module' => 'configuracion_general', 'description' => 'Cambiar estado de un Usuario en el Sistema']);
        Permission::create(['name' => 'usuarios.password', 'module' => 'configuracion_general', 'description' => 'Cambiar de contraseña a un Usuario en el Sistema']);

        Permission::create(['name' => 'roles.listar', 'module' => 'configuracion_general', 'description' => 'Listar Roles del Sistema']);
        Permission::create(['name' => 'roles.crear', 'module' => 'configuracion_general', 'description' => 'Crear Roles del Sistema']);
        Permission::create(['name' => 'roles.ver', 'module' => 'configuracion_general', 'description' => 'Ver la información del Rol']);
        Permission::create(['name' => 'roles.permisos', 'module' => 'configuracion_general', 'description' => 'Ver los permisos por cada Rol']);
        Permission::create(['name' => 'roles.editar_permisos', 'module' => 'configuracion_general', 'description' => 'Editar los permisos por cada Rol']);

        Permission::create(['name' => 'validez.listar', 'module' => 'configuracion_general', 'description' => 'Lista de Validez para Comprobantes']);
        Permission::create(['name' => 'validez.crear', 'module' => 'configuracion_general', 'description' => 'Crear Validez para Comprobantes']);
        Permission::create(['name' => 'validez.editar', 'module' => 'configuracion_general', 'description' => 'Crear Validez para Comprobantes']);
        Permission::create(['name' => 'validez.estado', 'module' => 'configuracion_general', 'description' => 'Crear Validez para Comprobantes']);

        Permission::create(['name' => 'alarma.listar', 'module' => 'configuracion_general', 'description' => 'Lista de Alarma para Comprobantes']);
        Permission::create(['name' => 'alarma.crear', 'module' => 'configuracion_general', 'description' => 'Crear de Alarma para Comprobantes']);
        Permission::create(['name' => 'alarma.editar', 'module' => 'configuracion_general', 'description' => 'Crear de Alarma para Comprobantes']);
        Permission::create(['name' => 'alarma.estado', 'module' => 'configuracion_general', 'description' => 'Crear de Alarma para Comprobantes']);

        //Admin
        $super_admin = Role::create(['name' => 'SuperAdministrador','description'=>'Rol de SuperAdministrador, solo se deberia tener 1 por Sistema']);
        $admin = Role::create(['name' => 'Administrador', 'description'=>'Rol de Administrador Total del Sistema']);
        $ventas = Role::create(['name' => 'Vendedor', 'description'=>'Rol de Vendedor Total del Sistema']);
        $personalizado = Role::create(['name' => 'Personalizado', 'description'=>'Rol para Personalizar en el Sistema']);

        $super_admin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(Permission::all());

        $users = User::get();

        foreach ($users as $usuario) {
            if ($usuario->id == 1) {
                $usuario->assignRole('SuperAdministrador');
            } else {
                $usuario->assignRole('Administrador');
            }
        }


        // //$admin->givePermissionTo('products.index');
        // //$admin->givePermissionTo(Permission::all());

        // //Guest
        // $guest = Role::create(['name' => 'Guest']);

        // $guest->givePermissionTo([
        //     'inicio',
        // ]);

        // //User Admin
        // $user = User::find(1);
        // $user->assignRole('Admin');

        // // $user2 = User::find(2);
        // // $user2->assignRole('Admin');

        // // $user3 = User::find(3);
        // // $user3->assignRole('Admin');
    }
}
