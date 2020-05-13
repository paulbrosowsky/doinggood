<?php

namespace App\Http\Controllers;

use App\Notifications\ProfileUnlocked;
use App\User;
use Illuminate\Http\Request;

class UnlockProfilesController extends Controller
{
    /**
     *  Set Profile as Unloked
     * 
     * @param User $user
     */
    public function update(User $user)
    {
        $this->authorize('unlock');        
        
        $user->update([
            'unlocked_at' => now()
        ]);

        $user->notify(new ProfileUnlocked());

        return redirect(route('profile', $user->username))->with('flash', 'Profil ist freigeschaltet');
    }
}
