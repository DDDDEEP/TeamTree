<?php

use Illuminate\Database\Seeder;
use App\Models\PermissionRole;

class MyPermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_roles = factory(PermissionRole::class)->times(3)->make();
        PermissionRole::insert($permission_roles->toArray());

        $permission_role = PermissionRole::find(1);
        $permission_role->role_id = 1;
        $permission_role->permission_id = 1;
        $permission_role->save();

        $permission_role = PermissionRole::find(2);
        $permission_role->role_id = 1;
        $permission_role->permission_id = 2;
        $permission_role->save();

        $permission_role = PermissionRole::find(3);
        $permission_role->role_id = 1;
        $permission_role->permission_id = 3;
        $permission_role->save();
    }
}