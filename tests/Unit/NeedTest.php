<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NeedTest extends TestCase
{
    use RefreshDatabase;

    protected $need;

    public function setUp():void
    {
        parent::setUp();
        
        $this->need = factory('App\Need')->create();
    }

    /** @test */
    function it_belongs_to_a_user()
    {
        $this->assertInstanceOf('App\User', $this->need->creator);
    }

    /** @test */
    function it_has_many_categories()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection',
            $this->need->categories
        );
    }

     /** @test */
    function it_has_many_tags()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection',
            $this->need->tagged
        );
    }

    /** @test */
    function its_descriptions_are_sanitize_automaticaly()
    {
        $this->need->update([
            'project_description' => '<script>alert("bad")</script><p>Project is okay.</p>',
            'need_description' => '<script>alert("bad")</script><p>Need is okay.</p>',
        ]);

        $this->assertEquals($this->need->fresh()->project_description, '<p>Project is okay.</p>');
        $this->assertEquals($this->need->fresh()->need_description, '<p>Need is okay.</p>');
    }

    
}