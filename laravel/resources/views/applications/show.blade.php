@extends('layouts.app')

@section('content')

<div class="card mb-3">
    <div class="card-header d-flex justify-content-between">
        <h5>
            {{ $application->name }}
        </h5>
        <a class="btn btn-primary" href="{{url('applications/' . $application->id . '/edit') }}">Edit</a>
    </div>

    <div class="card-body">

        <div class="form-group">
            {{ $application->description }}
        </div>

        <p>    
        <strong>Application type:</strong>
             {{ $application->group->name }}
        </p>


        <strong>Environments:</strong>
        <ul>
        @foreach ($application->environments as $environment)
            <li>
                {{ $environment->name }}:
                <a href="{{ $environment->pivot->url }}">
                {{ $environment->pivot->url }}
                </a>
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
        <ul class="columnar">
        @foreach ($application->units as $unit)
            <li>
                {{ $unit->name }}
            </li>
        @endforeach
        </ul>

        <strong>Releases:</strong>

        @if ($application->releases->count())
        <table class="table">
        @foreach ($application->releases as $release)
            <tr>
                <td>{{ $release->name }}</td>
                <td>{{ $release->date }}</td>
            <tr>
        @endforeach
        </table>
        @else
            <p> N/A </p>
        @endif
    </div>
</div>
@endsection
