@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h2>Academic units</h2>
    </div>

    <ul class="list-group list-group-flush">
        @foreach ($units as $unit)
            <li class="list-group-item">
                @if ($unit->applications->count() > 0)
                    <a href="/units/{{ $unit->id }}">
                        {{ $unit->name }}</a>
                    <span class="badge badge-pill badge-secondary">{{ $unit->applications->count() }}</span>
                @else
                        {{ $unit->name }}</a>
                @endif
            </li>
        @endforeach
    </ul>
</div>
@endsection
