@extends('layouts.app')

@section('content')

<form method="POST" action="/environments">
    @csrf
    @include('environments.form', ['title' => 'New Environment'])
</form>
@endsection
