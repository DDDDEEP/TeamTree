<?php

namespace App\Models;

use App\Models\Common\Pivot;

class PermissionRole extends Pivot
{
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
