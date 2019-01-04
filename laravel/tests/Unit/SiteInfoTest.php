<?php

namespace Tests\Unit;

use GuzzleHttp\Client;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SiteInfoTest extends TestCase
{

    /** @test */
    public function a_site_needs_a_valid_url()
    {
        $mock = $this->createMock(\GuzzleHttp\Client::class);

        $url = "http://example.com";
        $site = new \App\SiteInfo($url, $mock);
        $this->assertEquals($url, $site->getUrl());
    }

    /** @test */
    public function a_site_fails_with_an_invalid_url()
    {
        $mock = $this->createMock(\GuzzleHttp\Client::class);

        $this->withoutExceptionHandling();
        $url = '';
        $this->expectException('\Exception');
        $site = new \App\SiteInfo($url, $mock);
    }

    /** @test */
    public function get_header_info_from_site()
    {
        $mock = $this->createMock(\GuzzleHttp\Client::class);
        $this->withoutExceptionHandling();
        $url = "https://corpora.chass.utoronto.ca";
        $site = new \App\SiteInfo($url, $mock);

        $this->assertInstanceOf(\App\SiteInfo::class, $site);
    }
}
