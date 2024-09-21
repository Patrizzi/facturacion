<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProjectManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            DB::table('project_services')->insert([
                'nombre' => $faker->word,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($i = 0; $i < 100; $i++) {
            DB::table('project_managers')->insert([
                'ruc' => $faker->numerify('#########'),
                'nombre' => $faker->company,
                'centro_costo' => $faker->word,
                'administrador_id' => 1,
                'responsable_id' => 1,
                'cliente_id' => 1,
                'project_service_id' => $faker->numberBetween(1, 49),
                'fecha_inicio' => $faker->dateTimeBetween('-1 year', 'now'),
                'fecha_cierre' => $faker->dateTimeBetween('now', '+1 year'),
                'prioridad' => $faker->numberBetween(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
