<?php

namespace Tests\Feature;

use App\Need;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteNeedTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    function unauthorized_users_may_not_delete_needs()
    {
        $need = factory('App\Need')->create();
        $this->signIn();

        $this->delete(route('need.destroy', $need->id))
            ->assertStatus(403);
    }

    /** @test */
    function users_may_delete_own_needs()
    {
        $need = factory('App\Need')->create();
        $this->signIn($need->creator);

        $this->delete(route('need.destroy', $need->id));

        $this->assertEmpty(Need::all());
    }
    
}