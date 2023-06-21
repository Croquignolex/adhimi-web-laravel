@extends('layouts.admin', [
    'title' => __('page.states.all'),
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
                                <a href="{{ route('admin.states.create') }}" class="btn btn-primary">
                                    <i data-feather="plus"></i>
                                    @lang('page.states.new')
                                </a>
                                <form action="" method="GET" class="w-50 float-right">
                                    <div class="form-group">
                                        <input type="search" class="form-control" name="q" value="{{ $q }}" placeholder="@lang('field.search')..." />
                                    </div>
                                </form>
                                @include('partials.feedbacks.alert')
                            </div>
                            @include('partials.backoffice.admin.states', ['states' => $states, 'creator' => true, 'country' => true])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection