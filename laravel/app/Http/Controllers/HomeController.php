<?php

namespace App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = \App\Applications::with('environments')->orderBy('name')
            ->get();

        $minutes = 10;

        foreach ($sites as $site) {
            foreach ($site->environments as $environment) {
                \Log::info($environment->pivot->url);
                if ($environment->pivot->url) {
                    $environment->status =
                        Cache::remember($environment->pivot->url, $minutes, function () use ($environment) {
                            return $this->checkSite($environment->pivot->url);
                        });
                }
                if ($environment->code == 'prod') {
                    $site->url = $environment->pivot->url;
                    $site->status = $environment->status;
                }
            }
            $site->secondary = $site->environments->filter(function ($value) {
                return $value->code != 'prod';
            });
        }

    /*
        foreach ($sites as $site) {
            $site->status = Cache::remember($site->url, $minutes, function () use ($site) {
                return $this->checkSite($site->url);
            });
    }
    */

        return view('home')
            ->with('sites', $sites);
    }

    protected function checkSite($site)
    {

        $info = [];
        try {
            $client = new \GuzzleHttp\Client(['base_url' => $site]);
            $response = $client->get($site);

            if ($response) {
                $info['running'] = true;
                $info['ip'] = gethostbyname(preg_replace('#^https?://#', '', rtrim($site, '/')));
                $headers = ['Server', 'X-Powered-By'];
                foreach ($headers as $header) {
                    if ($value = $response->getHeader($header)) {
                        $info['headers'][$header] = $value;
                    }
                }
                try {
                    $response = $client->get($site . '/version');
                    if ($response->getStatusCode() == '200') {
                        $info['details'] = json_decode($response->getBody(), true);
                    }
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    //
                }
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            $info['ip'] = '';
            $info['running'] = false;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            if ($e->getResponse()) {
                $host = $e->getRequest()->getUri()->getHost();
                $info['ip'] = gethostbyname($host);
                $info['running'] = true;
            } else {
                $info['ip'] = '';
                $info['running'] = false;
            }
        }
        return $info;
    }
}
