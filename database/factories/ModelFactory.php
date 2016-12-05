<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Usuario::class, function (Faker\Generator $faker) {
    return [
        'nickname' => $faker->unique()->userName,
        'nombre' => $faker->firstName,
        'apellido' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt(str_random(10)),
        'url' => $faker->url,
        'ubicacion' => $faker->country,
        //'imagen' => $faker->imageUrl($width = 640, $height = 480),
        'estado' => false,
        'permiso' => true,
        'remember_token' => str_random(10),
    ];
});
