<?php

namespace App\Policies;

use App\Models\Purchase;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PurchasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->isSuperAdmin() || $user->isPurchase() || $user->isManager()) {
            return true;
        }
    }


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->isSuperAdmin() || $user->isPurchase()) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Purchase $purchase): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
        if ($user->isPurchase()) {
            return $user->id == $purchase->user_id;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Purchase $purchase): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
        if ($user->isPurchase()) {
            return $user->id == $purchase->user_id;
        }
    }
}
