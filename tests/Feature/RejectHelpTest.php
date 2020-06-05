<?php

namespace Tests\Feature ;

use App\Notifications\HelpWasRejected;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class RejectHelpTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $help;

    public function setUp():void
    {
        parent::setUp();
    
        $this->user = factory('App\User')->create();

        $this->help = factory('App\Help')->create([
            'need_id' => factory('App\Need')->create([
                'user_id' => $this->user->id
            ])->id           
        ]);
    }
    
    /** @test */
    function unauthorized_users_may_not_reject_help()
    {
        $this->signIn();

        $this->put(route('help.reject', $this->help->id))->assertStatus(403);
    }

    /** @test */
    function need_owners_may_reject_help()
    {
        $this->signIn($this->user);

        $this->put(route('help.reject', $this->help->id), ['message' => 'Reject']);

        $this->assertDatabaseMissing('helps', ['id' => $this->help->id]);
    }

    /** @test */
    function help_creator_receives_email_upon_rejectin_help()
    {
        $this->signIn($this->user);
        Notification::fake();

        $this->put(route('help.reject', $this->help->id), ['message' => 'Reject']);

        Notification::assertSentTo($this->help->user, HelpWasRejected::class);
    }

    /** @test */
    function message_is_required()
    {
        $this->signIn($this->user);

        $this->put(route('help.reject', $this->help->id), ['message' => ''])
            ->assertSessionHasErrors('message');
    }
    
}