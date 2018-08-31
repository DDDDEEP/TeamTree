<?php

namespace App\Models;

use App\Models\Common\Model;

class Permission extends Model
{
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
