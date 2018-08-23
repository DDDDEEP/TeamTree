<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Node;
use App\Models\Role;
use App\Models\User;

class Project extends Model
{
    protected $relationships = [
        'belongsTo' => [],
        'hasMany' => ['nodes', 'roles'],
        'belongsToMany' => ['users'],
    ];

    /**
     * 获取该项目的所有节点
     */
    public function nodes()
    {
        return $this->hasMany(Node::Class);
    }

    /**
     * 获取该项目的根节点
     */
    public function root()
    {
        return $this->nodes()
            ->where('parent_id', null)
            ->first();
    }

    /**
     * 获取该项目的所有用户
     */
    public function users()
    {
        return $this->belongsToMany(User::Class)
            ->withPivot(['id', 'role_id', 'status'])
            ->withTimestamps()
            ->using(ProjectUser::Class);
    }

    /**
     * 获取该项目的所有自定义角色
     */
    public function roles()
    {
        return $this->hasMany(Role::Class);
    }

    /**
     * 获取该项目对应的树结构
     */
    public function getTree()
    {
        $tree = $this->root();
        $root = &$tree;
        $traversal_queue = [$root];
        while (count($traversal_queue) != 0) {
            $node = array_shift($traversal_queue);
            $node->load(['children', 'users']);
            foreach ($node->children as &$child) {
                array_push($traversal_queue, $child);
            }
        }
        return $tree;
    }

    /**
     * 删除该项目相关的所有记录
     */
    public function deleteAll()
    {
        foreach ($this->nodes as $node) {
            $node->users()->detach();
        }
        $this->nodes()->delete();
        $this->roles()->delete();
        $this->users()->detach();
        $this->delete();
    }
}
