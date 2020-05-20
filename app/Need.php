<?php

namespace App;

use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;

class Need extends Model
{
    use Categorizable, Taggable;
    
    /**
     *  Prevent this Coumns from writing
     */
    protected $guarded = [];
    
    /**
     *  Eager load with the Model
     */ 
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

    /**
     *  Sanitize Project Description
     * 
     * @return text
     */
    public function getProjectDescriptionAttribute($project_description)
    {   

        return \Purify::clean($project_description);
    }
    /**
     *  Sanitize Need Description
     * 
     * @return text
     */
    public function getNeedDescriptionAttribute($need_description)
    {
        return \Purify::clean($need_description);
    }
}
