<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Businessposition;
use App\Models\User;

class BusinesspositionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Businessposition');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Businessposition $businessposition): bool
    {
        return $user->checkPermissionTo('view Businessposition');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Businessposition');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Businessposition $businessposition): bool
    {
        return $user->checkPermissionTo('update Businessposition');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Businessposition $businessposition): bool
    {
        return $user->checkPermissionTo('delete Businessposition');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Businessposition $businessposition): bool
    {
        return $user->checkPermissionTo('restore Businessposition');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Businessposition $businessposition): bool
    {
        return $user->checkPermissionTo('force-delete Businessposition');
    }
}
