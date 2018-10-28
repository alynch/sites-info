@extends('layouts.app')

@section('content')


<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h2>Application groups</h2>
        <div>
            <a class="btn btn-primary" href="/application-groups/create">Add an application group</a>
        </div>
    </div>

    <ul class="list-group list-group-flush">
        @foreach ($groups as $group)
            <li class="list-group-item">
                <a href="/application-groups/{{ $group->id }}/edit">
                     {{ $group->name }}
                </a>
                @if (!$group->applications->count())
                <form method="POST" class="float-right" action="/application-groups/{{ $group->id }}">
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
