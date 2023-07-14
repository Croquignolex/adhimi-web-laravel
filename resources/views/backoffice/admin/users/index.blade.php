@extends('layouts.admin', [
    'title' => __('page.staffs.all'),
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
                                <a href="{{ route('admin.users.create.admin') }}" class="btn btn-primary mb-50">
                                    <i data-feather="plus"></i>
                                    @lang('page.staffs.new_admin')
                                </a>
                                <a href="{{ route('admin.users.create.merchant') }}" class="btn btn-primary mb-50">
                                    <i data-feather="plus"></i>
                                    @lang('page.staffs.new_merchant')
                                </a>
                                <a href="{{ route('admin.users.create.manager') }}" class="btn btn-primary mb-50">
                                    <i data-feather="plus"></i>
                                    @lang('page.staffs.new_manager')
                                </a>
                                <a href="{{ route('admin.users.create.seller') }}" class="btn btn-primary mb-50">
                                    <i data-feather="plus"></i>
                                    @lang('page.staffs.new_seller')
                                </a>
                                @include('partials.input.search')
                                @include('partials.feedbacks.alert')
                            </div>
                            @include('partials.backoffice.admin.users-table', ['users' => $users])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection