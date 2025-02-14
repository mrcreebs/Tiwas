<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Angebot;
use App\Models\User;

class AngebotPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Angebot');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Angebot $angebot): bool
    {
        return $user->checkPermissionTo('view Angebot');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Angebot');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Angebot $angebot): bool
    {
        return $user->checkPermissionTo('update Angebot');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Angebot $angebot): bool
    {
        return $user->checkPermissionTo('delete Angebot');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Angebot $angebot): bool
    {
        return $user->checkPermissionTo('restore Angebot');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Angebot $angebot): bool
    {
        return $user->checkPermissionTo('force-delete Angebot');
    }
}
