<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewNeedsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function users_can_see_all_needs()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(route('needs'));

        $response->assertStatus(200);
    }
}
