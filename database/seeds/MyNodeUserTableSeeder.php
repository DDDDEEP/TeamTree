<?php

use Illuminate\Database\Seeder;
use App\Models\NodeUser;

class MyNodeUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $node_users = factory(NodeUser::class)->times(3)->make();
        NodeUser::insert($node_users->toArray());

        $node_user = NodeUser::find(1);
        $node_user->user_id = 1;
        $node_user->node_id = 1;
        $node_user->role_id = 1;
        $node_user->save();

        $node_user = NodeUser::find(2);
        $node_user->user_id = 1;
        $node_user->node_id = 2;
        $node_user->role_id = 2;
        $node_user->save();

        $node_user = NodeUser::find(3);
        $node_user->user_id = 1;
        $node_user->node_id = 3;
        $node_user->role_id = 3;
        $node_user->save();
    }
}