@extends('layouts.admin', [
    'title' => __('page.shops.all'),
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
                                <a href="{{ route('admin.shops.create') }}" class="btn btn-primary">
                                    <i data-feather="plus"></i>
                                    @lang('page.shops.new')
                                </a>
                                @include('partials.input.search')
                                @include('partials.feedbacks.alert')
                            </div>
                            @include('partials.backoffice.admin.shops-table', ['shops' => $shops])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection