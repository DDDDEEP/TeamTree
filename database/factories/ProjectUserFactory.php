<?php

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

$factory->define(App\Models\ProjectUser::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;

    return [
        'project_id' => 0,
        'user_id'    => 0,
        'role_id'    => 0,
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
