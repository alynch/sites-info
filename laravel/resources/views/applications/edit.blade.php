@extends('layouts.app')

@section('content')

<form method="POST" action="/applications/{{ $application->id }}">
    @csrf
    <input type="hidden" name="_method" value="patch"/>

    @include('applications.form')
</form>
@endsection
