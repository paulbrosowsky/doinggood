<?php


namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HelpTest extends TestCase
{
    use RefreshDatabase;

    protected $help;

    public function setUp():void
    {
        parent::setUp();
        
        $this->help = factory('App\Help')->create();
    }
    
     /** @test */
    function it_belongs_to_a_user()
    {
        $this->assertInstanceOf('App\User', $this->help->user);
    }

     /** @test */
    function it_belongs_to_a_state()
    {       
        $this->assertInstanceOf('App\State', $this->help->state);
    }
}