<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCommentTest extends TestCase
{
    use RefreshDatabase;   

    /** @test */
    function unauthorized_users_may_not_delete_comments()
    {        
        $this->signIn();
        $comment = factory('App\Comment')->create();

        $this->delete(route('comment.destroy', $comment->id))->assertStatus(403);
    }    

    /** @test */
    function only_comment_creators_may_delete_comment()
    {
        $comment = factory('App\Comment')->create();
        $this->signIn($comment->creator);

        $this->delete(route('comment.destroy', $comment->id));

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }    
    
}