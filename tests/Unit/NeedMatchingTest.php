<?php

namespace Tests\Unit;

use App\Notifications\NeedMatchingAvailable;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class NeedMatchingTest extends TestCase
{
    use RefreshDatabase;

    protected $categories;
    protected $helper;


    public function setUp() :void
    {
        parent::setUp();

        $this->categories = factory('App\Category', 2)->create();

        $this->helper = factory('App\User')->create([ 
            'helper' => true,
            'lat' => 48.77862, 
            'lng' => 9.17971,
            'activity_area' => 50,
            'enable_matching' => true
        ]);

        $this->helper->tag(['foo', 'bar']);
        $this->helper->updateCategories($this->categories);  
    }
    
    /** @test */
    function it_checks_for_need_matching_and_sends_emails_to_helpers_upon_creating_new_need()
    {
        Notification::fake();
     
        $this->createNeed();

        Notification::assertSentTo($this->helper, NeedMatchingAvailable::class);
    }

    /** @test */
    function it_checks_for_need_matching_and_sends_emails_to_helpers_upon_updating_a_need()
    {
        Notification::fake();
       
        $need = factory('App\Need')->create();
        $this->signIn($need->creator);
        $this->patch(route('need.update', $need->id), [
            'title' => $need->title,
            'deadline' => now(),
            'categories' => $this->categories->toArray(),
            'tags' => ['foo', 'bar', 'tag'],
            'lat' => 48.70073,
            'lng' => 9.65289
        ]);   

        $this->createNeed();

        Notification::assertSentTo($this->helper, NeedMatchingAvailable::class);
    }

    /** @test */
    function is_does_not_sent_any_emails_if_helper_do_not_enabled_maching()
    {
        Notification::fake();

        $this->helper->update(['enable_matching' => false]);
     
        $this->createNeed();

        Notification::assertNotSentTo($this->helper, NeedMatchingAvailable::class);
    }


    public function createNeed()
    {
        $need = factory('App\Need')->make([
            'title' => 'New Need',
            'deadline' => now(),
            'categories' => $this->categories->toArray(),
            'tags' => ['foo', 'bar', 'tag'],
            'lat' => 48.70073,
            'lng' => 9.65289
        ]); 
        
        $this->signIn();

        $this->post(route('need.store'), $need->toArray());
    }
    
}