<?php

namespace Tests\Fature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReopenNeedTest extends TestCase
{
    use RefreshDatabase;
    
    protected $user;
    protected $need;

    public function setUp():void
    {
        parent::setUp();
    
        $this->user = factory('App\User')->create();

        $this->need = factory('App\Need')->create([
            'user_id' => $this->user->id,
            'state_id' => 3
        ]);
    }

    /** @test */
    function unauthorized_users_may_not_reopen_needs()
    {
        $this->signIn();
        $this->put(route('need.reopen', $this->need->id))->assertStatus(403);
    }

    /** @test */
    function needs_creators_may_reopen_needs()
    {
        $this->signIn($this->user);

        $this->put(route('need.reopen', $this->need->id));

        $this->assertEquals($this->need->fresh()->state_id, 1);
    }
    
}