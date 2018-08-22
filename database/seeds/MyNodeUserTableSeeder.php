<?php

use Illuminate\Database\Seeder;
use App\Models\NodeUser;
use App\Models\User;

class MyNodeUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::find(4)->nodes()->attach([
            2 => ['role_id' => 2],
        ]);

        User::find(5)->nodes()->attach([
            2 => ['role_id' => 3],
        ]);

        User::find(6)->nodes()->attach([
            2 => ['role_id' => 4],
        ]);

        User::find(2)->nodes()->attach([
            6 => ['role_id' => 4],
        ]);
    }
}