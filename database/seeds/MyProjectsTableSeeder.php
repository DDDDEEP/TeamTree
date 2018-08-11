<?php

use Illuminate\Database\Seeder;
use App\Models\Project;

class MyProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(Project::class)->times(3)->make();
        Project::insert($users->toArray());
    }
}