<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    /**
     *  Prevent from Writing this Fields
     */
    protected $guarded = [];

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
}
