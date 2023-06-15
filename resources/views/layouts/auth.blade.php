@extends('layouts.main', compact('title'))

@section('master.body')
    <!-- BEGIN: Content-->
    @yield('content')
    <!-- END: Content-->
@endsection

@push('master.styles')
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/vendors/css/vendors.min.css") }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/css/bootstrap.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/css/bootstrap-extended.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/css/colors.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/css/components.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/css/themes/dark-layout.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/css/themes/bordered-layout.css") }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/css/core/menu/menu-types/vertical-menu.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/css/pages/page-auth.css") }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset("custom/css/main.css") }}">
    <!-- END: Custom CSS-->
@endpush

@push('master.body.class')
    @stack('body.class')
@endpush

@push('master.body.data-layout')
    @stack('body.data-layout')
@endpush

@push('master.body.data-col')
    @stack('body.data-col')
@endpush

@push('master.scripts')
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset("app-assets/vendors/js/vendors.min.js") }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset("app-assets/js/core/app-menu.js") }}"></script>
    <script src="{{ asset("app-assets/js/core/app.js") }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Custom JS-->
    <script src="{{ asset("custom/js/main.js") }}"></script>
    <!-- END: Custom JS-->
@endpush