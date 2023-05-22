@extends('layouts.main', compact('title'))

@section('master.body')
    <!-- BEGIN: Header-->
    @include('partials.backoffice.admin.header', compact('title', 'breadcrumb_items'))
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    @include('partials.backoffice.admin.sidebar')
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    @yield('content')
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    @include('partials.backoffice.footer')
    <!-- END: Footer-->
@endsection

@push('master.styles')
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/vendors/css/vendors.min.css") }}">
    @stack('vendor.styles')
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
    @stack('page.styles')
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/css/master.css") }}">
    @stack('custom.styles')
    <!-- END: Custom CSS-->
@endpush

@push('master.body.class', 'vertical-layout vertical-menu-modern dark-layout navbar-floating footer-static')

@push('master.body.data-layout', 'dark-layout')

@push('master.scripts')
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset("app-assets/vendors/js/vendors.min.js") }}"></script>
    @stack('vendor.scripts')
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset("app-assets/js/core/app-menu.js") }}"></script>
    <script src="{{ asset("app-assets/js/core/app.js") }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Custom JS-->
    <script src="{{ asset("app-assets/js/master.js") }}"></script>
    @stack('custom.scripts')
    <!-- END: Custom JS-->
@endpush