<?php

namespace App\Policies;

use App\Help;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HelpPolicy
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
     *  Determine whether the User Can Assing the Help
     * 
     * @param User $user
     * @param Help $help
     * @return  boolean
     */
    public function assign(User $user, Help $help)
    {
        return $user->id === $help->need->creator->id;
    }

    /**
     *  Determine whether the User Can Delete the Help
     * 
     * @param User $user
     * @param Help $help
     * @return  boolean
     */
    public function complete(User $user, Help $help)
    {         
        return $user->id == $help->user_id && $help->completable;
    }

    /**
     *  Determine whether the User Can Delete the Help
     * 
     * @param User $user
     * @param Help $help
     * @return  boolean
     */
    public function delete(User $user, Help $help)
    {        
        return $user->id == $help->user_id;
    }

    /**
     *  Determine whether the User Can Comment the Help
     * 
     * @param User $user
     * @param Help $help
     * @return  boolean
     */
    public function comment(User $user, Help $help)
    {        
        return $user->id == $help->user_id 
                || $user->id == $help->need->creator->id 
                && $help->completed;
    }
}
