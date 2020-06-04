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

    /** @test */
    function it_has_many_needs()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection',
            $this->user->needs
        );
    }

    /** @test */
    function it_has_many_helps()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection',
            $this->user->helps
        );
    }

    /** @test */
    function it_knows_wether_is_administrator()
    {
        $this->user->update([
            'email' => config('doinggood.administrators')[0]
        ]);

        $this->assertTrue($this->user->fresh()->isAdmin);
    }


    /** @test */
    function it_knows_wether_is_unlocked()
    {
        $this->user->update([
            'unlocked_at' => now()
        ]);    

        $this->assertTrue($this->user->isUnlocked);
    }

     /** @test */
    function its_description_is_sanitize_automaticaly()
    {
        $this->user->update([
            'description' => '<script>alert("bad")</script><p>This is okay.</p>',            
        ]);

        $this->assertEquals($this->user->fresh()->description, '<p>This is okay.</p>');      
    }

}
