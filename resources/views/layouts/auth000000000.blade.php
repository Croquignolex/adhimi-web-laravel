@extends('layouts.main', compact('title'))

@section('master.body')
    <!-- BEGIN: Content-->
    @yield('content')
    <!-- END: Content-->
@endsection

@push('master.styles')
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/vendors/css/vendors.min.css") }}">
    @stack('vendor.styles')
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/bootstrap.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/bootstrap-extended.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/colors.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/components.css") }}">
    @stack('theme.styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/themes/dark-layout.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/themes/bordered-layout.css") }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/core/menu/menu-types/vertical-menu.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/pages/page-auth.css") }}">
    @stack('page.styles')
    <!-- END: Page CSS-->
@endpush

@push('master.body.class')
    @stack('body.data')
@endpush

@push('master.body.data')
    @stack('body.data')
@endpush

@push('master.scripts')
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset("assets/vendors/js/vendors.min.js") }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    @stack('vendor.scripts')
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset("assets/js/core/app-menu.js") }}"></script>
    <script src="{{ asset("assets/js/core/app.js") }}"></script>
    <!-- END: Theme JS-->
@endpush