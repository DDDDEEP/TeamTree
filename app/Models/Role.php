<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Project;
use App\Models\Permission;

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
            ->withTimestamps();
    }
}
