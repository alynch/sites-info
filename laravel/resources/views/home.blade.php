@extends('layouts.app')

<style>
.grid {
    margin: 2em 0;
    display: grid;
    grid-template-columns: repeat(auto-fill, 20em);
    grid-gap: 1rem;
    justify-content: space-around;

}
</style>


@section('content')
    <dashboard-component
        :items="{{ $sites }}">
    </dashboard-component>

    <div>
        <form method="POST" action="/applications/clear">
            @csrf
            <button type="submit" class="btn btn-secondary">Clear cache</a>
        </form>
    </div>
@endsection
