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
        $nodes = factory(Node::class)->times(14)->make();
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
        $node->name = '前端模块';
        $node->height = 2;
        $node->save();

        $node = Node::find(3);
        $node->project_id = 1;
        $node->parent_id = 1;
        $node->name = '后端模块';
        $node->height = 2;
        $node->save();

        $node = Node::find(4);
        $node->project_id = 1;
        $node->parent_id = 1;
        $node->name = '文档编写';
        $node->height = 2;
        $node->save();

        $node = Node::find(5);
        $node->project_id = 1;
        $node->parent_id = 2;
        $node->name = '主页面';
        $node->height = 3;
        $node->save();

        $node = Node::find(6);
        $node->project_id = 1;
        $node->parent_id = 2;
        $node->name = '树页面';
        $node->height = 3;
        $node->save();

        $node = Node::find(7);
        $node->project_id = 1;
        $node->parent_id = 2;
        $node->name = '管理页面';
        $node->height = 3;
        $node->save();

        $node = Node::find(8);
        $node->project_id = 1;
        $node->parent_id = 3;
        $node->name = '数据库设计';
        $node->height = 3;
        $node->save();

        $node = Node::find(9);
        $node->project_id = 1;
        $node->parent_id = 3;
        $node->name = '用户接口';
        $node->height = 3;
        $node->save();

        $node = Node::find(10);
        $node->project_id = 1;
        $node->parent_id = 3;
        $node->name = '项目接口';
        $node->height = 3;
        $node->save();

        $node = Node::find(11);
        $node->project_id = 1;
        $node->parent_id = 3;
        $node->name = '权限接口';
        $node->height = 3;
        $node->save();

        $node = Node::find(12);
        $node->project_id = 1;
        $node->parent_id = 3;
        $node->name = '节点接口';
        $node->height = 3;
        $node->save();

        $node = Node::find(13);
        $node->project_id = 1;
        $node->parent_id = 4;
        $node->name = '用户手册';
        $node->height = 3;
        $node->save();

        $node = Node::find(14);
        $node->project_id = 1;
        $node->parent_id = 4;
        $node->name = '答辩ppt';
        $node->height = 3;
        $node->save();
    }
}