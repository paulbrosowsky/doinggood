<?php

namespace Tests\Feature;

use App\Notifications\HelpWasCompleted;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class CompleteHelpTest extends TestCase
{
    use RefreshDatabase;
    
    protected $user;
    protected $help;

    public function setUp():void
    {
        parent::setUp();
    
        $this->user = factory('App\User')->create(['helper' => true]);        
        
        $this->help = factory('App\Help')->create([            
            'user_id' => $this->user->id,
            'state_id' => 2
        ]);
    }

    /** @test */
    function unauthorized_users_may_not_complete_help()
    {
        $this->signIn(factory('App\User')->create(['helper' => true]));
        $this->put(route('help.complete', $this->help->id))->assertStatus(403);
    }

    /** @test */
    function help_owners_may_complete_own_helps()
    {
        $this->complete();       
        
        $this->assertEquals($this->help->fresh()->state_id, 3);
        $this->assertTrue($this->help->fresh()->completed);
    }

    /** @test */
    function need_creators_may_complete_helps()
    {
        $this->signIn($this->help->need->creator);
        
        $this->put(route('help.complete', $this->help->id),[
            'message' => 'Super'
        ]);
   
        $this->assertTrue($this->help->fresh()->completed);
    }

    /** @test */
    function email_to_need_owner_is_sent_upon_help_is_completed()
    {       
        Notification::fake();

        $this->complete();

        Notification::assertSentTo($this->help->need->creator, HelpWasCompleted::class);
    }

     /** @test */
    function email_to_help_creator_is_sent_upon_help_is_completed()
    {       
        Notification::fake();

        $this->complete();

        Notification::assertSentTo($this->help->need->creator, HelpWasCompleted::class);
    }


    /** @test */
    function message_is_required()
    {
        $this->complete(['message' => ''])->assertSessionHasErrors('message');
    }

    /** @test */
    function owner_create_a_comment_upon_completing()
    {
        $this->complete();

        $this->assertDatabaseHas('comments', ['body' => 'Super']);
        $this->assertCount(1, $this->help->fresh()->comments);
    }

    public function complete($overrides = [])
    {
        $this->signIn($this->user);

        return $this->put(route('help.complete', $this->help->id),array_merge([
            'message' => 'Super'
        ], $overrides));
    }
    
}