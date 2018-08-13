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
        $users = factory(User::class)->times(5)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        $user = User::find(1);
        $user->name = '超管';
        $user->email = '123@qq.com';
        $user->password = bcrypt('123');
        $user->save();

        $user = User::find(1);
        $user->name = '树真';
        $user->email = '456@qq.com';
        $user->password = bcrypt('456');
        $user->save();

        $user = User::find(1);
        $user->name = '浩龙';
        $user->email = '789@qq.com';
        $user->password = bcrypt('789');
        $user->save();
    }
}