@extends('layouts.app')

@section('content')

<form method="POST" action="/features/{{ $feature->id }}">
    @csrf
    <input type="hidden" name="_method" value="patch"/>

    @include('features.form')

</form>

@endsection
