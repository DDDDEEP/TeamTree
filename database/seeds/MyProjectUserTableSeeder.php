<?php

use Illuminate\Database\Seeder;
use App\Models\ProjectUser;

class MyProjectUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project_users = factory(ProjectUser::class)->times(3)->make();
        ProjectUser::insert($project_users->toArray());

        $project_user = ProjectUser::find(1);
        $project_user->project_id = 1;
        $project_user->user_id = 1;
        $project_user->role_id = 1;
        $project_user->save();

        $project_user = ProjectUser::find(2);
        $project_user->project_id = 2;
        $project_user->user_id = 1;
        $project_user->role_id = 1;
        $project_user->save();

        $project_user = ProjectUser::find(3);
        $project_user->project_id = 3;
        $project_user->user_id = 1;
        $project_user->role_id = 1;
        $project_user->save();
    }
}