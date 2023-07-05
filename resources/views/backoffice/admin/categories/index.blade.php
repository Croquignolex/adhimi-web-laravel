@extends('layouts.admin', [
    'title' => __('page.categories.all'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')]
    ]
])

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="basic-table">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                    <i data-feather="plus"></i>
                                    @lang('page.categories.new')
                                </a>
                                @include('partials.input.search')
                                @include('partials.feedbacks.alert')
                            </div>
                            @include('partials.backoffice.admin.categories-table', ['categories' => $categories])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection