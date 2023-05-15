@extends('layouts.main', compact('title'))

@section('master.body')
    @yield('body')
@endsection

@push('master.styles')
    <!-- BEGIN: Other -->
    @stack('other.styles')
    <!-- END: Other -->

    <!-- BEGIN: Plugins CSS-->
    <link rel="stylesheet" href="{{ asset("assets/css/bootstrap.min.css") }}">
    @stack('plugins.styles')
    <!-- END: Plugins CSS-->

    <!-- BEGIN: Main CSS-->
    <link rel="stylesheet" href="{{ asset("assets/css/style.css") }}">
    @stack('main.styles')
    <!-- END: Main CSS-->
@endpush

@push('master.scripts')
    <!-- BEGIN: Plugins JS-->
    <script src="{{ asset("assets/js/jquery.min.js") }}"></script>
    <script src="{{ asset("assets/js/bootstrap.bundle.min.js") }}"></script>
    @stack('plugins.scripts')
    <!-- END: Plugins JS-->

    <!-- BEGIN: Main JS-->
    <script src="{{ asset("assets/js/main.js") }}"></script>
    @stack('main.scripts')
    <!-- END: Main JS-->
@endpush