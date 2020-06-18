<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCommentTest extends TestCase
{
    use RefreshDatabase;    
    
    protected $need;
    protected $help;

    public function setUp():void
    {
        parent::setUp();
        
        $this->need = factory('App\Need')->create();

        $this->help = factory('App\Help')->create([
            'need_id' => $this->need->id,
            'state_id' => 3
        ]);        
    }

    /** @test */
    function unauthorized_users_may_not_create_comments()
    {
        $this->signIn();

        $this->post(route('comment.store', $this->help->id))->assertStatus(403);
    }

    /** @test */
    function help_owners_may_comment_help()
    {
        $this->signIn($this->help->user);

        $this->assertEmpty($this->help->comments);

        $this->comment();

        $this->assertCount(1, $this->help->fresh()->comments);        
    }

    /** @test */
    function needs_creators_may_comment_help()
    {
        $this->signIn($this->need->creator);

        $this->assertEmpty($this->help->comments);

        $this->comment();

        $this->assertCount(1, $this->help->fresh()->comments);        
    }

    /** @test */
    function help_must_be_completed()
    {
        $this->signIn($this->need->creator);
        $this->help->update(['state_id' => 1]);

        $this->comment()->assertStatus(403);
    }

    /** @test */
    function body_is_required()
    {
        $this->signIn($this->need->creator);
        $this->comment(['body' => ''])->assertSessionHasErrors('body');
    }


    public function comment($overrides = [])
    {    
        return $this->post(route('comment.store', $this->help->id), array_merge([
            'body' => 'It was good'
        ], $overrides));
    }
}