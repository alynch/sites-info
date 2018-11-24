<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;

class UnitsController extends Controller
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
        $units = Unit::all();

        return view('units.index')
            ->with('units', $units);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Environments  $environment
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        $unit->load('applications');

        return view('units.show')
            ->with('unit', $unit);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Environments  $environments
     * @return \Illuminate\Http\Response
     */
    public function edit(Environments $environment)
    {
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
        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',
            'sort_order' => 'required',
        ]);

        $environment->update($validatedData);

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
