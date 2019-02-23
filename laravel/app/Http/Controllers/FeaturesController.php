<?php

namespace App\Http\Controllers;

use App\Feature;
use Illuminate\Http\Request;
use App\Http\Requests\FeaturesForm;

class FeaturesController extends Controller
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
        $features = Feature::get();
        
        return view('features.index')
            ->with('features', $features);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $feature = new Feature;
        return view('features.create')
            ->with('feature', $feature);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeaturesForm $request)
    {
        $validatedData = $request->validated();
        Feature::create($validatedData);

        return redirect('/features');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function edit(Feature $feature)
    {
        return view('features.edit')
            ->with('feature', $feature);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function update(FeaturesForm $request, Feature $feature)
    {
        $validatedData = $request->validated();

        $feature->update($validatedData);

        return redirect('/features');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feature $feature)
    {
        if (!$feature->applications->count()) {
            $feature->delete();
        } else {
            session()->flash('warning', "Can't delete feature being used by applications");
        }
 
        return redirect('/features');
    }
}
