@extends('layouts.admin', [
    'title' => $title,
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.categories.index'), 'label' => __('page.categories.categories')],
        ['url' => route('admin.categories.show', [$category]), 'label' => $category->name]
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
                                <h4>@include('partials.backoffice.admin.entity-data', ['model' => $category, 'plain' => true])</h4>
                            </div>
                            <div class="text-center">
                                @include('partials.backoffice.landscape-image', ['url' => $category->banner?->url, 'initials' => $category->initials])
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            @yield('category.content')
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
    <script src="{{ asset("app-assets/vendors/js/forms/select/select2.full.min.js") }}"></script>>
@endpush

@push('custom.scripts')
    @stack('category.custom.scripts')
@endpush