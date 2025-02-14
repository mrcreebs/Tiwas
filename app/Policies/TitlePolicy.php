<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Title;
use App\Models\User;

class TitlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Title');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Title $title): bool
    {
        return $user->checkPermissionTo('view Title');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Title');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Title $title): bool
    {
        return $user->checkPermissionTo('update Title');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Title $title): bool
    {
        return $user->checkPermissionTo('delete Title');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Title $title): bool
    {
        return $user->checkPermissionTo('restore Title');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Title $title): bool
    {
        return $user->checkPermissionTo('force-delete Title');
    }
}
