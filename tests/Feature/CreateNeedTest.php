<?php

namespace Tests\Feature;

use App\Need;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNeedTest extends TestCase
{
    use RefreshDatabase;    
    
    /** @test */
    function not_fully_verified_may_not_create_needs()
    {
        $notVerified = factory('App\User')->create([
            'email_verified_at' => NULL,
            'unlocked_at' => NULL
        ]);        
        $this->signIn($notVerified);
        
        $this->get(route('need.create'))
            ->assertRedirect(route('home'));

        $this->post(route('need.store'))
            ->assertRedirect(route('home'));
        
    }

    /** @test */
    function helper_may_not_create_needs()
    {
        $this->signIn(factory('App\User')->create(['helper' => true]));
        
        $this->get(route('need.create'))
            ->assertRedirect(route('home'));

        $this->post(route('need.store'))
            ->assertRedirect(route('home'));
    }

    /** @test */
    function verified_users_may_create_needs()
    {
        $this->signIn();

        $this->get(route('need.create'))->assertViewIs('needs.create');

        $this->createNeed();

        $this->assertCount(1, Need::all());
        
        tap(Need::first(), function($need){
            $this->assertEquals($need->title, 'New Need' );
            $this->assertEquals($need->project_description, 'New Project Description');
            $this->assertEquals($need->need_description, 'New Nees Description'); 
            $this->assertEquals('Trier', $need->location);
            $this->assertEquals(12.345, $need->lat);
            $this->assertEquals(-12.345, $need->lng);           
        });        
    }

    /** @test */
    function title_is_required_()
    {
        $this->createNeed(['title' => ''])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function title_cannot_exceed_140_chars()
    {        
        $this->createNeed(['title' => str_repeat('a', 141)])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function deadline_is_required()
    {
        $this->createNeed(['deadline' => ''])
            ->assertSessionHasErrors('deadline');
    }

     /** @test */
    function deadline_must_be_a_date()
    {
        $this->createNeed(['deadline' => 'date'])
            ->assertSessionHasErrors('deadline');
    }

    /** @test */
    function category_can_be_attached()
    {        
        $categories = factory('App\Category', 2)->create();

        $this->createNeed(['categories' => $categories->toArray()]);
        
        $this->assertCount(2, Need::first()->categories); 
        $this->assertEquals($categories->first()->slug, Need::first()->categories->first()->slug);       
    }

    /** @test */
    function categories_are_required()
    {
        $this->createNeed(['categories' => []])
            ->assertSessionHasErrors('categories');
    }

    /** @test */
    function category_must_exists_in_db()
    {        
        $this->createNeed(['categories' => [
            ['slug' => 'not-existing']        
        ]])->assertSessionHasErrors('categories.*');
    }

     /** @test */
    function tags_can_be_attached()
    {        
        $this->withoutExceptionHandling();
        $this->createNeed(['tags' => ['foo', 'bar']]);

        $this->assertCount(2, Need::first()->tagged);
        $this->assertEquals(Need::first()->tagNames, ['Foo', 'Bar']);
    } 

    public function createNeed($overrides = [])
    {
        $this->signIn();

        $categories = factory('App\Category', 2)->create();
        
        return $this->post(route('need.store'), array_merge([
            'title' => 'New Need',
            'project_description' => 'New Project Description',
            'need_description' => 'New Nees Description',
            'deadline' => now()->addDay(),
            'categories' => $categories->toArray(),
            'location' => 'Trier',
            'lat' => 12.345,
            'lng' => -12.345,
        ], $overrides));
    }
    
}