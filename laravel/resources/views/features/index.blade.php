@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h2>Features</h2>
        <div>
            <a class="btn btn-primary" href="/features/create">Add a feature</a>
        </div>
    </div>

    <ul class="list-group list-group-flush">
        @foreach ($features as $feature)
            <li class="list-group-item">
                <a href="/features/{{ $feature->id }}">
                     {{ $feature->name }}</a>
                ({{ $feature->type }})

                @if (!$feature->applications->count())
                <form method="POST" class="float-right" action="/features/{{ $feature->id }}">
                    @csrf
                    <input type="hidden" name="_method" value="delete"/>
                    <input class="btn btn-danger btn-sm" type="submit" value="Delete">
                </form>
                @endif

            </li>
        @endforeach
    </ul>
</div>
@endsection
