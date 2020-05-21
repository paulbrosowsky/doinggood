<?php

namespace App;

use Carbon\Carbon;
use Conner\Tagging\Taggable;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
     *  Append to the User Model 
     */
    protected $appends = ['tagNames'];

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
     * Get the Proper Title Image Path
     * 
     * @return string
     */
    public function getTitleImageAttribute($title_image)
    {    
        if(Storage::disk('public')->exists($title_image)){        
            return Storage::url($title_image);
        }
       return Storage::url('assets/default_need.png'); 
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

    /**
     *  Get Dedline in ISO8601 Format
     * 
     * @param DateTime $deadline
     * @return string
     */
    public function getDeadlineAttribute($deadline)
    {
        return Carbon::parse($deadline)->format('c');
    }

}
