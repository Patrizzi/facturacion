<?php
namespace Database\Seeders;

use App\TipoTransaccion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            [
                'nombre' => 'Depósito',
                'es_interno' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Personal',
                'es_interno' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Caja',
                'es_interno' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
