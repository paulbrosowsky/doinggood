<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserAvatarsController extends Controller
{
    /**
     *  Update User Avatar
     * 
     * @param User $user
     * @param Request $request
     */
    public function update(User $user, Request $request)
    {  
        $request->validate([            
            'image' => ['required', 'image', 'max:8000'], // max. size 8 MB     
        ]);
      
        //Delete Previous Avatars
        if(Storage::disk('public')->exists( $user->getRawOriginal('avatar') )){            
            Storage::disk('public')->delete( $user->getRawOriginal('avatar') );
            $user->update(['avatar' => NULL]);
        }       
        
        auth()->user()->update([
            'avatar' => $request->file('image')->store('assets/avatars', 'public')
        ]); 
    }
}
