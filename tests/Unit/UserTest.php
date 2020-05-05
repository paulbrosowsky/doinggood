<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp():void
    {
        parent::setUp();
        
        $this->user = factory('App\User')->create();
    }

    /** @test */
    function it_has_many_categories()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection',
            $this->user->categories
        );
    }

    /** @test */
    function it_has_many_tags()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection',
            $this->user->tagged
        );
    }


}
