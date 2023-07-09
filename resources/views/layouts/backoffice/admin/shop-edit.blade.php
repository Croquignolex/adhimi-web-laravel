@extends('layouts.admin', [
    'title' => $title,
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.shops.index'), 'label' => __('page.shops.shops')],
        ['url' => route('admin.shops.show', [$shop]), 'label' => $shop->name]
    ]
])

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="card">
                <div class="card-body">
                    @include('partials.feedbacks.alert')
                    <div class="row">
                        <div class="col-12 col-md-4 d-flex flex-column justify-content-center align-items-center">
                            <div class="text-center mb-50">
                                <h4>Boutique</h4>
                                <h4><a href="">{{ $shop->name }}</a></h4>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            @yield('shop.content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('vendor.styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/vendors/css/forms/select/select2.min.css") }}">
@endpush

@push('vendor.scripts')
    <script src="{{ asset("app-assets/vendors/js/forms/select/select2.full.min.js") }}"></script>
@endpush

@push('custom.scripts')
    @stack('shop.custom.scripts')
@endpush