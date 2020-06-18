<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCommentTest extends TestCase
{
    use RefreshDatabase;   

    /** @test */
    function unauthorized_users_may_not_update_comments()
    {
        $this->signIn();
        $comment = factory('App\Comment')->create();

        $this->put(route('comment.update', $comment->id))->assertStatus(403);
    }    

    /** @test */
    function only_comment_creators_may_update_comment()
    {
        $comment = factory('App\Comment')->create();
        $this->signIn($comment->creator);

        $this->put(route('comment.update', $comment->id),['body' => 'Updated']);

        $this->assertEquals($comment->fresh()->body, 'Updated');
    }

    /** @test */
    function body_is_required()
    {
        $comment = factory('App\Comment')->create();
        $this->signIn($comment->creator);

        $this->put(route('comment.update', $comment->id),['body' => ''])
            ->assertSessionHasErrors('body');
    }
    
}