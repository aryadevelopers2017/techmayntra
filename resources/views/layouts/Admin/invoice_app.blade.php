<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TechMayntra Service PVT LTD</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src=" {{ asset('asset/css/jquery.min.js') }}"></script>
    <!-- Styles -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
    <!-- Standard iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
    <!-- Standard iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">
    <!-- Styles -->
    <link href="{{ asset('asset/css/lib/data-table/buttons.bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('asset/css/lib/calendar2/pignose.calendar.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/css/lib/chartist/chartist.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('asset/css/lib/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/css/lib/themify-icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/css/lib/owl.carousel.min.css') }}" rel="stylesheet" type="text/css" / />
    <link href="{{ asset('asset/css/lib/owl.theme.default.min.css') }}" rel="stylesheet" type="text/css" / />
    <link href="{{ asset('asset/css/lib/weather-icons.css') }}" rel="stylesheet" type="text/css" / />
    <link href="{{ asset('asset/css/lib/menubar/sidebar.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/css/lib/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/css/lib/helper.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('asset/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    @yield('content')
    @include('layouts.Admin.footer')
</body>
</html>
