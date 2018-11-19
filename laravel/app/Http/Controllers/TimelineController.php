<?php

namespace App\Http\Controllers;

use App\Timeline;
use App\Applications;
use App\Environments;
use App\ApplicationGroups;

use Illuminate\Http\Request;

class TimelineController extends Controller
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
        //$applications = Applications::with('timeline')->has('timeline')->get();
        $applications = Applications::with('timeline')
            ->orderBy('name')->get();

        return view('timeline.index')
            ->with('applications', $applications);
    }

    public function destroy($id)
    {
        $timeline = Timeline::find($id);
        $timeline->delete();
    }
}
