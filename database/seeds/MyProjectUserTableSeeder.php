<?php

use Illuminate\Database\Seeder;
use App\Models\ProjectUser;
use App\Models\User;

class MyProjectUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::find(1)->projects()->attach([
            1 => ['role_id' => 6, 'status' => 1],
        ]);

        User::find(2)->projects()->attach([
            1 => ['role_id' => 4, 'status' => 1],
        ]);

        User::find(3)->projects()->attach([
            1 => ['role_id' => 4, 'status' => 1],
        ]);

        User::find(4)->projects()->attach([
            1 => ['role_id' => 1, 'status' => 1],
        ]);

        User::find(5)->projects()->attach([
            1 => ['role_id' => 1, 'status' => 1],
        ]);

        User::find(6)->projects()->attach([
            1 => ['role_id' => 1, 'status' => 1],
        ]);
    }
}