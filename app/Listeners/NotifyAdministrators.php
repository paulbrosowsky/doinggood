<?php

namespace App\Listeners;

use App\Notifications\UnlockProfile;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdministrators
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {        
        $administrators = config('doinggood.administrators');
       
        array_map(function($email) use ($event){  
            $notify =  User::where('email', $email)->first();          
             
            if(isset($notify)){
                $notify->notify(new UnlockProfile($event->user));  
            }            
                           
        }, $administrators); 
    }
}
