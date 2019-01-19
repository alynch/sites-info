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

        $mysql = 'mysql -V';
        $process = new Process($mysql);
        $process->run();

        $data['mysql_version']  = $process->getOutput();

        $data['php_version'] =  phpversion();
        $data['apache_version'] = apache_get_version();

        /*
        $data['sapi'] = php_sapi_name();
        $data['user'] = php_uname();
        */

        $data['laravel_version'] = app()->version();

        return $data;
    }
}
