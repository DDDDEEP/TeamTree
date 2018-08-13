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
            1 => ['role_id' => 6],
            2 => ['role_id' => 6],
            3 => ['role_id' => 6],
        ]);

        User::find(2)->projects()->attach([
            1 => ['role_id' => 1],
            2 => ['role_id' => 1],
            3 => ['role_id' => 1],
        ]);

        User::find(3)->projects()->attach([
            1 => ['role_id' => 1],
            2 => ['role_id' => 1],
            3 => ['role_id' => 1],
        ]);
    }
}