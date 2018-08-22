<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy extends Policy
{
    public function hasProjectPermission(User $user, Project $project, $name)
    {
        $mix_role = $user->getProjectRole($project->id);
        return $mix_role ? $mix_role->hasPermission($name) : false;
    }

    public function store(User $user, Project $project)
    {
        return $this->hasProjectPermission($user, $project, 'projects.store');
    }

    public function update(User $user, Project $project)
    {
        return $this->hasProjectPermission($user, $project, 'projects.update');
    }

    public function destroy(User $user, Project $project)
    {
        return $this->hasProjectPermission($user, $project, 'projects.destroy');
    }
}