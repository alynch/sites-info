@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h2>Environments</h2>
        <div>
            <a class="btn btn-primary" href="/environments/create">Add an environment</a>
        </div>
    </div>

    <ul class="list-group list-group-flush">
        @foreach ($environments as $environment)
            <li class="list-group-item">
                <a href="/environments/{{ $environment->id }}/edit">
                     {{ $environment->name }}</a>
                ({{ $environment->code }})

                @if (!$environment->applications->count())
                <form method="POST" class="float-right" action="/environments/{{ $environment->id }}">
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
