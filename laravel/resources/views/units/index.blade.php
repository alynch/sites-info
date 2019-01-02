@extends('layouts.app')

@section('content')

{{--
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h2>Academic units</h2>


        <ul class="nav nav-pills">
        @foreach ($unit_types as $type)
            <li class="nav-item">
            <a class="nav-link" href="{{ url('/units?filter=' . $type->id )}}">
            {{ $type->code }}s
            </a>
            </li>
        @endforeach
        </ul>
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
--}}

    <filterable-list
        :filters="{{ $unit_types }}"
        :items="{{ $units }}">
    </filterable-list>
@endsection
