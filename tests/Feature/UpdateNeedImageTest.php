<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Storage;

class UpdateNeedImageTest extends TestCase
{
    use RefreshDatabase;

    protected $need;
    protected $user;

    public function setUp():void
    {
        parent::setUp();

        $this->user = factory('App\User')->create();

        $this->need = factory('App\Need')->create([
            'user_id' => $this->user
        ]);
    }
    
    /** @test */
    function unauthorized_users_may_not_update_avatars()
    {     
        $this->post(route('need.image', $this->need->id))
            ->assertStatus(302);

        $this->signIn();
        $this->post(route('need.image', $this->need->id))
            ->assertStatus(403);
    }  

    /** @test */
    function users_may_update_own_needs_images()
    {     
        $this->signIn($this->user);

        Storage::fake('public');

        $this->post(route('need.image', $this->need->id), [
            'image' => $file = UploadedFile::fake()->image('need_image.jpg')
        ]);

        $this->assertEquals(
            '/storage/assets/need_images/' .$file->hashName(), 
            $this->need->fresh()->title_image
        );       
            
        Storage::disk('public')->assertExists('assets/need_images/' .$file->hashName());
        
    }
    
    
}