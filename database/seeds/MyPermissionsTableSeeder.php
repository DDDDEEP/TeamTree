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
        $permissions = factory(Permission::class)->times(3)->make();
        Permission::insert($permissions->toArray());

        $permission = Permission::find(1);
        $permission->name = 'create';
        $permission->display_name = '新建';
        $permission->save();

        $permission = Permission::find(2);
        $permission->name = 'store';
        $permission->display_name = '编辑';
        $permission->save();

        $permission = Permission::find(3);
        $permission->name = 'show';
        $permission->display_name = '浏览';
        $permission->save();
    }
}