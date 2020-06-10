<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Exceptions\NeedNotAssignable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssignNeedTest extends TestCase
{
    use RefreshDatabase;
    
    protected $user;
    protected $need;    

    public function setUp():void
    {
        parent::setUp();
    
        $this->user = factory('App\User')->create();

        $this->need = factory('App\Need')->create(['user_id' => $this->user->id]);        
        
    }

    /** @test */
    function unauthorized_users_may_not_assign_need()
    {
        $this->signIn();
        $this->put(route('need.assign', $this->need->id))->assertStatus(403);
    }

    /** @test */
    function need_owners_may_set_need_as_assiged()
    {
        $this->signIn($this->user);

        factory('App\Help')->create([
            'need_id' => $this->need->id,
            'state_id' => 2
        ]);        

        $this->put(route('need.assign', $this->need->id));

        $this->assertEquals($this->need->fresh()->state_id, 2);
        $this->assertTrue($this->need->fresh()->assigned);
    }

    /** @test */    
    function need_can_only_be_assigned_if_they_are_any_assgned_helps()
    {        
        $this->expectException(NeedNotAssignable::class);  

        $this->signIn($this->user);

        factory('App\Help')->create([
            'need_id' => $this->need->id,
            'state_id' => 1
        ]);        
        
        $this->need->assign();       
    }
}