<?php

namespace Tests\Unit;

use App\Notifications\NeedMatchingAvailable;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class NeedMatchingTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    function it_checks_if_need_matching_any_helper_preferences_an_sends_an_email_to_helper()
    {
        Notification::fake();
        $this->withoutExceptionHandling();

        $categories = factory('App\Category', 2)->create();

        $helper =  factory('App\User')->create([ 
            'helper' => true,
            'lat' => 48.77862, 
            'lng' => 9.17971,
            'activity_area' => 50
        ]);
        $helper->tag(['foo', 'bar']);
        $helper->updateCategories($categories);     
        
        
        $need = factory('App\Need')->create(); 
        $this->signIn($need->creator);
        $this->patch(route('need.update', $need->id), [
            'title' => $need->title,
            'deadline' => now(),
            'categories' => $categories->toArray(),
            'tags' => ['foo', 'bar', 'tag'],
            'lat' => 48.70073,
            'lng' => 9.65289
        ]);   

        Notification::assertSentTo($helper, NeedMatchingAvailable::class);
    }
    
}