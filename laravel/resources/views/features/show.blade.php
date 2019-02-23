@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex justify-content-between">
        <h5>
            {{ $feature->name }}
        </h5>
        <a class="btn btn-primary" href="{{url('features/' . $feature->id . '/edit') }}">Edit</a>
    </div>

    <div class="card-body">
        <ul>
        @foreach ($feature->applications as $application)
            <li>
                <a href="{{ url('/applications/' . $application->id) }}">
                {{ $application->name }}
                </a>
            </li>
        @endforeach
        </ul>
    </div>
</div>


@endsection
