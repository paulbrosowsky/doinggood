<?php

namespace Tests\Feature;

use App\Notifications\ProfileUnlocked;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class UnlockProfileTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $admin;

    public function setUp():void
    {
        parent::setUp();

        $this->user = factory('App\User')->create();  
        
        $this->admin = factory('App\User')->create([
            'email' => config('doinggood.administrators')[0]
        ]);  
    }
    /** @test */
    function unauthorized_users_may_not_unlock_profiles()
    {
        $this->signIn();      

        $this->patch(route('profile.unlock', $this->user->username))
            ->assertStatus(403);
    }

    /** @test */
    function profile_owners_ma_not_unlock_profiles()
    {
        $this->signIn($this->user);    

        $this->patch(route('profile.unlock', $this->user->username))
            ->assertStatus(403);
    }

    /** @test */
    function only_administrators_may_unlock_profiles()
    {  
        $this->signIn($this->admin);

        $this->patch(route('profile.unlock', $this->user->username));
        $this->assertNotNull($this->user->fresh()->unlocked_at);
    }

    /** @test */
    function profile_unlocked_email_is_sent_upon_unlocking()
    {
        Notification::fake();             

        $this->signIn($this->admin);

        $this->patch(route('profile.unlock', $this->user->username));

        Notification::assertSentTo($this->user, ProfileUnlocked::class);
    }
    
}