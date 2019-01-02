<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnitsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_user_cant_view_the_units()
    {
        $this->get('/units')->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_view_a_unit()
    {
        $data = factory('App\Unit')->create();

        $this->get('/units/'. $data->id)->assertRedirect('login');
    }

    /** @test */
    public function a_logged_in_user_can_view_the_units()
    {

        $this->actingAs(factory('App\User')->create());

        $this->get('/units')
            ->assertViewIs('units.index');
    }

    /** @test */
    public function a_logged_in_user_can_view_a_unit()
    {
        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Unit')->create();

        $this->get('/units/'. $data->id)
            ->assertSee(e($data->name));
    }
}
