<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApplicationGroupsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_user_cant_view_the_groups()
    {
        $this->get('/application-groups')->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_view_a_group()
    {
        $data = factory('App\ApplicationGroups')->create();

        $this->get('/application-groups/'. $data->id . '/edit')->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_view_the_edit_page()
    {
        $data = factory('App\ApplicationGroups')->create();

        $this->get('/application-groups/'. $data->id . '/edit')->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_view_the_create_page()
    {
        $this->get('/application-groups/create')->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_add_a_group()
    {
        $data = factory('App\ApplicationGroups')->raw();

        $this->post('/application-groups', $data)->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_edit_a_group()
    {
        $data = factory('App\ApplicationGroups')->create();

        $new_name = 'New name';
        $old_name = $data->name;
        $data->name = $new_name;

        $this->put('/application-groups/' . $data->id, $data->toArray())->assertRedirect('login');
        $this->assertDatabaseHas('application_groups', ['id' => $data->id, 'name' => $old_name]);
    }


    /** @test */
    public function a_guest_user_cant_delete_a_group()
    {

        $data = factory('App\ApplicationGroups')->create();

        $this->delete('/application-groups/' . $data->id, $data->toArray())
            ->assertRedirect('login');

        $this->assertDatabaseHas('application_groups', ['id' => $data->id]);
    }

    /** @test */
    public function a_logged_in_user_can_view_all_groups()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\ApplicationGroups')->create();

        $this->get('/application-groups')->assertSee(e($data->name));
    }


    /** @test */
    public function a_logged_in_user_can_view_a_group()
    {
        $this->withoutExceptionHandling();

        $data = factory('App\ApplicationGroups')->create();

        $this->actingAs(factory('App\User')->create());

        $this->get('/application-groups/'. $data->id . '/edit')
            ->assertSee(e($data->name))
            ->assertSee($data->code);
    }


    /** @test */
    public function a_logged_in_user_can_add_a_group()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\ApplicationGroups')->raw();

        $this->post('/application-groups', $data);

        $this->assertDatabaseHas('application_groups', $data);

        $this->get('/application-groups')->assertSee(e($data['name']));
    }

    /** @test */
    public function a_logged_in_user_can_edit_a_group()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\ApplicationGroups')->create();

        $new_name = 'New name';
        $data->name = $new_name;

        $this->put('/application-groups/' . $data->id, $data->toArray());

        $this->assertDatabaseHas('application_groups', ['id' => $data->id, 'name' => $new_name]);
    }

    /** @test */
    public function a_logged_in_user_can_delete_a_group()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\ApplicationGroups')->create();

        $this->delete('/application-groups/' . $data->id, $data->toArray());

        $this->assertDatabaseMissing('application_groups', ['id' => $data->id]);
    }

    /** @test */
    public function a_logged_in_user_cannot_delete_a_group_with_applications()
    {

        $this->actingAs(factory('App\User')->create());

        $application = factory('App\Applications')->create();

        $group = $application->group;

        $this->delete('/application-groups/' . $group->id)
            ->assertSessionHas('warning');

        $this->assertDatabaseHas('application_groups', ['id' => $group->id]);
    }


    /** @test */
    public function a_group_requires_a_name()
    {

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\ApplicationGroups')->raw(['name' => '']);

        $this->post('/application-groups', $data)->assertSessionHasErrors('name');
    }
}
