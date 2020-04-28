<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewNeedsTest extends TestCase
{
    use RefreshDatabase;

    protected $need;

    public function setUp():void
    {
        parent::setUp();

        $this->need = factory('App\Need')->create();
    }

    /** @test */
    function users_can_see_all_needs()
    {
        $this->get(route('needs'))        
            ->assertSee($this->need->title);
    }

    /** @test */
    function users_can_view_a_single_need()
    {
        $this->get(route('need', $this->need->id))
            ->assertSee($this->need->title);
    }
}
