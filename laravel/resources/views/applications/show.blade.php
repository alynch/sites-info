@extends('layouts.app')

@section('content')

<div class="card mb-3">
    <div class="card-header">
        <h5>
            {{ $application->name }}
        </h5>
    </div>

    <div class="card-body">

        <div class="form-group">
            {{ $application->description }}
        </div>

        <p>    
        Application type: {{ $application->group->name }}
        </p>


        <strong>Environments:</strong>
        <ul>
        @foreach ($application->environments as $environment)
            <li>
                {{ $environment->name }}
            {{ $environment->pivot->url }}
            </li>
        @endforeach
        </ul>

        <strong>Peak periods:</strong>
        <ul>
        @foreach ($application->timeline as $time)
            <li>
            From
            {{ $time->start_day }}
            {{ date('F', mktime(0, 0, 0, $time->start_month, 10)) }}

           to 
            {{ $time->end_day }}
            {{ date('F', mktime(0, 0, 0, $time->end_month, 10)) }}
            </li>
        @endforeach
        </ul>

        <strong>Units that use this application:</strong>
        <ul style="columns: 3">
        @foreach ($application->units as $unit)
            <li>
                {{ $unit->name }}
            </li>
        @endforeach
        </ul>
    </div>
</div>

@endsection
