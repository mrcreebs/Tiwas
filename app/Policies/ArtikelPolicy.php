<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Artikel;
use App\Models\User;

class ArtikelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Artikel');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Artikel $artikel): bool
    {
        return $user->checkPermissionTo('view Artikel');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Artikel');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Artikel $artikel): bool
    {
        return $user->checkPermissionTo('update Artikel');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Artikel $artikel): bool
    {
        return $user->checkPermissionTo('delete Artikel');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Artikel $artikel): bool
    {
        return $user->checkPermissionTo('restore Artikel');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Artikel $artikel): bool
    {
        return $user->checkPermissionTo('force-delete Artikel');
    }
}
