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
        $nodes = factory(Node::class)->times(15)->make();
        Node::insert($nodes->toArray());

        $node = Node::find(1);
        $node->project_id = 1;
        $node->parent_id = null;
        $node->name = '数据库课程设计';
        $node->description = '完成数据库课程设计';
        $node->height = 1;
        $node->save();

        $node = Node::find(2);
        $node->project_id = 1;
        $node->parent_id = 1;
        $node->name = '前端模块';
        $node->description = '完成前端页面';
        $node->height = 2;
        $node->save();

        $node = Node::find(3);
        $node->project_id = 1;
        $node->parent_id = 1;
        $node->name = '后端模块';
        $node->description = '完成数据库设计、后台接口';
        $node->height = 2;
        $node->save();

        $node = Node::find(4);
        $node->project_id = 1;
        $node->parent_id = 1;
        $node->name = '文档编写';
        $node->description = '完成用户文档，答辩ppt';
        $node->height = 2;
        $node->save();

        $node = Node::find(5);
        $node->project_id = 1;
        $node->parent_id = 2;
        $node->name = '主页面';
        $node->description = '完成登录后进入的页面';
        $node->height = 3;
        $node->save();

        $node = Node::find(6);
        $node->project_id = 1;
        $node->parent_id = 2;
        $node->name = '树页面';
        $node->description = '任务树展示的页面';
        $node->height = 3;
        $node->save();

        $node = Node::find(7);
        $node->project_id = 1;
        $node->parent_id = 2;
        $node->name = '管理页面';
        $node->description = '项目管理页面';
        $node->height = 3;
        $node->save();

        $node = Node::find(8);
        $node->project_id = 1;
        $node->parent_id = 3;
        $node->name = '数据库设计';
        $node->description = '包括用户、项目、节点、权限、角色等模型';
        $node->height = 3;
        $node->save();

        $node = Node::find(9);
        $node->project_id = 1;
        $node->parent_id = 3;
        $node->name = '用户接口';
        $node->description = '用户的注册、登录、相关信息查询接口';
        $node->height = 3;
        $node->save();

        $node = Node::find(10);
        $node->project_id = 1;
        $node->parent_id = 3;
        $node->name = '项目接口';
        $node->description = '项目的新建、邀请、删除捷库';
        $node->height = 3;
        $node->save();

        $node = Node::find(11);
        $node->project_id = 1;
        $node->parent_id = 3;
        $node->name = '权限接口';
        $node->description = '角色与权限的对应关系，后台操作接口的逻辑权限检验';
        $node->height = 3;
        $node->save();

        $node = Node::find(12);
        $node->project_id = 1;
        $node->parent_id = 3;
        $node->name = '节点接口';
        $node->description = '节点的增加、删除、修改接口';
        $node->height = 3;
        $node->save();

        $node = Node::find(13);
        $node->project_id = 1;
        $node->parent_id = 4;
        $node->name = '用户手册';
        $node->description = '用户使用说明手册';
        $node->height = 3;
        $node->save();

        $node = Node::find(14);
        $node->project_id = 1;
        $node->parent_id = 4;
        $node->name = '答辩ppt';
        $node->description = '课程设计答辩ppt的编写';
        $node->height = 3;
        $node->save();

        $node = Node::find(15);
        $node->project_id = 1;
        $node->parent_id = 4;
        $node->name = '课程设计报告';
        $node->description = '课程设计报告的编写';
        $node->height = 3;
        $node->save();
    }
}