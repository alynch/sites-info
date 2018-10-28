@extends('layouts.app')

@section('content')

<form method="POST" action="/environments/{{ $environment->id }}">
    @csrf
    <input type="hidden" name="_method" value="patch"/>

    @include('environments.form')

</form>

@endsection
