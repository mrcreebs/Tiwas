<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Kunde;
use App\Models\User;

class KundePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Kunde');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Kunde $kunde): bool
    {
        return $user->checkPermissionTo('view Kunde');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Kunde');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Kunde $kunde): bool
    {
        return $user->checkPermissionTo('update Kunde');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Kunde $kunde): bool
    {
        return $user->checkPermissionTo('delete Kunde');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Kunde $kunde): bool
    {
        return $user->checkPermissionTo('restore Kunde');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Kunde $kunde): bool
    {
        return $user->checkPermissionTo('force-delete Kunde');
    }
}
