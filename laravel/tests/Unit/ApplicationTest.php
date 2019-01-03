<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_application_can_have_environments()
    {
        $application = factory('App\Applications')->create();

        $environment = factory('App\Environments')->create();

        $application->environments()->sync($environment->id);

        $this->assertEquals(1, $application->environments->count());
    }
}
