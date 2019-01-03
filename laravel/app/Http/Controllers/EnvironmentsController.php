<?php

namespace App\Http\Controllers;

use App\Environments;
use Illuminate\Http\Request;

use App\Http\Requests\EnvironmentsForm;

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
        $environments = Environments::with('applications')->orderBy('sort_order')->get();

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
    public function store(EnvironmentsForm $request)
    {
        $validatedData = $request->validated();
        Environments::create($validatedData);

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
    public function update(EnvironmentsForm $request, Environments $environment)
    {
        $validatedData = $request->validated();

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
        if (!$environment->applications->count()) {
            $environment->delete();
        } else {
            session()->flash('warning', "Can't delete environment being used by applications");
        }

        return redirect('/environments');
    }
}
