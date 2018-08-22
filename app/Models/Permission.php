<?php

namespace App\Models;

use App\Models\Model;
use App\Models\PermissionRole;
use App\Models\Role;

class Permission extends Model
{
    protected $relationships = [
        'belongsTo' => [],
        'hasMany' => [],
        'belongsToMany' => ['roles'],
    ];

    /**
     * 获取该权限对应的角色。
     */
    public function roles()
    {
        return $this->belongsToMany(Role::Class)
            ->withPivot(['id'])
            ->withTimestamps()
            ->using(PermissionRole::Class);
    }
}
