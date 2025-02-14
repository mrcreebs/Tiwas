<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Vorgang;
use App\Models\User;

class VorgangPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Vorgang');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Vorgang $vorgang): bool
    {
        return $user->checkPermissionTo('view Vorgang');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Vorgang');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Vorgang $vorgang): bool
    {
        return $user->checkPermissionTo('update Vorgang');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Vorgang $vorgang): bool
    {
        return $user->checkPermissionTo('delete Vorgang');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Vorgang $vorgang): bool
    {
        return $user->checkPermissionTo('restore Vorgang');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Vorgang $vorgang): bool
    {
        return $user->checkPermissionTo('force-delete Vorgang');
    }
}
