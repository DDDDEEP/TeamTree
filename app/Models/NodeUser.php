<?php

namespace App\Models;

use App\Models\Pivot;
use App\Models\User;
use App\Models\Node;
use App\Models\Role;

class NodeUser extends Pivot
{
    protected $relationships = [
        'belongsTo' => ['user', 'node', 'role'],
        'hasMany' => [],
        'belongsToMany' => [],
    ];

    /**
     * 获取该身份对应用户。
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 获取该身份对应节点。
     */
    public function node()
    {
        return $this->belongsTo(Node::class);
    }

    /**
     * 获取该身份对应角色。
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
