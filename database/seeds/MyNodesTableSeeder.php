<?php

use Illuminate\Database\Seeder;
use App\Models\Node;

class MyNodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nodes = factory(Node::class)->times(5)->make();
        Node::insert($nodes->toArray());

        $node = Node::find(1);
        $node->project_id = 1;
        $node->parent_id = null;
        $node->height = 1;
        $node->save();

        $node = Node::find(2);
        $node->project_id = 1;
        $node->parent_id = 1;
        $node->height = 2;
        $node->save();

        $node = Node::find(3);
        $node->project_id = 1;
        $node->parent_id = 1;
        $node->height = 2;
        $node->save();

        $node = Node::find(4);
        $node->project_id = 1;
        $node->parent_id = 2;
        $node->height = 3;
        $node->save();

        $node = Node::find(5);
        $node->project_id = 1;
        $node->parent_id = 2;
        $node->height = 3;
        $node->save();
    }
}