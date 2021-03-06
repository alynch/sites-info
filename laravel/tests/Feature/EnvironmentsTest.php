<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\ValidatesFields;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnvironmentsTest extends TestCase
{
    use RefreshDatabase;
    use ValidatesFields;

    /** @test */
    public function a_guest_user_cant_view_the_environments()
    {
        $this->get('/environments')->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_view_an_environment()
    {
        $data = factory('App\Environments')->create();

        $this->get('/environments/'. $data->id)->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_view_the_edit_page()
    {
        $data = factory('App\Environments')->create();

        $this->get('/environments/'. $data->id . '/edit')->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_view_the_create_page()
    {
        $this->get('/environments/create')->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_add_an_environment()
    {
        $data = factory('App\Environments')->raw();

        $this->post('/environments', $data)->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_edit_an_environment()
    {
        $data = factory('App\Environments')->create();

        $new_name = 'New name';
        $old_name = $data->name;
        $data->name = $new_name;

        $this->put('/environments/' . $data->id, $data->toArray())->assertRedirect('login');
        $this->assertDatabaseHas('environments', ['id' => $data->id, 'name' => $old_name]);
    }

    /** @test */
    public function a_guest_user_cant_delete_an_environment()
    {

        $data = factory('App\Environments')->create();

        $this->delete('/environments/' . $data->id, $data->toArray())
            ->assertRedirect('login');

        $this->assertDatabaseHas('environments', ['id' => $data->id]);
    }

    /** @test */
    public function a_logged_in_user_can_view_all_environments()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Environments')->create();

        $this->get('/environments')
            ->assertViewIs('environments.index')
            ->assertViewHas('environments')
            ->assertSee(e($data->name));
    }


    /** @test */
    public function a_user_view_an_environment()
    {
        $this->withoutExceptionHandling();

        $data = factory('App\Environments')->create();

        $this->actingAs(factory('App\User')->create());

        $this->get('/environments/'. $data->id . '/edit')
            ->assertSee(e($data->name))
            ->assertSee($data->code);
    }


    /** @test */
    public function a_logged_in_user_can_add_an_environment()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Environments')->raw();

        $this->post('/environments', $data)
            ->assertRedirect('/environments');

        $this->assertDatabaseHas('environments', $data);

        $this->get('/environments')->assertSee(e($data['name']));
    }

    /** @test */
    public function a_logged_in_user_can_edit_an_environment()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Environments')->create();

        $new_name = 'New name';
        $data->name = $new_name;

        $this->put('/environments/' . $data->id, $data->toArray());

        $this->assertDatabaseHas('environments', ['id' => $data->id, 'name' => $new_name]);
    }

    /** @test */
    public function a_logged_in_user_can_delete_an_environment()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Environments')->create();

        $this->delete('/environments/' . $data->id, $data->toArray());

        $this->assertDatabaseMissing('environments', ['id' => $data->id]);
    }


    /** @test */
    public function a_logged_in_user_cannot_delete_an_environment_used_in_applications()
    {

        $this->actingAs(factory('App\User')->create());

        $application = factory('App\Applications')->create();

        $environment = factory('App\Environments')->create();

        $application->environments()->sync($environment->id);

        $this->delete('/environments/' . $environment->id)
            ->assertSessionHas('warning');

        $this->assertDatabaseHas('environments', ['id' => $environment->id]);
    }


    /* Validations */

    /** @test */
    public function an_environment_requires_a_name()
    {
        $this->validate('App\Environments', '/environments', 'name');
    }

    /** @test */
    public function an_environment_requires_a_code()
    {
        $this->validate('App\Environments', '/environments', 'code');
    }

    /** @test */
    public function an_environment_requires_a_sort_order()
    {
        $this->validate('App\Environments', '/environments', 'sort_order');
    }
}
