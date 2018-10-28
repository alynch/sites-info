@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h2>Applications</h2>
        <div>
        <a class="btn btn-primary" href="/applications/create">Add an application</a>
        </div>
    </div>


    <div class="card-body">
    @foreach ($grouped_applications as $group)
        <div class="card mb-3">
            <div class="card-header">
            {{ $group->name }}
            </div>

        <ul class="list-group list-group-flush">
        @foreach ($group->applications as $application)
            <li class="list-group-item">
                <a href="/applications/{{ $application->id }}/edit">
                {{ $application->name }}
                </a>
                <form class="float-right" method="POST" action="/applications/{{ $application->id }}">
                    @csrf
                    <input type="hidden" name="_method" value="delete"/>
                    <input class="btn btn-danger btn-sm" type="submit" value="Delete">
                </form>
            </li>
        @endforeach
        </ul>
        @if (!$group->applications->count())
            <div class="card-body">
            No applications.
            </div>
        @endif
    </div>
    @endforeach
    </div>
</div>

@endsection
