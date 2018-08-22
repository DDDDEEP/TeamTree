<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Node;

class NodePolicy extends Policy
{
    public function hasNodePermission(User $user, Node $node, $name)
    {
        $mix_role = $user->getNodeRole($node->id);
        return $mix_role ? $mix_role->hasPermission($name) : false;
    }

    public function store(User $user, Node $node)
    {
        return $this->hasNodePermission($user, $node, 'nodes.store');
    }

    public function update(User $user, Node $node)
    {
        return $this->hasNodePermission($user, $node, 'nodes.update');
    }

    public function updateStatus(User $user, Node $node)
    {
        return $this->hasNodePermission($user, $node, 'nodes.update.update_status');
    }

    public function destroy(User $user, Node $node)
    {
        return $this->hasNodePermission($user, $node, 'nodes.destroy');
    }
}