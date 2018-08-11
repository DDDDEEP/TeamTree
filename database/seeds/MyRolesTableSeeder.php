<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class MyRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = factory(Role::class)->times(3)->make();
        Role::insert($roles->toArray());

        $role = Role::find(1);
        $role->project_id = 1;
        $role->display_name = '超级管理员';
        $role->level = 1;
        $role->save();

        $role = Role::find(2);
        $role->project_id = 1;
        $role->display_name = '普通管理员';
        $role->level = 2;
        $role->save();

        $role = Role::find(3);
        $role->project_id = 1;
        $role->display_name = '员工';
        $role->level = 2;
        $role->save();
    }
}