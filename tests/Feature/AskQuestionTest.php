<?php

namespace Tests\Feature;

use App\Notifications\QuestionAboutNeed;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class AskQuestionTest extends TestCase
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
        $this->post(route('need.question', $this->need->id))
            ->assertStatus(302);

        $this->signIn(factory('App\User')->create([
            'unlocked_at' => NULL
        ]));

        $this->post(route('need.question', $this->need->id))
            ->assertStatus(302);
    }   
    
    /** @test */
    function authorized_users_may_ask_questions_about_needs()
    {        
        $this->signIn();
        Notification::fake();

        $this->post(route('need.question', $this->need->id), ['body' => 'Question?']);

        Notification::assertSentTo($this->need->creator, QuestionAboutNeed::class);
    }

    /** @test */
    function question_body_is_required()
    {
        $this->signIn();
        
        $this->post(route('need.question', $this->need->id), ['body' => ''])
            ->assertSessionHasErrors('body');
    }
    
}