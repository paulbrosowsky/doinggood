<?php

namespace Tests\Fatures;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    function users_may_delete_their_accounts()
    {
        $user = factory('App\User')->create(); 
        $this->signIn($user);
       
               
        $users = User::all();
        $this->assertCount(1, $users);

        $this->delete(route('account.destroy')); 

        $users = User::all();
        $this->assertCount(0, $users->fresh());
    }    

    /** @test */
    function categories_are_detached_if_user_account_is_deleted()
    {
        $category = factory('App\Category')->create();
        $user = factory('App\User')->create(); 
        $user->categories()->attach($category['id']);

        $this->assertDatabaseHas('categorizables', ['categorizable_id' => $user->id]);

        $this->signIn($user);

        $this->delete(route('account.destroy')); 
        $this->assertDatabaseMissing('categorizables', ['categorizable_id' => $user->id]);
    }
}