<?php

use Illuminate\Database\Seeder;
use App\Models\PermissionRole;
use App\Models\Permission;
use App\Models\Role;

class MyPermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 2; $i <= 6; ++$i) {
            $permission_ids = Permission::where('group_id', $i)->get()->pluck('id')->toArray();
            $role = Role::where('project_id', null)->where('level', $i)->first();
            $role->permissions()->attach($permission_ids);
        }
    }
}