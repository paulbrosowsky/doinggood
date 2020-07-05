<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    use RefreshDatabase;
    
    protected $user;
    protected $category;

    public function setUp():void
    {
        parent::setUp();

        $this->user = factory('App\User')->create();
        $this->category = factory('App\Category')->create();
    }

    /** @test */
    function guests_may_not_update_profiles()
    {
        $this->get(route('profile.edit', $this->user->username))
            ->assertStatus(302);

        $this->post(route('profile.update', $this->user->username))
            ->assertStatus(302);
    }

    /** @test */
    function unauthorized_users_may_not_update_profiles()
    {        
        $this->signIn();

        $this->get(route('profile.edit', $this->user->username))
            ->assertStatus(403);

        $this->post(route('profile.update', $this->user->username))
            ->assertStatus(403);
    }

    /** @test */
    function users_may_edit_own_profile()
    {
        $this->signIn($this->user);

        $this->get(route('profile.edit', $this->user->username))            
            ->assertSee($this->user->name)
            ->assertSee($this->category->name);
    }

    /** @test */
    function users_may_update_own_profile()
    {
        $this->withoutExceptionHandling();
        $this->updateProfile();

        tap($this->user->fresh(), function($user){
            $this->assertEquals('John Doe', $user->name);
            $this->assertEquals('Description Text', $user->description);
            $this->assertEquals('Excerpt Text', $user->excerpt);
            $this->assertTrue($user->helper);
            $this->assertEquals('https://web.link', $user->web_link);  
            $this->assertEquals('Trier', $user->location);
            $this->assertEquals(12.345, $user->lat);
            $this->assertEquals(-12.345, $user->lng);
            $this->assertEquals(10, $user->activity_area);            
        });
    }   

    /** @test */
    function name_is_required()
    {       
        $this->updateProfile([ 'name' => ''])
            ->assertSessionHasErrors('name');
    }

     /** @test */
    function name_cannot_exceed_255_chars()
    {       
        $this->updateProfile([ 'name' => str_repeat('a', 256),])
            ->assertSessionHasErrors('name');
    }

     /** @test */
    function excerpt_cannot_exceed_255_chars()
    {       
        $this->updateProfile([ 'excerpt' => str_repeat('a', 256),])
            ->assertSessionHasErrors('excerpt');
    }

    /** @test */
    function web_link_must_be_a_valid_url()
    {
        $this->updateProfile([ 'web_link' => 'not_valid',])
            ->assertSessionHasErrors('web_link');
    } 

     /** @test */
    function lat_lng_are_numeric()
    {
        $this->updateProfile([ 'lat' => '' ])
            ->assertSessionHasErrors('lat');

        $this->updateProfile([ 'lng' => 'text' ])
            ->assertSessionHasErrors('lng');
    }

      /** @test */
    function activity_area_is_integer()
    {
        $this->updateProfile([ 'activity_area' => 23.56 ])
            ->assertSessionHasErrors('activity_area');
    }

    /** @test */
    function category_can_be_attached()
    {        
        $categories = factory('App\Category', 2)->create();

        $this->updateProfile(['categories' => $categories->toArray()]);
        
        $this->assertCount(2, $this->user->categories); 
        $this->assertEquals($categories->first()->slug, $this->user->categories->first()->slug);       
    }

    /** @test */
    function category_must_exists_in_db()
    {        
        $this->updateProfile(['categories' => [
            ['slug' => 'not-existing']        
        ]])->assertSessionHasErrors('categories.*');
    }

    /** @test */
    function tags_can_be_attached()
    {        
        $this->updateProfile(['tags' => ['foo', 'bar']]);

        $this->assertCount(2, $this->user->tagged);
        $this->assertEquals($this->user->tagNames, ['Foo', 'Bar']);
    }   

    public function updateProfile($overrides = [])
    {
        $this->signIn($this->user);

        return $this->post(route('profile.update', $this->user->username), array_merge([
            'name' => 'John Doe',            
            'description' => 'Description Text',
            'excerpt' => 'Excerpt Text',
            'helper' => true,  
            'web_link' => 'https://web.link',
            'facebook_link' => 'https://facebook.link',
            'instagram_link' => 'https://instagram.link',
            'tweeter_link' => 'https://tweeter.link',
            'location' => 'Trier',
            'lat' => 12.345,
            'lng' => -12.345,
            'activity_area' => 10 
        ], $overrides)); 
    }


    
}