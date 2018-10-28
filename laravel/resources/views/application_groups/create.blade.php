@extends('layouts.app')

@section('content')

<h1>New application group</h1>

<form method="POST" action="/application-groups">
    @csrf

    @include('application_groups.form')

</form>
@endsection
