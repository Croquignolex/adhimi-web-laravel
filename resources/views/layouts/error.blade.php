@extends('layouts.main', compact('title'))

@push('master.page.styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/css/pages/page-misc.css") }}">
@endpush

@push('master.body.class', 'blank-page')

@section('master.body')
    <!-- BEGIN: Content-->
    @yield('content')
    <!-- END: Content-->
@endsection