<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProjectUser;

class ProjectUserPolicy extends Policy
{
    public function hasProjectUserPermission(User $user, ProjectUser $project_user, $name)
    {
        $project_role = $user->getProjectRole($project_user->project_id);
        return $project_role ? $project_role->hasPermission($name) : false;
    }

    public function store(User $user, ProjectUser $project_user)
    {
        return $this->hasProjectUserPermission($user, $project_user, 'project_user.store');
    }

    public function update(User $user, ProjectUser $project_user)
    {
        return $this->hasProjectUserPermission($user, $project_user, 'project_user.update');
    }

    public function destroy(User $user, ProjectUser $project_user)
    {
        return $this->hasProjectUserPermission($user, $project_user, 'project_user.destroy')
            || $user->id == $project_user->user_id;
    }
}