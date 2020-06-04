<?php

namespace Tests\Feature;

use App\Need;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewUserProfileTest extends TestCase
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

    /** @test */
    function users_may_view_profile_feed()
    {   
        $this->signIn();
        $state = factory('App\State')->create();
        $need = factory('App\Need')->create([
            'user_id' => $this->user->id , 
            'state_id' => $state->id          
        ]); 

        $response = $this->get(route('profile', $this->user->username));  

        $this->assertEquals($need->title, $response['needs'][$state->name][0]['title']);
    }    
}