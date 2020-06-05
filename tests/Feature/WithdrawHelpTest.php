<?php

namespace Tests\Feature;

use App\Notifications\HelpWasWithdrawn;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class WithdrawHelpTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $help;

    public function setUp():void
    {
        parent::setUp();
    
        $this->user = factory('App\User')->create(['helper' => true]);

        $this->help = factory('App\Help')->create([
            'user_id'=> $this->user->id          
        ]);

        Notification::fake();
    }

    /** @test */
    function unauthorized_users_may_not_reject_help()
    {
        $this->signIn(factory('App\User')->create(['helper' => true]));        

        $this->delete(route('help.destroy', $this->help->id))->assertStatus(403);
    }

    /** @test */
    function help_creator_may_withdraw_help()
    {        
        $this->signIn($this->user);

        $this->delete(route('help.destroy', $this->help->id), ['message' => 'Withdraw']);

        $this->assertDatabaseMissing('helps', ['id' => $this->help->id]);
    }

     /** @test */
    function help_creator_receives_email_upon_rejectin_help()
    {       
        $this->signIn($this->user);
        Notification::fake();

        $this->delete(route('help.destroy', $this->help->id), ['message' => 'Withdraw']);

        Notification::assertSentTo($this->help->need->creator, HelpWasWithdrawn::class);
    }

    /** @test */
    function message_is_required()
    {
        $this->signIn($this->user);

        $this->delete(route('help.destroy', $this->help->id), ['message' => ''])
            ->assertSessionHasErrors('message');
    }
    
    
}