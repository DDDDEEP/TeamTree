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

$factory->define(App\Models\Node::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;

    return [
        'project_id'  => 0,
        'parent_id'   => 0,
        'height'      => 1,
        'status'      => 1,
        'description' => $faker->text(50),
        'created_at'  => $date_time,
        'updated_at'  => $date_time,
    ];
});
