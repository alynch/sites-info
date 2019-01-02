<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApplicationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_user_cant_view_the_applications()
    {
        $this->get('/applications')->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_view_an_application()
    {
        $data = factory('App\Applications')->create();

        $this->get('/applications/'. $data->id)->assertRedirect('login');
        $this->get('/applications/'. $data->id . '/edit')->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_view_the_edit_page()
    {
        $data = factory('App\Applications')->create();

        $this->get('/applications/'. $data->id . '/edit')->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_view_the_create_page()
    {
        $this->get('/applications/create')->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_add_an_application()
    {
        $data = factory('App\Applications')->raw();

        $this->post('/applications', $data)->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_edit_an_application()
    {
        $data = factory('App\Applications')->create();

        $new_name = 'New name';
        $old_name = $data->name;
        $data->name = $new_name;

        $this->put('/applications/' . $data->id, $data->toArray())->assertRedirect('login');
        $this->assertDatabaseHas('applications', ['id' => $data->id, 'name' => $old_name]);
    }

    /** @test */
    public function a_guest_user_cant_delete_an_application()
    {

        $data = factory('App\Applications')->create();

        $this->delete('/applications/' . $data->id, $data->toArray())
            ->assertRedirect('login');

        $this->assertDatabaseHas('applications', ['id' => $data->id]);
    }


    /** @test */
    public function a_logged_in_user_can_view_all_applications()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Applications')->create();

        $this->get('/applications')->assertSee(e($data->name));
    }


    /** @test */
    public function a_user_view_an_application()
    {
        $this->withoutExceptionHandling();

        $data = factory('App\Applications')->create();

        $this->actingAs(factory('App\User')->create());

        $this->get('/applications/'. $data->id . '/edit')
            ->assertSee(e($data->name))
            ->assertSee($data->code);
    }


    /** @test */
    public function a_logged_in_user_can_add_an_application()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Applications')->raw();

        $this->post('/applications', $data);

        $this->assertDatabaseHas('applications', $data);

        $this->get('/applications')->assertSee(e($data['name']));
    }

    /** @test */
    public function a_logged_in_user_can_edit_an_application()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Applications')->create();

        $new_name = 'New name';
        $data->name = $new_name;

        $this->put('/applications/' . $data->id, $data->toArray());

        $this->assertDatabaseHas('applications', ['id' => $data->id, 'name' => $new_name]);
    }

    /** @test */
    public function a_logged_in_user_can_delete_an_application()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Applications')->create();

        $this->delete('/applications/' . $data->id, $data->toArray());

        $this->assertDatabaseMissing('applications', ['id' => $data->id]);
    }


    /** @test */
    public function an_application_requires_a_name()
    {

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Applications')->raw(['name' => '']);

        $this->post('/applications', $data)->assertSessionHasErrors('name');
    }


    /** @test */
    public function an_application_requires_a_group()
    {

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Applications')->raw(['group_id' => '']);

        $this->post('/applications', $data)->assertSessionHasErrors('group_id');
    }
}
