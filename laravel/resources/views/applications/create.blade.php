@extends('layouts.app')

@section('content')

<h1>New Application</h1>

<form method="POST" action="/applications">
    @csrf

    @include('applications.form')

</form>
@endsection
