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
        $permissions = factory(Permission::class)->times(12)->make();
        Permission::insert($permissions->toArray());

        $permission = Permission::find(1);
        $permission->name = 'nodes.update.update_status';
        $permission->display_name = '改变节点状态';
        $permission->group_id = 2;
        $permission->save();

        $permission = Permission::find(3);
        $permission->name = 'nodes.update';
        $permission->display_name = '编辑节点';
        $permission->group_id = 3;
        $permission->save();
        
        $permission = Permission::find(2);
        $permission->name = 'nodes.store';
        $permission->display_name = '新增节点';
        $permission->group_id = 3;
        $permission->save();

        $permission = Permission::find(4);
        $permission->name = 'nodes.destroy';
        $permission->display_name = '删除节点';
        $permission->group_id = 3;
        $permission->save();

        $permission = Permission::find(5);
        $permission->name = 'node_user.store';
        $permission->display_name = '新增节点角色记录';
        $permission->group_id = 4;
        $permission->save();

        $permission = Permission::find(6);
        $permission->name = 'node_user.update';
        $permission->display_name = '编辑节点角色记录';
        $permission->group_id = 4;
        $permission->save();

        $permission = Permission::find(7);
        $permission->name = 'node_user.destroy';
        $permission->display_name = '删除节点角色记录';
        $permission->group_id = 4;
        $permission->save();

        $permission = Permission::find(8);
        $permission->name = 'projects.update';
        $permission->display_name = '编辑项目';
        $permission->group_id = 5;
        $permission->save();

        $permission = Permission::find(9);
        $permission->name = 'project_user.store';
        $permission->display_name = '新增项目角色记录（邀请新成员）';
        $permission->group_id = 5;
        $permission->save();

        $permission = Permission::find(10);
        $permission->name = 'project_user.update';
        $permission->display_name = '修改项目角色记录（修改项目角色）';
        $permission->group_id = 5;
        $permission->save();

        $permission = Permission::find(11);
        $permission->name = 'project_user.destroy';
        $permission->display_name = '删除项目角色记录（退出项目）';
        $permission->group_id = 5;
        $permission->save();

        $permission = Permission::find(12);
        $permission->name = 'projects.destroy';
        $permission->display_name = '删除项目';
        $permission->group_id = 6;
        $permission->save();
    }
}