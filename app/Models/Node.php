<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Project;
use App\Models\User;
use App\Models\NodeUser;

class Node extends Model
{
    /**
     * 获取该节点的父节点，若是根节点则返回null
     */
    public function parent()
    {
        return $this->belongsTo(Node::class);
    }

    /**
     * 获取该节点对应项目。
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * 获取该节点对应的角色（即节点角色）。
     */
    public function users()
    {
        return $this->belongsToMany(User::Class)
            ->withTimestamps()
            ->using(NodeUser::Class);
    }
}
