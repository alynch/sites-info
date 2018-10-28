<?php

namespace App\Http\Controllers;

use App\Environments;
use Illuminate\Http\Request;

class EnvironmentsController extends Controller
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
        $environments = Environments::orderBy('sort_order')->get();

        return view('environments.index')
            ->with('environments', $environments);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $environment = new Environments;
        return view('environments.create')
            ->with('environment', $environment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Environments::create(request()->all());

        return redirect('/environments');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Environments  $environment
     * @return \Illuminate\Http\Response
     */
    public function show(Environments $environment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Environments  $environments
     * @return \Illuminate\Http\Response
     */
    public function edit(Environments $environment)
    {
        return view('environments.edit')
            ->with('environment', $environment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Environments  $environment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Environments $environment)
    {
        $environment->update(request()->all());

        return redirect('/environments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Environments  $environment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Environments $environment)
    {
        $environment->delete();

        return redirect('/environments');
    }
}
