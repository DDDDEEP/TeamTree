<?php

namespace App\Models;

use App\Models\Pivot;
use App\Models\Project;
use App\Models\User;
use App\Models\Role;

class ProjectUser extends Pivot
{
    /**
     * 获取对应项目。
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * 获取对应用户。
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 获取对应全局角色。
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
