@extends('layouts.app')

@section('content')
    <dashboard-component
        :groups="{{ $groups }}"
        :items="{{ $sites }}">
    </dashboard-component>

    <div>
        <form method="POST" action="/applications/clear">
            @csrf
            <button type="submit" class="btn btn-secondary">Refresh cache</a>
        </form>
    </div>
@endsection
