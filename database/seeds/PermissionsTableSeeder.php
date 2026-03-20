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
        Permission::create(['name' => 'inicio'], ['description' => 'Dashboard Inicio']);
        //* VENTAS
        Permission::create(['name' => 'cotizacion.listar'], ['description' => 'Lista de Cotizaciones']);
        Permission::create(['name' => 'cotizacion.crear'], ['description' => 'Crear Cotizacion']);
        Permission::create(['name' => 'cotizacion.ver'], ['description' => 'Mostrar Cotizacion']);
        Permission::create(['name' => 'cotizacion.editar'], ['description' => 'Editar Cotizacion']);
        Permission::create(['name' => 'cotizacion.procesar'], ['description' => 'Procesar Cotizacion']);
        Permission::create(['name' => 'cotizacion.duplicar'], ['description' => 'Duplicar Cotizacion']);

        Permission::create(['name' => 'cotizacion_m.listar'], ['description' => 'Lista de Cotizaciones Manuales']);
        Permission::create(['name' => 'cotizacion_m.crear'], ['description' => 'Crear Cotizacion Manual']);
        Permission::create(['name' => 'cotizacion_m.ver'], ['description' => 'Mostrar Cotizacion Manual']);
        Permission::create(['name' => 'cotizacion_m.editar'], ['description' => 'Editar Cotizacion Manual']);
        Permission::create(['name' => 'cotizacion_m.procesar'], ['description' => 'Procesar Cotizacion Manual']);
        Permission::create(['name' => 'cotizacion_m.duplicar'], ['description' => 'Duplicar Cotizacion Manual']);

        Permission::create(['name' => 'nota_venta.listar'], ['description' => 'Lista de Nota de Ventas']);
        Permission::create(['name' => 'nota_venta.crear'], ['description' => 'Crear Nota de Venta']);
        Permission::create(['name' => 'nota_venta.ver'], ['description' => 'Mostrar Nota de Venta']);
        Permission::create(['name' => 'nota_venta.editar'], ['description' => 'Editar Nota de Venta']);

        Permission::create(['name' => 'clientes.listar'], ['description' => 'Lista de Clientes']);
        Permission::create(['name' => 'clientes.crear'], ['description' => 'Creacion de Cliente']);
        Permission::create(['name' => 'clientes.ver'], ['description' => 'Mostrar Cliente']);
        Permission::create(['name' => 'clientes.editar'], ['description' => 'Editar Cliente']);
        Permission::create(['name' => 'clientes.anular'], ['description' => 'Anular Cliente']);

        //* Tesoreria

        // ?

        //*Comprobantes
        Permission::create(['name' => 'factura.listar'], ['description' => 'Lista de Facturas']);
        Permission::create(['name' => 'factura.crear'], ['description' => 'Crear Factura']);
        Permission::create(['name' => 'factura.ver'], ['description' => 'Mostrar Factura']);
        Permission::create(['name' => 'factura.editar'], ['description' => 'Editar Factura']);
        Permission::create(['name' => 'factura.anular'], ['description' => 'Anular Factura en el Sistema']);

        Permission::create(['name' => 'factura_m.listar'], ['description' => 'Lista de Facturas Manuales']);
        Permission::create(['name' => 'factura_m.crear'], ['description' => 'Crear Factura Manual']);
        Permission::create(['name' => 'factura_m.ver'], ['description' => 'Mostrar Factura Manual' ]);
        Permission::create(['name' => 'factura_m.editar'], ['description' => 'Editar Factura Manual']);
        Permission::create(['name' => 'factura_m.anular'], ['description' => 'Anular Factura Manual en el Sistema']);

        Permission::create(['name' => 'boleta.listar'], ['description' => 'Lista de Boletas']);
        Permission::create(['name' => 'boleta.crear'], ['description' => 'Crear Boleta']);
        Permission::create(['name' => 'boleta.ver'], ['description' => 'Mostrar Boleta']);
        Permission::create(['name' => 'boleta.editar'], ['description' => 'Editar Boleta']);
        Permission::create(['name' => 'boleta.anular'], ['description' => 'Anular Boleta en el Sistema']);

        Permission::create(['name' => 'boleta_m.listar'], ['description' => 'Lista de Boletas Manuales']);
        Permission::create(['name' => 'boleta_m.crear'], ['description' => 'Crear Boleta Manual']);
        Permission::create(['name' => 'boleta_m.ver'], ['description' => 'Mostrar Boleta Manual' ]);
        Permission::create(['name' => 'boleta_m.editar'], ['description' => 'Editar Boleta Manual']);
        Permission::create(['name' => 'boleta_m.anular'], ['description' => 'Anular Boleta Manual en el Sistema']);

        Permission::create(['name' => 'nota_credito.listar'], ['description' => 'Lista de Notas de Crédito']);
        Permission::create(['name' => 'nota_credito.crear'], ['description' => 'Crear Nota de Crédito']);
        Permission::create(['name' => 'nota_credito.ver'], ['description' => 'Mostrar Nota de Crédito' ]);
        Permission::create(['name' => 'nota_credito.editar'], ['description' => 'Editar Nota de Crédito']);
        Permission::create(['name' => 'nota_credito.anular'], ['description' => 'Anular Nota de Crédito en el Sistema']);

        Permission::create(['name' => 'nota_debito.listar'], ['description' => 'Lista de Notas de Débito']);
        Permission::create(['name' => 'nota_debito.crear'], ['description' => 'Crear Nota de Débito']);
        Permission::create(['name' => 'nota_debito.ver'], ['description' => 'Mostrar Nota de Débito' ]);
        Permission::create(['name' => 'nota_debito.editar'], ['description' => 'Editar Nota de Débito']);
        Permission::create(['name' => 'nota_debito.anular'], ['description' => 'Anular Nota de Débito en el Sistema']);

        Permission::create(['name' => 'guia_remision.listar'], ['description' => 'Lista de Guías de Remisión']);
        Permission::create(['name' => 'guia_remision.crear'], ['description' => 'Crear Guia de Remisión']);
        Permission::create(['name' => 'guia_remision.ver'], ['description' => 'Mostrar Guia de Remisión' ]);
        Permission::create(['name' => 'guia_remision.editar'], ['description' => 'Editar Guia de Remisión']);
        Permission::create(['name' => 'guia_remision.anular'], ['description' => 'Anular Guia de Remisión en el Sistema']);

        Permission::create(['name' => 'guia_remision_m.listar'], ['description' => 'Lista de Guías de Remisión Manuales']);
        Permission::create(['name' => 'guia_remision_m.crear'], ['description' => 'Crear Guia de Remisión Manual']);
        Permission::create(['name' => 'guia_remision_m.ver'], ['description' => 'Mostrar Guia de Remisión Manual' ]);
        Permission::create(['name' => 'guia_remision_m.editar'], ['description' => 'Editar Guia de Remisión Manual']);
        Permission::create(['name' => 'guia_remision_m.anular'], ['description' => 'Anular Guia de Remisión Manual en el Sistema']);

        //*GARANTIAS    
        
        Permission::create(['name' => 'guia_ingreso.listar'], ['description' => 'Lista de Guias de Ingreso de Garantias']);
        Permission::create(['name' => 'guia_ingreso.crear'], ['description' => 'Crear Guia de Ingreso de Garantia']);
        Permission::create(['name' => 'guia_ingreso.ver'], ['description' => 'Mostrar Guia de Ingreso de Garantias' ]);
        Permission::create(['name' => 'guia_ingreso.editar'], ['description' => 'Editar Guia de Ingreso de Garantias']);
        Permission::create(['name' => 'guia_ingreso.procesar'], ['description' => 'Procesar Guia de Ingreso a Egreso de Garantias']);
        Permission::create(['name' => 'guia_ingreso.anular'], ['description' => 'Anular Guia de Ingreso de Garantias en el Sistema']);

        Permission::create(['name' => 'guia_egreso.listar'], ['description' => 'Lista de Guias de Egreso de Garantias']);
        Permission::create(['name' => 'guia_egreso.ver'], ['description' => 'Mostrar Guia de Egreso de Garantias' ]);
        Permission::create(['name' => 'guia_egreso.editar'], ['description' => 'Editar Guia de Egreso de Garantias']);
        Permission::create(['name' => 'guia_egreso.procesar'], ['description' => 'Procesar Guia de Egreso a Infome Técnico de Garantias']);
        Permission::create(['name' => 'guia_egreso.anular'], ['description' => 'Anular Guia de Egreso de Garantias en el Sistema']);

        Permission::create(['name' => 'informe_tecnico.listar'], ['description' => 'Lista de Informes Técnicos de Garantias']);
        Permission::create(['name' => 'informe_tecnico.ver'], ['description' => 'Mostrar Informe Técnico de Garantias' ]);
        Permission::create(['name' => 'informe_tecnico.editar'], ['description' => 'Editar Informe Técnico de Garantias']);
        Permission::create(['name' => 'informe_tecnico.anular'], ['description' => 'Anular Informe Técnico de Garantias']);

        //* Inventario

        Permission::create(['name' => 'kardex_entrada.listar'], ['description' => 'Lista de Guías de Entrada en Kardex']);
        Permission::create(['name' => 'kardex_entrada.crear'], ['description' => 'Crear Guía de Entrada en Kardex']);
        Permission::create(['name' => 'kardex_entrada.ver'], ['description' => 'Mostrar Guía de Entrada en Kardex']);
        Permission::create(['name' => 'kardex_entrada.anular'], ['description' => 'Anular Guía de Entrada en Kardex']);

        Permission::create(['name' => 'kardex_distribución.listar'], ['description' => 'Lista de Guías de Distribución en Kardex']);
        Permission::create(['name' => 'kardex_distribución.crear'], ['description' => 'Crear Guía de Distribución en Kardex']);
        Permission::create(['name' => 'kardex_distribución.ver'], ['description' => 'Mostrar Guía de Distribución en Kardex']);
        Permission::create(['name' => 'kardex_distribución.anular'], ['description' => 'Anular Guía de Distribución en Kardex']);

        Permission::create(['name' => 'kardex_traslado.listar'], ['description' => 'Lista de Guías de Traslado en Kardex']);
        Permission::create(['name' => 'kardex_traslado.crear'], ['description' => 'Crear Guía de Traslado en Kardex']);
        Permission::create(['name' => 'kardex_traslado.ver'], ['description' => 'Mostrar Guía de Traslado en Kardex']);
        Permission::create(['name' => 'kardex_traslado.anular'], ['description' => 'Anular Guía de Traslado en Kardex']);

        Permission::create(['name' => 'kardex_salida.listar'], ['description' => 'Lista de Guías de Salida en Kardex']);
        Permission::create(['name' => 'kardex_salida.crear'], ['description' => 'Crear Guía de Salida en Kardex']);
        Permission::create(['name' => 'kardex_salida.ver'], ['description' => 'Mostrar Guía de Salida en Kardex']);
        Permission::create(['name' => 'kardex_salida.anular'], ['description' => 'Anular Guía de Salida en Kardex']);
        
        // ?

        // ?

        // ?

        //* Créditos y Cobranzas 

        Permission::create(['name' => 'factura.listar_por_pagar'], ['description' => 'Lista de Facturas a Pagar']);
        Permission::create(['name' => 'factura.listar_pagadas'], ['description' => 'Lista de Facturas Pagadas']);
        Permission::create(['name' => 'factura.pagar'], ['description' => 'Pagar Factura']);
        Permission::create(['name' => 'factura.detalle_pago'], ['description' => 'Ver detalle de pago de la Factura']);

        Permission::create(['name' => 'factura_m.listar_por_pagar'], ['description' => 'Lista de Facturas Manuales a Pagar']);
        Permission::create(['name' => 'factura_m.listar_pagadas'], ['description' => 'Lista de Facturas Manuales Pagadas']);
        Permission::create(['name' => 'factura_m.pagar'], ['description' => 'Pagar Factura Manual']);
        Permission::create(['name' => 'factura_m.detalle_pago'], ['description' => 'Ver detalle de pago de la Factura Manual']);

        Permission::create(['name' => 'boleta.listar_por_pagar'], ['description' => 'Lista de Boletas a Pagar']);
        Permission::create(['name' => 'boleta.listar_pagadas'], ['description' => 'Lista de Boletas Pagadas']);
        Permission::create(['name' => 'boleta.pagar'], ['description' => 'Pagar Boleta']);
        Permission::create(['name' => 'boleta.detalle_pago'], ['description' => 'Ver detalle de pago de la Boleta']);

        Permission::create(['name' => 'boleta_m.listar_por_pagar'], ['description' => 'Lista de Boletas Manuales a Pagar']);
        Permission::create(['name' => 'boleta_m.listar_pagadas'], ['description' => 'Lista de Boletas Manuales Pagadas']);
        Permission::create(['name' => 'boleta_m.pagar'], ['description' => 'Pagar Boleta Manual']);
        Permission::create(['name' => 'boleta_m.detalle_pago'], ['description' => 'Ver detalle de pago de la Boleta Manual']);

        Permission::create(['name' => 'nota_venta.listar_por_pagar'], ['description' => 'Lista de Notas de Ventas a Pagar']);
        Permission::create(['name' => 'nota_venta.listar_pagadas'], ['description' => 'Lista de Notas de Ventas Pagadas']);
        Permission::create(['name' => 'nota_venta.pagar'], ['description' => 'Pagar Notas de Venta']);
        Permission::create(['name' => 'nota_venta.detalle_pago'], ['description' => 'Ver detalle de pago de la Notas de Venta']);

        //* Servicio Técnico

        // ?

        //* Personal

        Permission::create(['name' => 'personal.listar'], ['description' => 'Lista de Personal']);
        Permission::create(['name' => 'personal.crear'], ['description' => 'Crear Personal']);
        Permission::create(['name' => 'personal.ver'], ['description' => 'Mostrar Personal']);
        Permission::create(['name' => 'personal.editar'], ['description' => 'Editar Personal']);
        Permission::create(['name' => 'personal.anular'], ['description' => 'Anular Personal en el Sistema']);

        Permission::create(['name' => 'vendedores.listar'], ['description' => 'Lista de Vendedores']);
        Permission::create(['name' => 'vendedores.crear'], ['description' => 'Crear Vendedor']);
        Permission::create(['name' => 'vendedores.ver'], ['description' => 'Mostrar Vendedor']);
        Permission::create(['name' => 'vendedores.editar'], ['description' => 'Editar Vendedor']);
        Permission::create(['name' => 'vendedores.anular'], ['description' => 'Anular Personal en el Sistema']);

        Permission::create(['name' => 'transporte_publico.listar'], ['description' => 'Lista de Vehiculos de Transporte Público']);
        Permission::create(['name' => 'transporte_publico.crear'], ['description' => 'Crea Vehiculo de Transporte Público']);
        Permission::create(['name' => 'transporte_publico.editar'], ['description' => 'Editar Vehiculo de Transporte Público']);
        Permission::create(['name' => 'transporte_publico.anular'], ['description' => 'Anular Vehiculo de Transporte Público en el Sistema']);

        Permission::create(['name' => 'transporte_privado.listar'], ['description' => 'Lista de Vehiculos de Transporte Privado']);
        Permission::create(['name' => 'transporte_privado.crear'], ['description' => 'Crea Vehiculo de Transporte Privado']);
        Permission::create(['name' => 'transporte_privado.editar'], ['description' => 'Editar Vehiculo de Transporte Privado']);
        Permission::create(['name' => 'transporte_privado.anular'], ['description' => 'Anular Vehiculo de Transporte Privado en el Sistema']);

        //* Consultas

        // ?

        //* Registro Sunat

        Permission::create(['name' => 'factura.listar_por_emitir'], ['description' => 'Lista de Facturas a Emitir']);
        Permission::create(['name' => 'factura.emitir'], ['description' => 'Emitir Factura a Sunat']);
        Permission::create(['name' => 'factura.listar_emitidas'], ['description' => 'Lista de Facturas Emitidas']);
        Permission::create(['name' => 'factura.xml'], ['description' => 'Descargar XML de Factura Emitida']);
        Permission::create(['name' => 'factura.cdr'], ['description' => 'Descargar CDR de Factura Emitida']);

        Permission::create(['name' => 'factura_m.listar_por_emitir'], ['description' => 'Lista de Facturas Manuales a Emitir']);
        Permission::create(['name' => 'factura_m.emitir'], ['description' => 'Emitir Factura Manual a Sunat']);
        Permission::create(['name' => 'factura_m.listar_emitidas'], ['description' => 'Lista de Facturas Manuales Emitidas']);
        Permission::create(['name' => 'factura_m.xml'], ['description' => 'Descargar XML de Factura Manual Emitida']);
        Permission::create(['name' => 'factura_m.cdr'], ['description' => 'Descargar CDR de Factura Manual Emitida']);

        Permission::create(['name' => 'boleta.listar_por_emitir'], ['description' => 'Lista de Boletas a Emitir']);
        Permission::create(['name' => 'boleta.emitir'], ['description' => 'Emitir Boleta a Sunat']);
        Permission::create(['name' => 'boleta.listar_emitidas'], ['description' => 'Lista de Boletas Emitidas']);
        Permission::create(['name' => 'boleta.xml'], ['description' => 'Descargar XML de Boleta Emitida']);
        Permission::create(['name' => 'boleta.cdr'], ['description' => 'Descargar CDR de Boleta Emitida']);

        Permission::create(['name' => 'boleta_m.listar_por_emitir'], ['description' => 'Lista de Boletas Manuales a Emitir']);
        Permission::create(['name' => 'boleta_m.emitir'], ['description' => 'Emitir Boleta Manual a Sunat']);
        Permission::create(['name' => 'boleta_m.listar_emitidas'], ['description' => 'Lista de Boletas Manuales Emitidas']);
        Permission::create(['name' => 'boleta_m.xml'], ['description' => 'Descargar XML de Boleta Manual Emitida']);
        Permission::create(['name' => 'boleta_m.cdr'], ['description' => 'Descargar CDR de Boleta Manual Emitida']);

        Permission::create(['name' => 'nota_credito.listar_por_emitir'], ['description' => 'Lista de Notas de Crédito a Emitir']);
        Permission::create(['name' => 'nota_credito.emitir'], ['description' => 'Emitir Notas de Crédito a Sunat']);
        Permission::create(['name' => 'nota_credito.lista_emitidas'], ['description' => 'Lista de Notas de Crédito Emitidas']);
        Permission::create(['name' => 'nota_credito.xml'], ['description' => 'Descargar XML de Nota de Crédito Emitida']);
        Permission::create(['name' => 'nota_credito.cdr'], ['description' => 'Descargar XML de Nota de Crédito Emitida']);
        
        Permission::create(['name' => 'nota_debito.listar_por_emitir'], ['description' => 'Lista de Notas de Débito a Emitir']);
        Permission::create(['name' => 'nota_debito.emitir'], ['description' => 'Emitir Notas de Débito a Sunat']);
        Permission::create(['name' => 'nota_debito.lista_emitidas'], ['description' => 'Lista de Notas de Débito Emitidas']);
        Permission::create(['name' => 'nota_debito.xml'], ['description' => 'Descargar XML de Nota de Débito Emitida']);
        Permission::create(['name' => 'nota_debito.cdr'], ['description' => 'Descargar XML de Nota de Débito Emitida']);

        // ?

        // ?
        
        // ?

        


        //Admin
        $super_admin = Role::create(['name' => 'SuperAdministrador']);
        $admin = Role::create(['name' => 'Administrador']);
        $ventas = Role::create(['name' => 'Vendedor']);
        $personalizado = Role::create(['name' => 'Personalizado']);

        $super_admin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(Permission::all());

        $users = User::get();

        foreach ($users as $usuario) {
            if($usuario->id == 1){
                $usuario->assignRole('SuperAdministrador');
            }else{
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
