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

        $names = ['项目一', '项目二', '项目三'];

        Project::insert($users->toArray());
        for ($i = 1; $i <= count($names); $i++) {
            $project = Project::find($i);
            $project->name = $names[$i - 1];
            $project->save();
        };
    }
}