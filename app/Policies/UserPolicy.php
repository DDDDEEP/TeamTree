<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy extends Policy
{
    public function update(User $user, User $operate_user)
    {
        return $user->id == $operate_user->id;
    }
}