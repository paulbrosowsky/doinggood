<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAccountsController extends Controller
{   
    
    /**
     *  Update User Email 
     * 
     * @param Request $request
     */
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
        ]);        

        auth()->user()->update([
            'email' => $request->email,
            'email_verified_at' => NULL           
        ]);

        auth()->user()->notify(new VerifyEmail);
    }

    /**
     *  Update Password
     * 
     * @param Request $request
     */
    public function updatePassword(Request $request)
    {
        $request->validate([            
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);  

        auth()->user()->update([            
            'password' => Hash::make($request->password),
        ]); 
    }

    /**
     *  Delete User Account from DB
     */
    public function destroy()
    {   
        $user = User::where('id', auth()->id())->first();       

        Auth::logout();
        
        if ($user->delete()) {
            return response()->json('Dein Benuzerkonto wurde gelöscht, Schade. Wir hoffen dich bald wieder zusehen.', 200);            
        }        
    }
}
