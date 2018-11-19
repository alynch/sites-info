<?php

namespace App\Http\Controllers;

use App\Applications;
use App\Environments;
use App\ApplicationGroups;

use Cache;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function status($id)
    {

        $application = Applications::with('environments')->find($id);

        $minutes = 10;
        foreach ($application->environments as $environment) {
            if ($environment->pivot->url) {
                $environment->status =
                    Cache::remember($environment->pivot->url, $minutes, function () use ($environment) {
                        $s = new \App\SiteInfo($environment->pivot->url);
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
}
