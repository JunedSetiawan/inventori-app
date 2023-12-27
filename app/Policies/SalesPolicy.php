<?php

namespace App\Policies;

use App\Models\Sales;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SalesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->isSuperAdmin() || $user->isSales() || $user->isManager()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->isSuperAdmin() || $user->isSales()) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Sales $sales): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isSales()) {
            return $user->id == $sales->user_id;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Sales $sales): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isSales()) {
            return $user->id == $sales->user_id;
        }
    }
}
