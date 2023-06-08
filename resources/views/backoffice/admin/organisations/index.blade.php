@extends('layouts.admin', [
    'title' => __('page.shops.all'),
    'breadcrumb_items' => [
        ['url' => route('home'), 'label' => __('page.home')]
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
                                <a href="{{ route('admin.organisations.create') }}" class="mb-1 btn btn-primary">
                                    @lang('page.shops.new')
                                </a>
                                <form action="" method="GET" class="w-50 float-right">
                                    <div class="form-group">
                                        <input type="search" class="form-control" name="q" value="{{ $q }}" placeholder="Rechercher..." />
                                    </div>
                                </form>
                                @include('partials.feedbacks.alert')
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>@lang('field.creation')</th>
                                        <th>@lang('field.name') <i data-feather="search" class="text-secondary"></i></th>
                                        <th>@lang('field.phone') <i data-feather="search" class="text-secondary"></i></th>
                                        <th>@lang('field.status')</th>
                                        <th>@lang('field.merchant')</th>
                                        <th>@lang('field.actions')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($organisations as $organisation)
                                        <tr>
                                            <td>
                                                <span class="badge badge-light-secondary">
                                                    {{ format_date($organisation->created_at) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    @include('partials.backoffice.round-logo', ['model' => $organisation, 'size' => 'xs'])
                                                    <div class="ml-25 mt-25">
                                                        {{ $organisation->name }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $organisation->phone }}</td>
                                            <td>
                                                <span class="badge badge-light-{{ $organisation->status_badge['color'] }}">
                                                    {{ $organisation->status_badge['value'] }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($organisation?->merchant)
                                                    <div class="d-flex">
                                                        @include('partials.backoffice.round-avatar', ['user' => $organisation->merchant, 'size' => 'xs'])
                                                        <div class="ml-25 mt-25">
                                                            <a href="{{ route('admin.users.show', [$organisation]) }}">
                                                                {{ $organisation->merchant->full_name }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('admin.organisations.show', [$organisation]) }}">
                                                            <i data-feather="eye" class="mr-50 text-success"></i>
                                                            <span>@lang('general.action.detail')</span>
                                                        </a>
                                                        <a class="dropdown-item" href="{{ route('admin.organisations.edit', [$organisation]) }}">
                                                            <i data-feather="edit-2" class="mr-50 text-warning"></i>
                                                            <span>@lang('general.action.update')</span>
                                                        </a>
                                                        <hr>
                                                        <a class="dropdown-item" href="{{ route('admin.organisations.add.store', [$organisation]) }}">
                                                            <i data-feather="plus-square" class="mr-50 text-primary"></i>
                                                            <span>@lang('general.action.add_store')</span>
                                                        </a>
                                                        <a class="dropdown-item" href="{{ route('admin.organisations.add.vendor', [$organisation]) }}">
                                                            <i data-feather="plus-square" class="mr-50 text-primary"></i>
                                                            <span>@lang('general.action.add_vendor')</span>
                                                        </a>
                                                        @if(!$organisation?->merchant)
                                                            <a class="dropdown-item" href="{{ route('admin.organisations.add.merchant', [$organisation]) }}">
                                                                <i data-feather="plus-square" class="mr-50 text-primary"></i>
                                                                <span>@lang('general.action.add_merchant')</span>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">
                                                <div class="alert alert-primary fade show" role="alert">
                                                    <div class="alert-body text-center">
                                                        @lang('general.no_records')
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body">
                                {{ $organisations->links('partials.backoffice.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection