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
        $nodes = factory(Node::class)->times(7)->make();
        Node::insert($nodes->toArray());

        $node = Node::find(1);
        $node->project_id = 1;
        $node->parent_id = null;
        $node->name = '根节点';
        $node->height = 1;
        $node->save();

        $node = Node::find(2);
        $node->project_id = 1;
        $node->parent_id = 1;
        $node->name = '有节点角色的子节点';
        $node->height = 2;
        $node->save();

        $node = Node::find(3);
        $node->project_id = 1;
        $node->parent_id = 1;
        $node->name = '子节点';
        $node->height = 2;
        $node->save();

        $node = Node::find(4);
        $node->project_id = 1;
        $node->parent_id = 2;
        $node->name = '树叶';
        $node->height = 3;
        $node->save();

        $node = Node::find(5);
        $node->project_id = 1;
        $node->parent_id = 2;
        $node->name = '树叶';
        $node->height = 3;
        $node->save();

        $node = Node::find(6);
        $node->project_id = 2;
        $node->parent_id = null;
        $node->name = '根节点';
        $node->height = 1;
        $node->save();

        $node = Node::find(7);
        $node->project_id = 3;
        $node->parent_id = null;
        $node->name = '根节点';
        $node->height = 1;
        $node->save();
    }
}