<?php

namespace App\Policies;

use App\Need;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NeedPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Need  $need
     * @return mixed
     */
    public function view(User $user, Need $need)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Need  $need
     * @return mixed
     */
    public function update(User $user, Need $need)
    {        
        return $user->id == $need->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Need  $need
     * @return mixed
     */
    public function delete(User $user, Need $need)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Need  $need
     * @return mixed
     */
    public function restore(User $user, Need $need)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Need  $need
     * @return mixed
     */
    public function forceDelete(User $user, Need $need)
    {
        //
    }
}
