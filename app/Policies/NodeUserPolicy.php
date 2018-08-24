<?php

namespace App\Policies;

use App\Models\User;
use App\Models\NodeUser;

class NodeUserPolicy extends Policy
{
    public function hasEditNodeUserPermission(User $user, NodeUser $node_user, $name)
    {
        $this_role = $user->getNodeRole($node_user->node_id);
        $antother_role = $node_user->user->getNodeRole($node_user->node_id);
        return $this_role && $antother_role
            && $this_role->hasPermission($name)
            && $this_role->level > $antother_role->level;
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