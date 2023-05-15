<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

    <head>
        <!-- BEGIN: Meta-data -->
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="keywords" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- END: Meta-data -->

        <!-- BEGIN: Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/icons/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/icons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/icons/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('assets/images/icons/site.webmanifest') }}">
        <link rel="mask-icon" href="{{ asset('assets/images/icons/safari-pinned-tab.svg') }}" color="#666666">
        <link rel="shortcut icon" href="{{ asset('assets/images/icons/favicon.ico') }}">
        <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="msapplication-TileColor" content="#cc9966">
        <meta name="msapplication-config" content="{{ asset('assets/images/icons/browserconfig.xml') }}">
        <meta name="theme-color" content="#ffffff">
        <!-- END: Favicon -->

        <title>{{ $title }} - {{ config('app.name') }}</title>

        @stack('master.styles')

        <!-- BEGIN: Custom CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/global.css") }}">
        <!-- END: Custom CSS-->
    </head>

    <body>
        @yield('master.body')

        @stack('master.scripts')

        <!-- BEGIN: Custom JS-->
        <script src="{{ asset("assets/js/global.js") }}"></script>
        <!-- END: Custom JS-->
    </body>

</html>

