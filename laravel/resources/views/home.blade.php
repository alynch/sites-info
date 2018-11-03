@extends('layouts.app')

<style>
.grid {
    margin-top: 2em;
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
@endsection
