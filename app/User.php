<?php

namespace App;

use App\Notifications\ConfirmYourEmail;
use App\Notifications\ResetPassword;
use Conner\Tagging\Taggable;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, Taggable, Categorizable;

    protected static function boot()
    {
        parent::boot();

        static::created(function($user){            
            $username = Str::slug($user->name, '_');       
            
            if (static::whereUsername($username)->exists()) {
                $username = "{$username}_" . $user->id;
            }               
            $user->update(['username' => $username]);                   
        });
    }

    /**
     *  Eager Load with the User Model
     */
    protected $with = ['categories'];

    /**
     *  Append to the User Model 
     */
    protected $appends = [
        'tagNames', 
        'isAdmin', 
        'isUnlocked', 
        'fullyVerified', 
        'settingsCompleted'
    ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'helper' => 'boolean',
        'enable_matching' => 'boolean'
    ];

    /**
     * Overwrite route key of the Model (ID by default)
     */
    public function getRouteKeyName()
    {
        return 'username';
    }   

    /**
     * Get the Proper Avatar Path
     * 
     * @return string
     */
    public function getAvatarAttribute($avatar)
    {          
        if(Storage::disk('public')->exists($avatar)){        
            return Storage::url($avatar);
        }
       return Storage::url('assets/default_avatar.png'); 
    }
    
    /**
     *  Determine if The User is an Administrator
     *  
     * @return boolean
     */
    public function getIsAdminAttribute()
    {
        return in_array(
            strtolower($this->email),
            array_map('strtolower', config('doinggood.administrators'))
        );
    }

    /**
     *  Determine if The User Profile is Unlocked
     * 
     * @return boolean
     */
    public function getIsUnlockedAttribute()
    {
        return isset($this->unlocked_at);
    }


    /**
     * Determine if User is Fully Verified
     * 
     * @return boolean
     */
    public function getFullyVerifiedAttribute()
    {
        return $this->isUnlocked && $this->hasVerifiedEmail();
    } 

    public function getSettingsCompletedAttribute()
    {
        if ($this->helper) {
            return $this->categories->isNotEmpty() 
                        && $this->tags->isNotEmpty()
                        && $this->location
                        && $this->activity_area;
        }

        return  $this->tags->isNotEmpty();
    }
    
    /**
     * A User has Many Needs
     * @return hasMany 
     */
    public function needs()
    {
        return $this->hasMany(Need::class);
    }

    /**
     * A User has many Helps
     * @return hasMany 
     */
    public function helps()
    {
        return $this->hasMany(Help::class);
    }

     /**
     *  Sanitize Description
     * 
     * @return text
     */
    public function getDescriptionAttribute($description)
    {
        return \Purify::clean($description);
    }
    
    /**
     *  Get User Profile Feed
     * 
     * @return Collection 
     */
    public function feed()
    {        
        if($this->helper){  

            return $this->helps()
                    ->with('need')
                    ->get()
                    ->sortDesc()
                    ->groupBy('state.name')
                    ->sortBy(function($query){
                        return $query->first()->state_id;
                    }); 
        }

        return $this->needs
                ->sortDesc()
                ->groupBy('state.name')
                ->sortBy(function($query){
                    return $query->first()->state_id;
                });  
    }

    /** 
     *  Get Profile Feed Counter
     * 
     * @return array
     */
    public function getFeedCounterAttribute()
    {
        if ($this->helper) {
            $completedHelps = $this->helps->where('state_id', 3)->count();
            return [
                'active' => $this->helps->count() - $completedHelps,
                'completed' =>  $completedHelps,
                'total' => $this->helps->count()                           
            ];
        }

        $completedNeeds = $this->needs->where('state_id', 3)->count();
        return [
            'active' => $this->needs->count() - $completedNeeds,
            'completed' =>  $completedNeeds ,
            'total' => $this->needs->count()                            
        ];
    }

    /**
     * Get Date of User Last Activity
     *
     * @return void
     */
    public function getLastActivityStampAttribute()
    {
        $dates = collect();
        $dates->push($this->updated_at);

        if ($this->helper) {
            $lastHelp =  $this->helps()->orderBy('updated_at', 'DESC')->first();
            if (isset($lastHelp)) {
                $dates->push($lastHelp->updated_at);
            }
        } else {
            $lastNeed = $this->needs()->orderBy('updated_at', 'DESC')->first()->updated_at;
            if (isset($lastNeed)) {
                $dates->push($lastNeed);
            }
    
            $needIds = $this->needs->pluck('id')->toArray();
            $lastHelp = Help::whereIn('need_id', $needIds)
                        ->whereIn('state_id', [2,3])
                        ->orderBy('updated_at', 'DESC')
                        ->first();

            if (isset($lastHelp)) {
                $dates->push($lastHelp->updated_at);
            }
        }

        return $dates->max()->format('d.m.Y');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new ConfirmYourEmail());
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
