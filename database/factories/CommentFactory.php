<?php

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $width = $faker->numberBetween(640, 1280);
    $height = intval($width / 16 * 9);

    return [
        'tarea_id' => App\Task::inRandomOrder()->first()->id,
        'user_id' => App\User::inRandomOrder()->first()->id,
        'contenido' => $faker->paragraph(20),
        'foto' => 'https://picsum.photos/' . $width . '/' . $height . '.webp',
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
