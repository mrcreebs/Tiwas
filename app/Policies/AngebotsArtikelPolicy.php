<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\AngebotsArtikel;
use App\Models\User;

class AngebotsArtikelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any AngebotsArtikel');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AngebotsArtikel $angebotsartikel): bool
    {
        return $user->checkPermissionTo('view AngebotsArtikel');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create AngebotsArtikel');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AngebotsArtikel $angebotsartikel): bool
    {
        return $user->checkPermissionTo('update AngebotsArtikel');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AngebotsArtikel $angebotsartikel): bool
    {
        return $user->checkPermissionTo('delete AngebotsArtikel');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AngebotsArtikel $angebotsartikel): bool
    {
        return $user->checkPermissionTo('restore AngebotsArtikel');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AngebotsArtikel $angebotsartikel): bool
    {
        return $user->checkPermissionTo('force-delete AngebotsArtikel');
    }
}
