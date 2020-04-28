<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Need extends Model
{
    protected $with= ['categories', 'creator'];

    /**
     *  A Need Belongs to Many Categories
     * 
     * @return morphToMany
     */
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    /**
     *  A Need Belongs to Many Categories
     * 
     * @return morphToMany
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
