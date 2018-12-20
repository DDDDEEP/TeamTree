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
        $users = factory(Project::class)->times(1)->make();


        Project::insert($users->toArray());

        $project = Project::find(1);
        $project->name = '数据库课程设计';
        $project->description = '项目树管理系统Teamtree';
        $project->save();
    }
}