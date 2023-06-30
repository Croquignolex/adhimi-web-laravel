@extends('layouts.admin', [
    'title' => $title,
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.brands.index'), 'label' => __('page.brands.brands')],
        ['url' => route('admin.brands.show', [$brand]), 'label' => $brand->name]
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
                                <h4>{{ $brand->name }}</h4>
                            </div>
                            <div class="text-center">
                                @include('partials.backoffice.round-image', ['url' => $brand->logo?->url, 'initials' => $brand->initials])
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            @yield('brand.content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
