<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
    html {
    height: 100%;

    }
    body {
    height: 100%;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    }

        .main {
            padding: 1.25rem;
            max-width: 60rem;
            margin: 0 auto;
        }

        footer {
            background-color: #f9f9f9;
            border-top: 0.05rem solid #e5e5e5;
            font-size: 0.9em;
            padding: 1.5rem 0;
            background: rgba(0, 0, 0, 0.8);
            color: #999;
            font-size: 12px;
            margin-top: auto;
        }
</style>
</head>

<body>
    <div id="app">
        @include('layouts.nav')

        <div class="container main">
            @yield('content')
        </div>
    </div>
    @include('layouts.footer')
</body>
</html>
