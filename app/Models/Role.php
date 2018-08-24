<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Project;
use App\Models\Permission;
use App\Models\PermissionRole;

class Role extends Model
{
    /**
     * 获取该角色对应项目。
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * 获取该角色对应的权限。
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::Class)
        ->withPivot(['id'])
            ->withTimestamps()
            ->using(PermissionRole::Class);
    }

    /**
     * 判断该角色是否有对应路由的权限
     *
     * @param  string  $route_name  路由名
     * @return boolean
     */
    public function hasPermission($route_name)
    {
        return $this->permissions()
            ->where('name', $route_name)
            ->first() != null;
    }
}
