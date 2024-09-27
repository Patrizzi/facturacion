<?php

use App\Activity;
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker) {
    return [
        'proyecto_id' => App\ProjectManager::inRandomOrder()->first()->id,
        'responsable_id' => App\User::inRandomOrder()->first()->id,
        'nombre' => $faker->word,
        'contenido' => $faker->paragraph(2),
        'fecha_inicio' => $faker->dateTimeBetween('-1 year', 'now'),
        'fecha_cierre' => $faker->dateTimeBetween('now', '+1 year'),
        'estado' => $faker->numberBetween(1, 5),
        'color' => $faker->hexColor,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
