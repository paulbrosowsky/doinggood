<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewUserProfile extends TestCase
{
    use RefreshDatabase;
    
    protected $user;

    public function setUp():void
    {
        parent::setUp();

        $this->user = factory('App\User')->create();
    }
    
    /** @test */
    function guests_may_not_view_profiles()
    {       
        $this->get(route('profile', $this->user->username))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /** @test */
    function authenticated_users_may_view_profiles()
    {        
        $this->signIn();

        $this->get(route('profile', $this->user->username))
            ->assertSee($this->user->name);
    }
}