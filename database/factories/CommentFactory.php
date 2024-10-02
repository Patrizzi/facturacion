<?php

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'tarea_id' => App\Task::inRandomOrder()->first()->id,
        'user_id' => App\User::inRandomOrder()->first()->id,
        'contenido' => $faker->paragraph(2),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
