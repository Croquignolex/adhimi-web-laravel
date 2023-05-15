@extends('layouts.main', compact('title'))

@push('master.vendor.styles')
    @stack('vendor.styles')
@endpush

@push('master.page.styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/pages/page-auth.css") }}">
@endpush

@push('master.body.class', 'blank-page')

@section('master.body')
    <!-- BEGIN: Content-->
    @yield('content')
    <!-- END: Content-->
@endsection

@push('master.vendor.scripts')
    @stack('vendor.scripts')
@endpush