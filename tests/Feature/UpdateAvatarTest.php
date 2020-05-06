<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateAvatarTest extends TestCase
{
    use RefreshDatabase;
    
    protected $user;

    public function setUp():void
    {
        parent::setUp();

        $this->user = factory('App\User')->create();
    }
    
    /** @test */
    function guests_may_not_update_avatars()
    {
        $this->post(route('profile.update', $this->user->username))
            ->assertStatus(302);
    }    

    /** @test */
    function users_may_update_own_avatars()
    {        
        $this->signIn($this->user);

        Storage::fake('public');

        $this->post(route('profile.avatar', $this->user->username), [
            'image' => $file = UploadedFile::fake()->image('avatar.jpg')
        ]);

        $this->assertEquals(asset('assets/avatars/' .$file->hashName()), auth()->user()->avatar);       
            
        Storage::disk('public')->assertExists('assets/avatars/' .$file->hashName());
        
    }
}