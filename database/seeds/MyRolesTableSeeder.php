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
        $roles = factory(Role::class)->times(8)->make();
        Role::insert($roles->toArray());

        $common_roles = ['闲置人员', '执行者', '节点管理员', '树管理员', '项目管理员', '超级管理员'];
        for ($i = 0; $i < count($common_roles); ++$i) {
            $role = Role::find($i + 1);
            $role->project_id = null;
            $role->display_name = $common_roles[$i];
            $role->level = $i + 1;
            $role->save();
        }

        $role = Role::find(7);
        $role->project_id = 1;
        $role->display_name = '自定义闲置人员';
        $role->level = 1;
        $role->save();

        $role = Role::find(8);
        $role->project_id = 1;
        $role->display_name = '自定义执行者';
        $role->level = 2;
        $role->save();
    }
}