<?php

namespace Tests\Feature;

use GuzzleHttp\Client;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SiteInfoTest extends TestCase
{
    use RefreshDatabase;

    protected $mock;

    public function setUp()
    {
        parent::setUp();

        $this->mock = $this->createMock(\GuzzleHttp\Client::class);
        //$this->mock = \GuzzleHttp\Client::class;
    }

    /** @test */
    public function a_logged_in_user_can_view_an_application_status()
    {
        $this->actingAs(factory('App\User')->create());
        $data = factory('App\Applications')->create();

        $this->get('/applications/'. $data->id . '/status')->assertOk();
    }
}
