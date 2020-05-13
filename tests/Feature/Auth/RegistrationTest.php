<?php

namespace Tests\Feature\Auth;

use App\Notifications\UnlockProfile;
use App\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    
     /** @test */
    public function users_can_register_an_account()
    {  
        $response= $this->registerUser();

        $response->assertRedirect('/home');
        
        $this->assertTrue(Auth::check());
        $this->assertCount(1, User::all());       

        tap(User::first(), function ($user) {
            $this->assertEquals('John Doe', $user->name);
            $this->assertEquals('john_doe', $user->username);
            $this->assertEquals('johndoe@example.com', $user->email);
            $this->assertTrue(Hash::check('password', $user->password));
        });
    }

    /** @test */
    function name_is_required()
    {        
        $response = $this->registerUser(['name' => '']);
       
        $response->assertSessionHasErrors('name');
        $this->assertFalse(Auth::check());
        $this->assertCount(0, User::all());
    }

     /** @test */
    function email_is_required()
    {        
        $response = $this->registerUser(['email' => '']);
       
        $response->assertSessionHasErrors('email');
        $this->assertFalse(Auth::check());
        $this->assertCount(0, User::all());
    }

    /** @test */
    function email_must_be_valide()
    {
        $response = $this->registerUser(['email' => 'mail.test']);
       
        $response->assertSessionHasErrors('email');
        $this->assertFalse(Auth::check());
        $this->assertCount(0, User::all());
    }

    /** @test */
    function email_has_to_be_unique()
    {
        factory('App\User')->create(['email' => 'johndoe@example.com']);  

        $response = $this->registerUser(['email' => 'johndoe@example.com']);
       
        $response->assertSessionHasErrors('email');
        $this->assertFalse(Auth::check());        
    }

    /** @test */
    function password_is_required()
    {
        $response = $this->registerUser(['password' => '']);
       
        $response->assertSessionHasErrors('password');
        $this->assertFalse(Auth::check());
        $this->assertCount(0, User::all());
    }

    /** @test */
    function password_must_be_at_least_8_characters()
    {
        $response = $this->registerUser(['password' => 'secret']);
       
        $response->assertSessionHasErrors('password');
        $this->assertFalse(Auth::check());
        $this->assertCount(0, User::all());
    }

    /** @test */
    function password_must_be_confirmed()
    {
        $response = $this->registerUser([
            'password' => 'password',
            'password_confirmation' => 'secret'
        ]);
       
        $response->assertSessionHasErrors('password');
        $this->assertFalse(Auth::check());
        $this->assertCount(0, User::all());
    }

    /** @test */
    function a_confirmation_email_is_sent_upon_registration()
    {
        Notification::fake();
        $this->registerUser();

        Notification::assertSentTo(User::first(), VerifyEmail::class);
    }
    
    /** @test */
    function a_unlock_profile_email_is_send_upon_registration()
    {   
        $admin = factory('App\User')->create([
            'email' => config('doinggood.administrators')[0]
        ]);
        
        Notification::fake();
        $this->registerUser();        
        
        Notification::assertSentTo($admin, UnlockProfile::class);
    }

    public function registerUser($overrides = [])
    {
        return $this->post(route('register'), array_merge([
            'name' => 'John Doe',            
            'email' => 'johndoe@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ], $overrides));        
    }
    
}