<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TimelineTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_user_cant_view_the_timeline()
    {
        $this->get('/timeline')->assertRedirect('login');
    }

    /** @test */
    public function a_logged_in_user_can_view_the_timeline()
    {

        $this->actingAs(factory('App\User')->create());

        $this->get('/timeline')
            ->assertViewIs('timeline.index');
    }
}
