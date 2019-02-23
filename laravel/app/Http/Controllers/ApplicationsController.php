<?php

namespace App\Http\Controllers;

use App\Unit;
use App\Applications;
use App\Feature;
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
            'gitlab_id' => 'nullable',
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
        $features = Feature::all();
        $groups = ApplicationGroups::all();
        $units = Unit::all();

        $units = $units->map(function ($item) {
            $item->selected = false;
            return $item;
        });

        return view('applications.create')
            ->with('groups', $groups)
            ->with('units', $units)
            ->with('features', $features)
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

        $units = request('units', []);
        $application->units()->sync($units);


        return redirect('/applications');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Applications  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Applications $application)
    {
        $application->load('environments', 'features', 'units');

        return view('applications.show')
            ->with('application', $application);
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
        $features = Feature::all();

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

        $units = Unit::with('type')->get();

        $app_units = $application->units;

        $units = $units->map(function ($item) use ($app_units) {
            $item->selected = ($app_units->contains($item)) ? true : false;
            $item->type = $item->type->name;
            return $item;
        });

        return view('applications.edit')
            ->with('units', $units)
            ->with('groups', $groups)
            ->with('environments', $environments)
            ->with('features', $features)
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

        if (request('features')) {
            $features = collect(request('features'));
            $application->features()->sync($features);
        }

        $units = request('units', []);
        $application->units()->sync($units);

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
