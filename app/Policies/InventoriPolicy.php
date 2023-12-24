<?php

namespace App\Policies;

use App\Models\Inventori;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InventoriPolicy
{

    public function before(User $user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return Response::deny('You are not allowed to do this.');
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->isSuperAdmin() || $user->isManager()) {
            return true;
        }
    }


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Inventori $inventori): bool
    {
        if ($user->isSuperAdmin()) {
            return $user->id == $inventori->user_id;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Inventori $inventori): bool
    {
        if ($user->isSuperAdmin()) {
            return $user->id == $inventori->user_id;
        }
    }
}
