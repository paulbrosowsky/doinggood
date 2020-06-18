<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     *  Prevent this Columns from Writing
     */
    protected $guarded = [];

    /**
     *  A Comment Blongs to a User
     * 
     * @return belongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
