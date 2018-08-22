<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class MyUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(7)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        $user = User::find(1);
        $user->name = '超管';
        $user->email = 'super@qq.com';
        $user->password = bcrypt('123');
        $user->save();

        $user = User::find(2);
        $user->name = '闲置';
        $user->email = 'free@qq.com';
        $user->password = bcrypt('123');
        $user->save();

        $user = User::find(3);
        $user->name = '项目管理员';
        $user->email = 'project@qq.com';
        $user->password = bcrypt('123');
        $user->save();

        $user = User::find(4);
        $user->name = '在2节点角色为执行者的闲置';
        $user->email = 'node_role_2@qq.com';
        $user->password = bcrypt('123');
        $user->save();

        $user = User::find(5);
        $user->name = '在2节点角色为节点管理员的闲置';
        $user->email = 'node_role_3@qq.com';
        $user->password = bcrypt('123');
        $user->save();

        $user = User::find(6);
        $user->name = '在2节点角色为树管理员的闲置';
        $user->email = 'node_role_4@qq.com';
        $user->password = bcrypt('123');
        $user->save();

        $user = User::find(7);
        $user->name = '无业人士';
        $user->email = 'empty@qq.com';
        $user->password = bcrypt('123');
        $user->save();
    }
}