<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class MyPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = factory(Permission::class)->times(11)->make();
        Permission::insert($permissions->toArray());

        $permission = Permission::find(1);
        $permission->name = 'node.store.change_status';
        $permission->display_name = '改变节点状态';
        $permission->group_id = 2;
        $permission->save();

        $permission = Permission::find(2);
        $permission->name = 'node.create';
        $permission->display_name = '新增节点';
        $permission->group_id = 3;
        $permission->save();

        $permission = Permission::find(3);
        $permission->name = 'node.delete';
        $permission->display_name = '删除节点';
        $permission->group_id = 3;
        $permission->save();

        $permission = Permission::find(4);
        $permission->name = 'node_user.create';
        $permission->display_name = '赋予节点角色';
        $permission->group_id = 4;
        $permission->save();

        $permission = Permission::find(5);
        $permission->name = 'node_user.store';
        $permission->display_name = '编辑节点角色';
        $permission->group_id = 4;
        $permission->save();

        $permission = Permission::find(6);
        $permission->name = 'node_user.delete';
        $permission->display_name = '移除节点角色';
        $permission->group_id = 4;
        $permission->save();

        $permission = Permission::find(7);
        $permission->name = 'project.store';
        $permission->display_name = '编辑项目';
        $permission->group_id = 5;
        $permission->save();

        $permission = Permission::find(8);
        $permission->name = 'project_user.create';
        $permission->display_name = '邀请新成员';
        $permission->group_id = 5;
        $permission->save();

        $permission = Permission::find(9);
        $permission->name = 'project_user.store';
        $permission->display_name = '修改成员的项目角色';
        $permission->group_id = 5;
        $permission->save();

        $permission = Permission::find(10);
        $permission->name = 'project_user.delete';
        $permission->display_name = '踢出成员';
        $permission->group_id = 5;
        $permission->save();

        $permission = Permission::find(11);
        $permission->name = 'project.delete';
        $permission->display_name = '删除项目';
        $permission->group_id = 6;
        $permission->save();
    }
}