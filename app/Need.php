<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Need extends Model
{
    use Categorizable;
    
    // Eager load with the Model
    protected $with= ['categories', 'creator'];   

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
