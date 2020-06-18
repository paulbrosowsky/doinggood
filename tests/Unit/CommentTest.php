<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;       

    protected $comment;

    public function setUp():void
    {
        parent::setUp();
        
        $this->comment = factory('App\Comment')->create();
    }
    
     /** @test */
    function it_belongs_to_a_user()
    {
        $this->assertInstanceOf('App\User', $this->comment->creator);
    }
}