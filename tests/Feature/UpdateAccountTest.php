<?php

namespace Tests\Feature;

use Illuminate\Auth\Notifications\VerifyEmail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class UpdateAccountTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp():void        
    {
        parent::setUp();
        
        $this->user = factory('App\User')->create();
    }
    
    /** @test */
    function users_may_update_account_email()
    {
        $this->updateEmail(); 
        $this->assertEquals($this->user->email, 'john@example.com');
    }    

     /** @test */
    function email_is_required()
    {        
        $this->updateEmail(['email' => ''])      
            ->assertSessionHasErrors('email');        
    }

    /** @test */
    function email_must_be_valide()
    {
        $this->updateEmail(['email' => 'not-valide'])      
            ->assertSessionHasErrors('email');  
    }    

    /** @test */
    function email_has_to_be_unique()
    {
        factory('App\User')->create(['email' => 'johndoe@example.com']);  

        $this->updateEmail(['email' => 'johndoe@example.com'])      
            ->assertSessionHasErrors('email');  
    }

    /** @test */
    function confirmation_email_is_send_upon_email_update()
    {
        Notification::fake();

        $this->updateEmail();

        Notification::assertSentTo(auth()->user(), VerifyEmail::class);
        $this->assertNull(auth()->user()->email_verified_at);

    }

    /** @test */
    function users_may_update_thier_password()
    {
        $this->updatePassword();
        $this->assertTrue(Hash::check('newpassword', $this->user->password));
    }

    /** @test */
    public function password_is_required()
    {     
        $this->updatePassword(['password' => ''])
            ->assertSessionHasErrors('password');        
    }

    /** @test */
    public function password_must_be_confirmed()
    {        
        $this->updatePassword([            
            'password_confirmation' => 'wrongpassword'
        ])->assertSessionHasErrors('password');         
    }

    /** @test */
    public function password_must_be_6_chars()
    {
        $this->updatePassword([            
            'password' => 'foo',
            'password_confirmation' => 'foo',
        ])->assertSessionHasErrors('password');          
    }

    public function updateEmail($overrides = [])
    {
        $this->signIn($this->user);

        return $this->post(route('account.email'), array_merge([
            'email' => 'john@example.com'
        ], $overrides));
    }

    public function updatePassword($overrides = [])
    {
        $this->signIn($this->user);

        return $this->post(route('account.password'), array_merge([
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword'
        ], $overrides));
    }
    
}