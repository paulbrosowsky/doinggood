<?php

namespace App;

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
    protected $appends = ['tagNames', 'isAdmin', 'isUnlocked', 'fullyVerified'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'username', 
        'description', 
        'excerpt',
        'helper',
        'web_link',
        'facebook_link',
        'instagram_link',
        'tweeter_link',
        'avatar',
        'unlocked_at',
        'email_verified_at'
    ];

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
        'helper' => 'boolean'
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
}
