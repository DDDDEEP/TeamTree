<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        /**
         * 根据服务器数据生成的seeder
         */

        /**
         * 自编seeder
         */
        // 独立模型
        $this->call(MyUsersTableSeeder::class);
        $this->call(MyProjectsTableSeeder::class);
        $this->call(MyPermissionsTableSeeder::class);

        // 带有外键值的模型
        $this->call(MyRolesTableSeeder::class);
        $this->call(MyNodesTableSeeder::class);

        // 关系表模型
        $this->call(MyProjectUserTableSeeder::class);
        $this->call(MyPermissionRoleTableSeeder::class);
        $this->call(MyNodeUserTableSeeder::class);


        Model::reguard();
    }
}
