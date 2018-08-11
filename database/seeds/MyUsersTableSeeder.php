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
        $user->name = 'admin';
        $user->email = 'admin@163.com';
        $user->password = bcrypt('admin');
        $user->save();
    }
}