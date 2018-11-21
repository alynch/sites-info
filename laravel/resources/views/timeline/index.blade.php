@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h2>Timeline</h2>
    </div>


    <div class="card-body">
        <timeline-dashboard
            :applications="{{ $applications }}" >
        </timeline-dashboard>
    </div>
</div>

@endsection
