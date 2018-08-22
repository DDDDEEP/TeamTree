<?php

namespace App\Policies;

use App\Models\User;
use App\Models\NodeUser;

class NodeUserPolicy extends Policy
{
    public function hasEditNodeUserPermission(User $user, NodeUser $node_user, $name)
    {
        $mix_role = $user->getNodeRole($node_user->node_id);
        $is_higher = $user->isHigherThan(
            $node_user->user_id,
            $node_user->node()->first()->project_id,
            $node_user->node_id
        );
        return $mix_role != null && $is_higher != null ?
            $mix_role->hasPermission($name) && $is_higher: false;
    }

    public function store(User $user, NodeUser $node_user)
    {
        return $this->hasEditNodeUserPermission($user, $node_user, 'node_user.store');
    }

    public function update(User $user, NodeUser $node_user)
    {
        return $this->hasEditNodeUserPermission($user, $node_user, 'node_user.update');
    }

    public function destroy(User $user, NodeUser $node_user)
    {
        return $this->hasEditNodeUserPermission($user, $node_user, 'node_user.destroy');
    }
}