<?php

namespace App\Http\Controllers;

use App\Unit;
use App\UnitType;
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
        $this->middleware('auth')->except('update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::with('applications')->orderBy('name')->get();

        $unit_types = UnitType::all();

        return view('units.index')
            ->with('unit_types', $unit_types)
            ->with('units', $units);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        $unit->load('applications');

        return view('units.show')
            ->with('unit', $unit);
    }

    /**
     * Update the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->get('unit');

        switch ($request->get('event')) {
            case 'create':
                Unit::create($data);
                break;
            case 'update':
                $unit = Unit::where('code', $data['code'])->firstOrFail();
                $r = $unit->update($data);
                break;
            case 'delete':
                $unit = Unit::where('code', $data['code'])->firstOrFail();
                $unit->delete();
                break;
        }
        //$current_unit = Unit::updateOrCreate(['id' => $unit['id']], $unit);

        return response()->json(['message' => 'Unit was updated.'], 200);
    }
}
