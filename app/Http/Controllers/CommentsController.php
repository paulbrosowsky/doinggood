<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Help;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     *  Create a New Comment for the given Help
     * 
     * @param Help $help
     * @param Request $request
     */
    public function store(Help $help, Request $request)
    {
        $this->authorize('comment', $help);    

        $request->validate([
            'body' => ['required']
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'help_id' => $help->id,
            'body' => $request->body
        ]);
    }

    /**
     *  Update the Given Comment
     * 
     * @param Comment $comment
     * @param Request $request
     */
    public function update(Comment $comment, Request $request)
    {        
        if ($comment->user_id != auth()->id()){            
            abort(403, 'Du bist nicht Autoriziert');
        }

        $request->validate([
            'body' => ['required']
        ]);

        $comment->update([
            'body' => $request->body
        ]);        
    }

    /** 
     *  Delete the Give Comment
     * 
     * @param com
     */
    public function destroy(Comment $comment)
    {
        if ($comment->user_id != auth()->id()){            
            abort(403, 'Du bist nicht Autoriziert');
        }

        $comment->delete();
    }
    
}
