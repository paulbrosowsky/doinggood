<?php

namespace App\Http\Controllers;

use App\Need;
use App\Notifications\HelpWasOffered;
use Illuminate\Http\Request;

class HelpsController extends Controller
{
    /**
     *  Store an New Help in DB
     * 
     * @param Need $need
     * @param Request $need 
     */
    public function store(Need $need, Request $request)
    {
        $request->validate([
            'message' => ['required']
        ]);

        $need->helps()->create([
            'user_id' => auth()->id(),            
        ]);

        $need->creator->notify(new HelpWasOffered(
            auth()->user(),
            $need,
            $request->message           
        ));
    }
}
