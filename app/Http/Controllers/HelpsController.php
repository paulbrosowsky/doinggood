<?php

namespace App\Http\Controllers;

use App\Help;
use App\Need;
use App\Notifications\HelpWasAssigned;
use App\Notifications\HelpWasOffered;
use App\Notifications\HelpWasRejected;
use App\Notifications\HelpWasWithdrawn;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class HelpsController extends Controller
{
    /**
     *  Store an New Help in DB
     *
     * @param Need $need
     * @param Request $request
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

    /**
     *  Update Help as Assigned
     *
     * @param Help $help
     * @throws AuthorizationException
     */
    public function assign(Help $help)
    {
        $this->authorize('assign', $help);

        $help->update([ 'state_id' => 2 ]);

        $help->user->notify(new HelpWasAssigned($help->need));
    }

    /**
     *  Set Help as Completed
     * 
     * @param Help $help
     * @param Request $request
     */
    public function complete(Help $help, Request $request)
    {
        $this->authorize('complete', $help); 

        $request->validate([
            'message' => ['required']
        ]);
        
        $help->complete($request->message);
    }

    /**
     *  Delete Help by Rejecting It
     *
     * @param Help $help
     * @param Request $request
     * @throws AuthorizationException
     */
    public function reject(Help $help, Request $request)
    {
        $this->authorize('assign', $help);

        $request->validate([
            'message' => ['required']
        ]);

        $help->user->notify(new HelpWasRejected( $help->need, $request->message ));

        $help->delete();
    }

    /**
     *  Delete Help by Withdrawing it
     *
     * @param Help $help
     * @param Request $request
     * @throws AuthorizationException
     */
    public function destroy(Help $help, Request $request)
    {
        $this->authorize('delete', $help);

        $request->validate([
            'message' => ['required']
        ]);

        $help->need->creator->notify(new HelpWasWithdrawn( $help, $request->message ));

        $help->delete();
    }


}
