<?php

use Illuminate\Database\Seeder;

class ValidezSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('validez')->insert([
            'id' => 1 ,
            'nombre' => '1 dia',
            'dias'=>'0',
            'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
        ]);

    }
}
