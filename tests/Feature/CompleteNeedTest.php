<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Exceptions\NeedNotCompletable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompleteNeedTest extends TestCase{

    use RefreshDatabase;
    
    protected $user;
    protected $need;    

    public function setUp():void
    {
        parent::setUp();
    
        $this->user = factory('App\User')->create();       

        $this->need = factory('App\Need')->create([
            'user_id' => $this->user->id,
            'state_id' => 2
        ]);          
    }

    /** @test */
    function unauthorized_users_may_not_complete_need()
    {
        $this->signIn();
        $this->put(route('need.complete', $this->need->id))->assertStatus(403);
    }

    /** @test */
    function need_owners_may_set_need_as_assiged()
    {       
        $this->signIn($this->user);

        factory('App\Help')->create([
            'need_id' => $this->need->id,
            'state_id' => 3
        ]);        

        $this->put(route('need.complete', $this->need->id));

        $this->assertEquals($this->need->fresh()->state_id, 3);
        $this->assertTrue($this->need->fresh()->completed);
    }

     /** @test */    
    function need_can_only_be_completed_if_all_helps_are_completed()
    {    
        $this->expectException(NeedNotCompletable::class);  

        $this->signIn($this->user);

        factory('App\Help')->create([
            'need_id' => $this->need->id,
            'state_id' => 3
        ]);    
        
        factory('App\Help')->create([
            'need_id' => $this->need->id,
            'state_id' => 2
        ]); 
        
        $this->need->complete();       
    }
}