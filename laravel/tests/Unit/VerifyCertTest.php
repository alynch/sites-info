<?php

namespace Tests\Unit;

use App\Cert;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerifyCertTest extends TestCase
{
    /** @test */
    public function testgetAValidExpirationDate()
    {
        $this->withoutExceptionHandling();
        $cert = new Cert("https://example.com");
        $expirationDate = $cert->getExpirationDate();
       
        $this->assertStringMatchesFormat('%d%d%d%d-%d%d-%d%d', $expirationDate);
    }
}
