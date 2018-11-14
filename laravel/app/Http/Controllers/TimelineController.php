<?php

namespace App\Http\Controllers;

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
        $applications = Applications::with('timeline')->get();

        return view('timeline.index')
            ->with('applications', $applications);
    }
}
