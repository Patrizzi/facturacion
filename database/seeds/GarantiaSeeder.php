<?php

use Illuminate\Database\Seeder;

class GarantiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('garantia')->insert([
            'id' => 1 ,
            'nombre' => 'Sin Garantia',
            'dias'=>'0',
            'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);

    }
}
