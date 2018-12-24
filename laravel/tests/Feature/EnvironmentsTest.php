<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnvironmentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_user_cant_add_an_environment()
    {
        $data = factory('App\Environments')->raw();

        $this->post('/environments', $data)->assertRedirect('login');
    }


    /** @test */
    public function a_logged_in_user_can_add_an_environment()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Environments')->raw();

        $this->post('/environments', $data);

        $this->assertDatabaseHas('environments', $data);

        $this->get('/environments')->assertSee($data['name']);
    }


    /** @test */
    public function an_environment_requires_a_name()
    {

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Environments')->raw(['name' => '']);

        $this->post('/environments', $data)->assertSessionHasErrors('name');
    }


    /** @test */
    public function an_environment_requires_a_code()
    {

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Environments')->raw(['code' => '']);

        $this->post('/environments', $data)->assertSessionHasErrors('code');
    }


    /** @test */
    public function an_environment_requires_a_sort_order()
    {

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Environments')->raw(['sort_order' => '']);

        $this->post('/environments', $data)->assertSessionHasErrors('sort_order');
    }
}
