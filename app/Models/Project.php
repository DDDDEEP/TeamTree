<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Node;
use App\Models\User;

class Project extends Model
{
    /**
     * 获取该项目的所有节点。
     */
    public function nodes()
    {
        return $this->hasMany(Node::Class);
    }

    /**
     * 获取该项目的所有用户。
     */
    public function users()
    {
        return $this->belongsToMany(User::Class)
            ->withTimestamps();
    }
}
