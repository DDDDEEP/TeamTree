<?php

namespace App\Models;

use App\Models\Pivot;
use App\Models\Role;
use App\Models\Permission;

class PermissionRole extends Pivot
{
    protected $relationships = [
        'belongsTo' => ['role', 'permission'],
        'hasMany' => [],
        'belongsToMany' => [],
    ];

    /**
     * 获取对应角色。
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * 获取对应权限。
     */
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
