<?php

use Illuminate\Database\Seeder;

class LeyendasFeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('leyendas_fes')->insert([
            'codigo' => "1000",
            'informacion' => "Monto en Letras",
        ]);
        DB::table('leyendas_fes')->insert([
            'codigo' => "1002",
            'informacion' => "TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE",
        ]);
        DB::table('leyendas_fes')->insert([
            'codigo' => "2000",
            'informacion' => "COMPROBANTES DE PERCEPCIÓN",
        ]);
        DB::table('leyendas_fes')->insert([
            'codigo' => "2001",
            'informacion' => "BIENES PRESTADOS EN LA AMAZONÍA REGIÓN DE LA SELVA PARA SER CONSUMIDOS EN LA MISMA",
        ]);
        DB::table('leyendas_fes')->insert([
            'codigo' => "2002",
            'informacion' => "SERVICIOS PRESTADOS EN LA AMAZONÍA REGIÓN DE LA SELVA PARA SER CONSUMIDOS EN LA MISMA",
        ]);
        DB::table('leyendas_fes')->insert([
            'codigo' => "2003",
            'informacion' => "CONTRATOS DE CONSTRUCCIÓN EJECUTADOS EN LA AMAZONÍA REGIÓN DE SELVA",
        ]);
        DB::table('leyendas_fes')->insert([
            'codigo' => "2004",
            'informacion' => "Agencia de Viaje - Paquete turístico",
        ]);
        DB::table('leyendas_fes')->insert([
            'codigo' => "2005",
            'informacion' => "Venta realizada por emisor itinerante",
        ]);
        DB::table('leyendas_fes')->insert([
            'codigo' => "2006",
            'informacion' => "Operación sujeta a detracción",
        ]);
        DB::table('leyendas_fes')->insert([
            'codigo' => "2007",
            'informacion' => "Operación sujeta a IVAP",
        ]);
        DB::table('leyendas_fes')->insert([
            'codigo' => "3000",
            'informacion' => "Detracciones: Codigo de BB Y SS sujetos a detraccion ",
        ]);
        DB::table('leyendas_fes')->insert([
            'codigo' => "3001",
            'informacion' => "Detracciones: Numero de cta en el BN",
        ]);
        DB::table('leyendas_fes')->insert([
            'codigo' => "3002",
            'informacion' => "Detracciones: Recurso",
        ]);
    }
}
