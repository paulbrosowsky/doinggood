<?php

namespace Tests\Feature;

use App\Help;
use App\Notifications\HelpWasOffered;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class OfferHelpTest extends TestCase
{
    use RefreshDatabase;
    
    protected $need;

    public function setUp():void
    {
        parent::setUp();
    
        $this->need = factory('App\Need')->create();    
    }

    /** @test */
    function unauthorized_users_may_not_ask_questions()
    {        
        $this->post(route('help.store', $this->need->id))
            ->assertStatus(302);

        $this->signIn(factory('App\User')->create([
            'unlocked_at' => NULL
        ]));

        $this->post(route('help.store', $this->need->id))
            ->assertStatus(302);
    }   

    /** @test */
    function searchers_may_not_offer_help()
    {
        $this->signIn();
        
        $this->post(route('help.store', $this->need->id))
            ->assertStatus(302);
    }

    /** @test */
    function authorized_users_may_offer_help()
    {        
        $this->offerHelp();

        $this->assertCount(1, Help::all());

        $this->assertDatabaseHas('helps', [
            'need_id' => $this->need->id
        ]);
    }
    
    /** @test */
    function message_is_required()
    {
        $this->offerHelp(['message' => ''])->assertSessionHasErrors('message');
    }

    /** @test */
    function need_creator_receives_an_email_upon_new_help_offer()
    {
        Notification::fake();

        $this->offerHelp();

        Notification::assertSentTo($this->need->creator, HelpWasOffered::class);
    }

    public function offerHelp($overrides = [])
    {
        $this->signIn(factory('App\User')->create([
            'helper' => true
        ]));

        return $this->post(route('help.store', $this->need->id), array_merge([
            'message' => 'Help'
        ], $overrides));
    }
}