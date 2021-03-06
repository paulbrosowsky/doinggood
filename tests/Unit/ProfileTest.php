<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    

    /** @test */
    function searcher_profile_contains_of_needs()
    {
        $user = factory('App\User')->create();
        $state = factory('App\State')->create();
        factory('App\Need')->create([
            'user_id' => $user->id , 
            'state_id' => $state->id          
        ]);   
           
        $this->assertInstanceOf(
            'App\Need',
            $user->feed()[$state->name][0]
        );
    }

    /** @test */
    function helper_profile_contains_of_helps()
    {        
        $user = factory('App\User')->create(['helper' => true]);
        $state = factory('App\State')->create();         
        
        factory('App\Help')->create([
            'user_id' => $user->id,   
            'state_id' => $state->id         
        ]);    
        
        $this->assertInstanceOf(
            'App\Help',
            $user->feed()[$state->name][0]
        );
    }

    /** @test */
    function it_includes_helps_counter()
    {
        $user = factory('App\User')->create(['helper' => true]);   
        factory('App\Help')->create([
            'user_id' => $user->id,
            'need_id' => factory('App\Need')->create()->id            
        ]);             
        factory('App\Help')->create([
            'user_id' => $user->id,
            'need_id' => factory('App\Need')->create()->id,
            'state_id' => 3
        ]);         
        
        $this->assertEquals(
            ['active' => 1, 'completed' => 1, 'total' => 2],
            $user->feedCounter
        );
    }

    /** @test */
    function it_includes_needs_counter()
    {
        $user = factory('App\User')->create();    
        factory('App\Need')->create([
            'user_id' => $user->id , 
            'state_id' => 3         
        ]);  
        factory('App\Need')->create([
            'user_id' => $user->id 
        ]); 
        
        $this->assertEquals(
            ['active' => 1, 'completed' => 1, 'total' => 2],
            $user->feedCounter
        );
    }


    
}