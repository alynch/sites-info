@extends('layouts.app')

@section('content')

<?php
    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h2>Timeline</h2>
    </div>


    <div class="card-body">
        <div class="range-box" style="margin-left: 15.6em; display: flex">
            @foreach ($months as $key => $month)
                <span style="width: 8.333%; border-left: 1px solid #ccc; text-align: center">{{$month }}</span>
            @endforeach
        </div>

        @foreach ($applications as $application)
            <div style="display: flex">
                <span style="width: 12em">{{ $application->name }}</span>
                <div class="range-box">
                    @foreach ($application->timeline as $period)
                    <div class="range" style="left: {{ $period->getRange()['start'] }}px; width: {{$period->getRange()['width']}}px;"> 
                    </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
