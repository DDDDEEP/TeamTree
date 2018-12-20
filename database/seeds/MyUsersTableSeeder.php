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
        $user->name = '钟耀铭';
        $user->email = 'zym@qq.com';
        $user->password = bcrypt('123456');
        $user->save();

        $user = User::find(2);
        $user->name = '黄振邦';
        $user->email = 'free@qq.com';
        $user->password = bcrypt('123456');
        $user->save();

        $user = User::find(3);
        $user->name = '姚旭真';
        $user->email = 'yxz@qq.com';
        $user->password = bcrypt('123456');
        $user->save();

        $user = User::find(4);
        $user->name = '张文瀚';
        $user->email = 'zwh@qq.com';
        $user->password = bcrypt('123456');
        $user->save();

        $user = User::find(5);
        $user->name = '张志洋';
        $user->email = 'zzy@qq.com';
        $user->password = bcrypt('123456');
        $user->save();

        $user = User::find(6);
        $user->name = '梁高飞';
        $user->email = 'lgf@qq.com';
        $user->password = bcrypt('123456');
        $user->save();
    }
}