@extends('layouts.app')

@section('content')

<form method="POST" action="/application-groups">
    @csrf

    @include('application_groups.form', ['title' => 'New application group'])

</form>
@endsection
