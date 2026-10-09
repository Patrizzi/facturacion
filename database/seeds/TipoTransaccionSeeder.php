<?php

use Illuminate\Database\Seeder;

class TipoTransaccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_transacciones')->insert([

            'nombre' => 'Depósito',
            'es_interno' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tipo_transacciones')->insert([
            'nombre' => 'Personal',
            'es_interno' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('tipo_transacciones')->insert([
            'nombre' => 'Caja',
            'es_interno' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    
}
