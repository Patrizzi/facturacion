<?php

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'actividad_id' => App\Activity::inRandomOrder()->first()->id,
        'user_id' => App\User::inRandomOrder()->first()->id,
        'contenido' => $faker->paragraph(2),
        'fecha_inicio' => $faker->dateTimeBetween('-1 year', 'now'),
        'fecha_cierre' => $faker->dateTimeBetween('now', '+1 year'),
        'estado' => $faker->numberBetween(1, 5),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
