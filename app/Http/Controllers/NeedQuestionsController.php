<?php

namespace App\Http\Controllers;

use App\Need;
use App\Notifications\QuestionAboutNeed;
use Illuminate\Http\Request;

class NeedQuestionsController extends Controller
{
    /**
     *  Ask Question About an Need
     * 
     * @param Need $need
     * @param Request $request
     */
    public function create(Need $need, Request $request)
    {          
        $request->validate([
            'body' => ['required']
        ]);

        $need->creator->notify(new QuestionAboutNeed(
            auth()->user(), 
            $need,
            $request->body
        ));
    }
}
