<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     *  Determine wether the User is Allowed to Update the Profile
     */
    public function update(User $user, User $profile)
    {
        return $user->id === $profile->id;
    }

    /**
     *  Determine Wether the User may Unlock the Profile
     */
    public function unlock(User $user)
    {
        return $this->user->isAdmin;
    }

   
}
