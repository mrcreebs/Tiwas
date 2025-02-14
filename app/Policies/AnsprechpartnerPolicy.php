<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Ansprechpartner;
use App\Models\User;

class AnsprechpartnerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Ansprechpartner');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ansprechpartner $ansprechpartner): bool
    {
        return $user->checkPermissionTo('view Ansprechpartner');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Ansprechpartner');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ansprechpartner $ansprechpartner): bool
    {
        return $user->checkPermissionTo('update Ansprechpartner');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ansprechpartner $ansprechpartner): bool
    {
        return $user->checkPermissionTo('delete Ansprechpartner');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ansprechpartner $ansprechpartner): bool
    {
        return $user->checkPermissionTo('restore Ansprechpartner');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ansprechpartner $ansprechpartner): bool
    {
        return $user->checkPermissionTo('force-delete Ansprechpartner');
    }
}
