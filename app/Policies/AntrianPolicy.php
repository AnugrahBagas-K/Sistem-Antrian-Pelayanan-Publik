<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Antrian;
use Illuminate\Auth\Access\HandlesAuthorization;

class AntrianPolicy
{
    use HandlesAuthorization;

    /**
     * Allow admin and peserta to do everything with Antrian.
     */
    public function before(User $user)
    {
        if ($user->hasRole(['admin', 'peserta'])) {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_antrian');
    }

    public function view(User $user, Antrian $antrian): bool
    {
        return $user->can('view_antrian');
    }

    public function create(User $user): bool
    {
        return $user->can('create_antrian');
    }

    public function update(User $user, Antrian $antrian): bool
    {
        return $user->can('update_antrian');
    }

    public function delete(User $user, Antrian $antrian): bool
    {
        return $user->can('delete_antrian');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_antrian');
    }

    public function forceDelete(User $user, Antrian $antrian): bool
    {
        return $user->can('force_delete_antrian');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_antrian');
    }

    public function restore(User $user, Antrian $antrian): bool
    {
        return $user->can('restore_antrian');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_antrian');
    }

    public function replicate(User $user, Antrian $antrian): bool
    {
        return $user->can('replicate_antrian');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_antrian');
    }
}
