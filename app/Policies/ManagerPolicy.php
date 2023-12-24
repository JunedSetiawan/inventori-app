<?php

namespace App\Policies;

use App\Models\User;

class ManagerPolicy
{
    /**
     * Create a new policy instance.
     */
    public function print_report(User $user): bool
    {
        return $user->isManager();
    }
}
