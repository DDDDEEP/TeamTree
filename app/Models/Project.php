<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Node;
use App\Models\Role;
use App\Models\User;

class Project extends Model
{
    /**
     * 获取该项目的所有节点
     */
    public function nodes()
    {
        return $this->hasMany(Node::Class);
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
