<?php

namespace App\Http\Controllers;

use App\Unit;
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

        $validatedData['all_year'] = ($request->input('all_year')) ? 1 : 0;

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

        $periods = collect(request('period'));
        foreach ($periods as $id => $period) {
            if ($id < 0) {
                $application->timeline()->create($period);
            } else {
                $timeline = \App\Timeline::find($id);
                $timeline->update($period);
            }
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

        // Get coordinates for graph
        $application->load('timeline');
        foreach ($application->timeline as $period) {
            $period->range = $period->getRange();
        }
        $application->load('units');

        $app_env = $application->environments;
        $environments = $environments->map(function ($item) use ($app_env) {
            $url = $app_env->firstWhere('id', $item->id);
            if ($url) {
                $item->url = $url->pivot->url;
            }
            return $item;
        });

        $units = Unit::all();
        $app_units = $application->units;

        $units = $units->map(function ($item) use ($app_units) {
            $item->selected = ($app_units->contains($item)) ? true : false;
            return $item;
        });

        return view('applications.edit')
            ->with('units', $units)
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

        $validatedData['all_year'] = ($request->input('all_year')) ? 1 : 0;

        $application->update($validatedData);

        $periods = collect(request('period'));

        foreach ($periods as $id => $period) {
            if ($id < 0) {
                $application->timeline()->create($period);
            } else {
                $timeline = \App\Timeline::find($id);
                $timeline->update($period);
            }
        }

        if (request('env')) {
            $env = collect(request('env'));
            $env = $env->map(function ($item) {
                if ($item) {
                    return ['url' => $item];
                }
            })->filter();

            $application->environments()->sync($env);
        }

        if (request('units')) {
            $units = request('units');

            $application->units()->sync($units);
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
}
