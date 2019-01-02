@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-header">
        {{ $unit->name }}
    </div>
    <div class="card-body">
        <ul>
        @foreach ($unit->applications as $application)
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
