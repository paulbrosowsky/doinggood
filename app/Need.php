<?php

namespace App;

use DateTime;
use Carbon\Carbon;
use Conner\Tagging\Taggable;
use Laravel\Scout\Searchable;
use App\Exceptions\NeedNotAssignable;
use App\Exceptions\NeedNotCompletable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Need extends Model
{
    use Categorizable, Taggable, Searchable;
    
    /**
     *  Prevent this Coumns from writing
     */
    protected $guarded = [];
    
    /**
     *  Eager load with the Model
     */ 
    protected $with= ['categories', 'creator', 'state']; 
    
     /**
     *  Append to the User Model 
     */
    protected $appends = ['tagNames', 'owner'];    

    /**
     *  A Need Belongs to Many Categories
     * 
     * @return belogsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     *  A Need has many Help Offers
     * 
     *  @return hasMany
     */
    public function helps()
    {
        return $this->hasMany(Help::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
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

    /**
     *  Determine if Auth User is Owner of the Need
     * 
     * @return boolean
     */
    public function getOwnerAttribute()
    {
        return $this->creator->id === auth()->id();
    }

    /**
     *  Determine if the Need is Assigned
     * 
     * @return boolean
     */
    public function getAssignedAttribute()
    {
        return $this->state_id == 2;
    }

    /**
     *  Detemine whether the Need in Assignable
     * 
     * @return boolean
     */
    public function getAssignableAttribute()
    {
        // Determine whether the Need has Assgned or Completed Helps
        return ! $this->helps->whereIn('state_id', [2,3])->isEmpty() && !$this->completed;
    }

    /**
     *  Set Need as Assigned
     * 
     * @return boolean
     */
    public function assign()
    {        
        if (!$this->assignable) {
            throw new NeedNotAssignable('Der Bedarf hat keine vermittelte oder abgeschlossene Hilfen.');
        }

        return $this->update(['state_id' => 2]);
    }

    /**
     *  Determine if the Need is Completed
     * 
     * @return boolean
     */
    public function getCompletedAttribute()
    {
        return $this->state_id == 3;
    }

    /**
     *  Detemine whether the Need in Completable
     * 
     * @return boolean
     */
    public function getCompletableAttribute()
    {
        // Determine whether the Need is Assgned and All Helps are Completed
        return $this->helps->whereIn('state_id', [1,2])->isEmpty() && $this->assigned;
    }

    /**
     *  Set Need as Completed
     * 
     * @return boolean
     */
    public function complete()
    {        
        if (!$this->completable) {
            throw new NeedNotCompletable('Der Bedarf darf nicht abgeschlossen werden');
        }

        return $this->update(['state_id' => 3]);
    }

    /**
     *  Define Searcheble Fields
     *  @return array
     */
    public function toSearchableArray()
    {
        $array = $this->only(
            'id',
            'title',
            'title_image',
            'state',
            'created_at'          
        );

        $array['categories'] = $this->categories->map(function($category){
            return $category->only('name', 'color', 'icon');
        })->toArray();

        $array['tags'] = $this->tagNames;

        return $array;
    }

}
