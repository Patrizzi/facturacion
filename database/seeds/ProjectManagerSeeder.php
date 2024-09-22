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
        
        $maxProjectServices = DB::table('project_services')->max('id');

        for ($i = 0; $i < 100; $i++) {
            DB::table('project_managers')->insert([
                'ruc' => $faker->numerify('#########'),
                'nombre' => $faker->company,
                'centro_costo' => $faker->word,
                'administrador_id' => 1,
                'responsable_id' => 1,
                'cliente_id' => 1,
                'project_service_id' => $faker->numberBetween(1, $maxProjectServices),
                'fecha_inicio' => $faker->dateTimeBetween('-1 year', 'now'),
                'fecha_cierre' => $faker->dateTimeBetween('now', '+1 year'),
                'prioridad' => $faker->numberBetween(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $maxProjectManagers = DB::table('project_managers')->max('id');

        for ($i = 0; $i < 200; $i++) {
            DB::table('activities')->insert([
                'proyecto_id' => $faker->numberBetween(1, $maxProjectManagers),
                'responsable_id' => 1,
                'nombre' => $faker->word,
                'contenido' => $faker->paragraph(2),
                'fecha_inicio' => $faker->dateTimeBetween('-1 year', 'now'),
                'fecha_cierre' => $faker->dateTimeBetween('now', '+1 year'),
                'estado' => $faker->numberBetween(1, 5),
                'color' => $faker->hexColor(),
                'foto' => 'https://picsum.photos/400/200',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $maxActividades = DB::table('activities')->max('id');
        
        for ($i = 0; $i < 300; $i++) {
            DB::table('tasks')->insert([
                'actividad_id' => $faker->numberBetween(1, $maxActividades),
                'user_id' => 1,
                'contenido' => $faker->paragraph(2),
                'fecha_inicio' => $faker->dateTimeBetween('-1 year', 'now'),
                'fecha_cierre' => $faker->dateTimeBetween('now', '+1 year'),
                'estado' => $faker->numberBetween(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        $maxTasks = DB::table('tasks')->max('id');

        for ($i = 0; $i < 500; $i++) {
            DB::table('comments')->insert([
                'tarea_id' => $faker->numberBetween(1, $maxTasks),
                'user_id' => 1,
                'contenido' => $faker->paragraph(2),
                'foto' => 'https://picsum.photos/400/200',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
