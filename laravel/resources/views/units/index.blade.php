@extends('layouts.app')

@section('content')
    <filterable-list
        filter_id="type_id"
        filter_name="code"
        item_name="short_name"
        :pluralize_filters="true"
        :filters="{{ $unit_types }}"
        :items="{{ $units }}">
        Academic units
    </filterable-list>
@endsection
