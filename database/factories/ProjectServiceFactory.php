<?php

use App\ProjectService;
use Faker\Generator as Faker;

$factory->define(ProjectService::class, function (Faker $faker) {
    return [
        'nombre' => $faker->word,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
