@extends('layouts.app')

@section('content')

<form method="POST" action="/application-groups/{{ $group->id }}">
    @csrf
    <input type="hidden" name="_method" value="patch"/>

    @include('application_groups.form')
</form>
@endsection
