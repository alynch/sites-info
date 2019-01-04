<?php

namespace App\Http\Controllers;

use App\ApplicationGroups;
use Illuminate\Http\Request;

class ApplicationGroupsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = ApplicationGroups::with('applications')->get();

        return view('application_groups.index')
            ->with('groups', $groups);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $group = new ApplicationGroups;
        return view('application_groups.create')
            ->with('group', $group);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        ApplicationGroups::create($validatedData);

        return redirect('/application-groups');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ApplicationGroups  $group
     * @return \Illuminate\Http\Response
     */
    public function show(ApplicationGroups $group)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ApplicationGroups  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(ApplicationGroups $application_group)
    {
        return view('application_groups.edit')
            ->with('group', $application_group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ApplicationGroups  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApplicationGroups $application_group)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $application_group->update($validatedData);

        return redirect('/application-groups');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApplicationGroups  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplicationGroups $application_group)
    {
        if (!$application_group->applications->count()) {
            $application_group->delete();
        } else {
            session()->flash('warning', "Can't delete application group because it has applications");
        }
        return redirect('/application-groups');
    }
}
