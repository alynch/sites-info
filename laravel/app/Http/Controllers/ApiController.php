<?php

namespace App\Http\Controllers;

use App\Applications;
use App\Environments;
use App\ApplicationGroups;

use GuzzleHttp\Client;

use Cache;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Process\Process;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('info');
    }

    public function status($id)
    {

        $application = Applications::with('environments')->find($id);

        $minutes = 10;
        foreach ($application->environments as $environment) {
            if ($environment->pivot->url) {
                $environment->status =
                    Cache::remember($environment->pivot->url, $minutes, function () use ($environment) {
                        $s = new \App\SiteInfo($environment->pivot->url, Client::class);
                        return $s->checkSite();
                    });
            }
        }

        $response = new StreamedResponse(function () use ($application) {
            ob_flush();
            flush();
            echo 'data: ' . $application->environments . "\n\n";
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        return $response;
    }
    
    public function clear()
    {
        Cache::flush();

        return back();
    }

    public function info()
    {
        $data['mysql_version'] = $this->getDbVersion();
        $data['php_version'] = $this->getPhpVersion();
        $data['laravel_version'] = $this->getLaravelVersion();
        $data['apache_version'] = $this->getWebServerVersion();

        return $data;
    }

    private function getWebServerVersion()
    {
        if (!function_exists('apache_get_version')) {
            function apache_get_version()
            {
                if (!isset($_SERVER['SERVER_SOFTWARE']) || strlen($_SERVER['SERVER_SOFTWARE']) == 0) {
                    return false;
                }
                return $_SERVER["SERVER_SOFTWARE"];
            }
        }
        return apache_get_version();
    }


    private function getDbVersion()
    {
        $pdo     = \DB::connection()->getPdo();
        $version = $pdo->query('select version()')->fetchColumn();
        return $version;
    }

    private function getPhpVersion()
    {
        /*
        $data['sapi'] = php_sapi_name();
        $data['user'] = php_uname();
        */
        return phpversion();
    }

    private function getLaravelVersion()
    {
        return app()->version();
    }
}
