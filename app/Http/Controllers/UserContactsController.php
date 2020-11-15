<?php

namespace App\Http\Controllers;

use App\Need;
use App\Notifications\UserContact;
use App\User;
use Illuminate\Http\Request;

class UserContactsController extends Controller
{
    /**
     *  Contact Users
     * 
     * @param Need $need
     * @param Request $request
     */
    public function create(Need $need, User $user, Request $request)
    {          
        $request->validate([
            'body' => ['required']
        ]);

        $user->notify(new UserContact(
            auth()->user(), 
            $need,
            $request->body
        ));
    }
}
