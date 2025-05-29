<?php

use App\ProjectManager;
use Faker\Generator as Faker;

$factory->define(ProjectManager::class, function (Faker $faker) {
    return [
        'ruc' => $faker->numerify('#########'),
        'nombre' => $faker->company,
        'centro_costo' => $faker->word,
        'administrador_id' => App\User::inRandomOrder()->first()->id,
        'responsable_id' => App\User::inRandomOrder()->first()->id,
        'cliente_id' => 1,
        'project_service_id' => App\ProjectService::inRandomOrder()->first()->id,
        'fecha_inicio' => $faker->dateTimeBetween('-1 year', 'now'),
        'fecha_cierre' => $faker->dateTimeBetween('now', '+1 year'),
        'prioridad' => $faker->numberBetween(1, 5),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
