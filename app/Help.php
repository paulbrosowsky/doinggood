<?php

namespace App;

use App\Notifications\HelpWasCompleted;
use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    /**
     *  Prevent from Writing this Fields
     */
    protected $guarded = [];

    protected $appends = ['owner'];

    /**
     *  Eager load with the Help Model
     */
    protected $with = ['comments'];

    /**
     *  Help Belongs to User
     * 
     * @return belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     /**
     *  Help Belongs to State
     * 
     * @return belongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

     /**
     *  Help Belongs to Need
     * 
     * @return belongsTo
     */
    public function need()
    {
        return $this->belongsTo(Need::class);
    }

    /**
     *  Help has many comments
     * @return hasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

     /**
     *  Determine if Auth User is Owner of the Help
     * 
     * @return boolean
     */
    public function getOwnerAttribute()
    {
        return $this->user_id === auth()->id();
    }

    /**
     *  Determine if Help is Comleted
     * 
     * @return boolean
     */
    public function getCompletedAttribute()
    {
        return $this->state_id == 3;
    }

    /**
     *  Determine if Help is Comletables
     * 
     * @return boolean
     */
    public function getCompletableAttribute()
    {
        return $this->state_id == 2;
    }   

    /**
     *  Set Help as Completed  
     * 
     * @param text $message   
     */
    public function complete($message)
    {        
        $this->update(['state_id' => 3]);

        $this->need->creator->notify(new HelpWasCompleted($this, $message));
        $this->user->notify(new HelpWasCompleted($this, $message));

        Comment::create([
            'user_id' => auth()->id(),
            'help_id' => $this->id,
            'body' => $message
        ]);
    }



}
