<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="Description" content="Site to track IIT applications">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body>
    <div id="app">
        @include('layouts.nav')


        <div class="container main">

            @if(Session::has('warning'))
                <p class="alert alert-warning">{{ Session::get('warning') }}</p>
            @endif

            @yield('content')
        </div>
    </div>
    @include('layouts.footer')
</body>
</html>
