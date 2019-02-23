@extends('layouts.app')

@section('content')


<form method="POST" action="/applications">
    @csrf

    @include('applications.form', ['title' => 'New application'])

</form>
@endsection
