@extends('layouts.app')

@section('content')

<form method="POST" action="/features">
    @csrf
    @include('features.form', ['title' => 'New Feature'])
</form>
@endsection
