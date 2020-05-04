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
     *  Determine whether the User is Allowed to Update the Profile
     */
    public function update(User $user, User $profile)
    {
        return $user->id === $profile->id;
    }
}
