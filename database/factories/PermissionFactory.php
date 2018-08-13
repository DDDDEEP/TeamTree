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

$factory->define(App\Models\Permission::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;

    return [
        'name'         => 'route',
        'display_name' => '路由',
        'description'  => $faker->text(50),
        'group_id'     => 0,
        'created_at'   => $date_time,
        'updated_at'   => $date_time,
    ];
});
