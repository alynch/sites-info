<?php

namespace App\Http\Controllers;

use App\Applications;
use App\Environments;
use App\ApplicationGroups;

use Cache;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ApplicationsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->validationRules = [
            'name' => 'required',
            'group_id' => 'required',
            'description' => 'nullable',
            'env.*' => 'nullable|url'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grouped_applications = ApplicationGroups::with('applications')->get();

        return view('applications.index')
            ->with('grouped_applications', $grouped_applications);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $application = new Applications;
        $environments = Environments::orderBy('sort_order')->get();
        $groups = ApplicationGroups::all();

        return view('applications.create')
            ->with('groups', $groups)
            ->with('environments', $environments)
            ->with('application', $application);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validationRules);

        $application = Applications::create($validatedData);

        if (request('env')) {
            $env = collect(request('env'));
            $env = $env->map(function ($item) {
                if ($item) {
                    return ['url' => $item];
                }
            })->filter();

            $application->environments()->sync($env);
        }

        return redirect('/applications');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Applications  $applications
     * @return \Illuminate\Http\Response
     */
    public function show(Applications $applications)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Applications  $applications
     * @return \Illuminate\Http\Response
     */
    public function edit(Applications $application)
    {
        $environments = Environments::orderBy('sort_order')->get();
        $groups = ApplicationGroups::all();

        $app_env = $application->environments;
        $environments = $environments->map(function ($item) use ($app_env) {
            $url = $app_env->firstWhere('id', $item->id);
            if ($url) {
                $item->url = $url->pivot->url;
            }
            return $item;
        });

        return view('applications.edit')
            ->with('groups', $groups)
            ->with('environments', $environments)
            ->with('application', $application);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Applications  $applications
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Applications $application)
    {

        $validatedData = $request->validate($this->validationRules);

        $application->update($validatedData);

        if (request('env')) {
            $env = collect(request('env'));
            $env = $env->map(function ($item) {
                if ($item) {
                    return ['url' => $item];
                }
            })->filter();

            $application->environments()->sync($env);
        }
        return redirect('/applications');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Applications  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Applications $application)
    {
        $application->delete();

        return redirect('/applications');
    }
    
    public function status($id)
    {

        $application = Applications::with('environments')->find($id);


        $minutes = 10;
            foreach ($application->environments as $environment) {
                if ($environment->pivot->url) {
                    $environment->status =
                        Cache::remember($environment->pivot->url, $minutes, function () use ($environment) {
                            return $this->checkSite($environment->pivot->url);
                        });

                    $response = new StreamedResponse(function () use ($environment) {
                        ob_flush();
                        flush();
                        echo 'data: ' . $environment . "\n\n";
                    });
                }
            }

        $response->headers->set('Content-Type', 'text/event-stream');
        return $response;
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
