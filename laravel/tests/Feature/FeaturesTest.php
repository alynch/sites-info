<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\ValidatesFields;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeaturesTest extends TestCase
{
    use RefreshDatabase;
    use ValidatesFields;

    /** @test */
    public function a_guest_user_cant_view_the_features()
    {
        $this->get('/features')->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_view_an_feature()
    {
        $data = factory('App\Feature')->create();

        $this->get('/features/'. $data->id)->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_view_the_edit_page()
    {
        $data = factory('App\Feature')->create();

        $this->get('/features/'. $data->id . '/edit')->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_view_the_create_page()
    {
        $this->get('/features/create')->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_add_an_feature()
    {
        $data = factory('App\Feature')->raw();

        $this->post('/features', $data)->assertRedirect('login');
    }

    /** @test */
    public function a_guest_user_cant_edit_an_feature()
    {
        $data = factory('App\Feature')->create();

        $new_name = 'New name';
        $old_name = $data->name;
        $data->name = $new_name;

        $this->put('/features/' . $data->id, $data->toArray())->assertRedirect('login');
        $this->assertDatabaseHas('features', ['id' => $data->id, 'name' => $old_name]);
    }

    /** @test */
    public function a_guest_user_cant_delete_an_feature()
    {

        $data = factory('App\Feature')->create();

        $this->delete('/features/' . $data->id, $data->toArray())
            ->assertRedirect('login');

        $this->assertDatabaseHas('features', ['id' => $data->id]);
    }

    /** @test */
    public function a_logged_in_user_can_view_all_features()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Feature')->create();

        $this->get('/features')
            ->assertViewIs('features.index')
            ->assertViewHas('features')
            ->assertSee(e($data->name));
    }


    /** @test */
    public function a_user_view_an_feature()
    {
        $this->withoutExceptionHandling();

        $data = factory('App\Feature')->create();

        $this->actingAs(factory('App\User')->create());

        $this->get('/features/'. $data->id . '/edit')
            ->assertSee(e($data->name))
            ->assertSee($data->type);
    }


    /** @test */
    public function a_logged_in_user_can_add_an_feature()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Feature')->raw();

        $this->post('/features', $data)
            ->assertRedirect('/features');

        $this->assertDatabaseHas('features', $data);

        $this->get('/features')->assertSee(e($data['name']));
    }

    /** @test */
    public function a_logged_in_user_can_edit_an_feature()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Feature')->create();

        $new_name = 'New name';
        $data->name = $new_name;

        $this->put('/features/' . $data->id, $data->toArray());

        $this->assertDatabaseHas('features', ['id' => $data->id, 'name' => $new_name]);
    }

    /** @test */
    public function a_logged_in_user_can_delete_an_feature()
    {

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $data = factory('App\Feature')->create();

        $this->delete('/features/' . $data->id, $data->toArray());

        $this->assertDatabaseMissing('features', ['id' => $data->id]);
    }


    /** @test */
    public function a_logged_in_user_cannot_delete_an_feature_used_in_applications()
    {

        $this->actingAs(factory('App\User')->create());

        $application = factory('App\Applications')->create();

        $feature = factory('App\Feature')->create();

        $application->features()->sync($feature->id);

        $this->delete('/features/' . $feature->id)
            ->assertSessionHas('warning');

        $this->assertDatabaseHas('features', ['id' => $feature->id]);
    }


    /* Validations */

    /** @test */
    public function an_feature_requires_a_name()
    {
        $this->validate('App\Feature', '/features', 'name');
    }

    /** @test */
    public function an_feature_requires_a_type()
    {
        $this->validate('App\Feature', '/features', 'type');
    }
}
