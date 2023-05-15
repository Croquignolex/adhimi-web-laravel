@extends('layouts.main', compact('title'))

@push('master.vendor.styles')
    @stack('vendor.styles')
@endpush

@push('master.page.styles')
    @stack('page.styles')
@endpush

@push('master.styles')
    @stack('custom.styles')
@endpush

@section('master.body')
    <!-- BEGIN: Header-->
    @include('partials.header', compact('title', 'breadcrumb_items'))
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    @include('partials.sidebar')
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    @yield('content')
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    @include('partials.footer')
    <!-- END: Footer-->
@endsection

@push('master.vendor.scripts')
    @stack('vendor.scripts')
@endpush

@push('master.scripts')
    @stack('custom.scripts')
@endpush
