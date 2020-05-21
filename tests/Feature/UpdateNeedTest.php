<?php

namespace Tests\Feature;

use DateTime;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateNeedTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $need;

    public function setUp():void
    {
        parent::setUp();
    
        $this->user = factory('App\User')->create();
        $this->need = factory('App\Need')->create([
            'user_id' => $this->user->id
        ]);
    }  
    
    /** @test */
    function unauthorized_users_may_not_update_needs()
    {        
        $need = factory('App\Need')->create();

        $this->get(route('need.edit', $need->id))
            ->assertStatus(302);

        $this->patch(route('need.update', $need->id))
            ->assertStatus(302);       
       
        $this->signIn();

        $this->get(route('need.edit', $need->id))
            ->assertStatus(403);

        $this->patch(route('need.update', $need->id))
            ->assertStatus(403);
    }

    /** @test */
    function authorized_users_may_enter_edit_view()
    {
        $this->signIn($this->user);

        $this->get(route('need.edit', $this->need->id))
            ->assertViewIs('needs.edit');
    }

    /** @test */
    function authorized_users_may_update_own_needs()
    {
        $this->withoutExceptionHandling();
        $this->updateNeed();        

        tap($this->need->fresh(), function($need){
            $this->assertEquals($need->title, 'Updated Need' );
            $this->assertEquals($need->project_description, 'Updated Project Description');
            $this->assertEquals($need->need_description, 'Updated Nees Description');
            $this->assertEquals($need->deadline, now()->format('c'));
        });  
    }

    /** @test */
    function title_is_required_()
    {
        $this->updateNeed(['title' => ''])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function title_cannot_exceed_140_chars()
    {        
        $this->updateNeed(['title' => str_repeat('a', 141)])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function deadline_is_required()
    {
        $this->updateNeed(['deadline' => ''])
            ->assertSessionHasErrors('deadline');
    }

     /** @test */
    function deadline_must_be_a_date()
    {
        $this->updateNeed(['deadline' => 'date'])
            ->assertSessionHasErrors('deadline');
    }

    /** @test */
    function category_can_be_attached()
    {        
        $categories = factory('App\Category', 2)->create();

        $this->updateNeed(['categories' => $categories->toArray()]);
        
        $this->assertCount(2, $this->need->categories); 
        $this->assertEquals($categories->first()->slug, $this->need->categories->first()->slug);       
    }

    /** @test */
    function categories_are_required()
    {
        $this->updateNeed(['categories' => []])
            ->assertSessionHasErrors('categories');
    }

    /** @test */
    function category_must_exists_in_db()
    {        
        $this->updateNeed(['categories' => [
            ['slug' => 'not-existing']        
        ]])->assertSessionHasErrors('categories.*');
    }

     /** @test */
    function tags_can_be_attached()
    {        
        $this->withoutExceptionHandling();
        $this->updateNeed(['tags' => ['foo', 'bar']]);

        $this->assertCount(2, $this->need->tagged);
        $this->assertEquals($this->need->tagNames, ['Foo', 'Bar']);
    } 
    
    public function updateNeed($overrides = [])
    {
        $this->signIn($this->user);

        $categories = factory('App\Category', 2)->create();
        
        return $this->patch(route('need.update', $this->need->id), array_merge([
            'title' => 'Updated Need',
            'project_description' => 'Updated Project Description',
            'need_description' => 'Updated Nees Description',
            'deadline' => now(),
            'categories' => $categories->toArray()
        ], $overrides));
    }
}