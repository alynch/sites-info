<?php

namespace Tests\Unit;

use GuzzleHttp\Client;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class SiteInfoTest extends TestCase
{

    protected $mock;

    public function setUp()
    {
        parent::setUp();
        $this->mock = $this->createMock(\GuzzleHttp\Client::class);
    }

    /** @test */
    public function a_site_needs_a_valid_url()
    {
        $url = "http://example.com";
        $site = new \App\SiteInfo($url, $this->mock);
        $this->assertEquals($url, $site->getUrl());
    }

    /** @test */
    public function a_site_fails_with_an_invalid_url()
    {

        $this->withoutExceptionHandling();
        $url = '';
        $this->expectException('\Exception');
        $site = new \App\SiteInfo($url, $this->mock);
    }

    /** @test */
    public function get_header_info_from_site()
    {
        $this->withoutExceptionHandling();
        $url = "https://corpora.chass.utoronto.ca";
        $site = new \App\SiteInfo($url, \GuzzleHttp\Client::class);

        $response = [
            "running" => true,
            "ip" => "128.100.160.77",
            "headers" =>  [
                0 =>  [
                    "name" => "Server",
                    "value" => "Apache"
                ],
                1 =>  [
                    "name" => "X-Powered-By",
                    "value" => "PHP/5.5.25"
                ],
                2 =>  [
                    "name" => "SSL cert. expires on",
                    "value" => "2019-11-27"
                ]
            ],
            "details" => ""
        ];


        $this->assertEquals($response, $site->checkSite());


        //$this->assertInstanceOf(\App\SiteInfo::class, $site);
    }
}
