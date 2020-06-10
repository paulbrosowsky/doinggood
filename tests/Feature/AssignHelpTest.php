<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Notifications\HelpWasAssigned;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class AssignHelpTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $help;

    public function setUp():void
    {
        parent::setUp();
    
        $this->user = factory('App\User')->create();

        $need = factory('App\Need')->create(['user_id' => $this->user->id]);
        
        $this->help = factory('App\Help')->create([
            'need_id' => $need->id,
            'state_id' => 1
        ]);
    }
    
    /** @test */
    function unauthorized_users_may_not_assign_help()
    {
        $this->signIn();
        $this->put(route('help.assign', $this->help->id))->assertStatus(403);
    }

    /** @test */
    function needs_owner_may_assign_help()
    {
        $this->signIn($this->user);

        $this->put(route('help.assign', $this->help->id));

        $this->assertEquals($this->help->fresh()->state_id, 2);
    }

    /** @test */
    function help_offerer_recieves_an_email_upon_assingment()
    {
        Notification::fake();
        $this->signIn($this->user);

        $this->put(route('help.assign', $this->help->id));

        Notification::assertSentTo($this->help->user, HelpWasAssigned::class);

    }
}