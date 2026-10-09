<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'personal_id' => '1',
        'password' => bcrypt('123456'),
        'estado' => 1,
        'confi_id' => $faker->numberBetween(1, 3),
        'email_creado' => 0,
        'almacen_id' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
