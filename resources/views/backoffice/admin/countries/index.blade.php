@extends('layouts.admin', [
    'title' => __('page.countries.all'),
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
                                <a href="{{ route('admin.countries.create') }}" class="mb-1 btn btn-primary">
                                    @lang('page.countries.new')
                                </a>
                                <form action="" method="GET" class="w-50 float-right">
                                    <div class="form-group">
                                        <input type="search" class="form-control" name="q" value="{{ $q }}" placeholder="@lang('field.search')..." />
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
                                        <th>@lang('field.phone_code') <i data-feather="search" class="text-secondary"></i></th>
                                        <th>@lang('field.status')</th>
                                        <th>@lang('field.states')</th>
                                        <th>@lang('field.actions')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($countries as $country)
                                        <tr>
                                            <td>
                                                <span class="badge badge-light-secondary">
                                                    {{ format_date($country->created_at) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    @include('partials.backoffice.round-image', ['url' => $country->logo?->url, 'initials' => $country->initials, 'size' => 'xs'])
                                                    <div class="ml-25 mt-25">
                                                        {{ $country->name }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-right">{{ $country->phone_code }}</td>
                                            <td>
                                                <span class="badge badge-light-{{ $country->status_badge['color'] }}">
                                                    {{ $country->status_badge['value'] }}
                                                </span>
                                            </td>
                                            <td class="text-right">{{ $country->states_count }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('admin.countries.show', [$country]) }}">
                                                            <i data-feather="eye" class="mr-50 text-success"></i>
                                                            <span>@lang('general.action.detail')</span>
                                                        </a>
                                                        <a class="dropdown-item" href="{{ route('admin.countries.edit', [$country]) }}">
                                                            <i data-feather="edit-2" class="mr-50 text-warning"></i>
                                                            <span>@lang('general.action.update')</span>
                                                        </a>
                                                        <hr>
                                                        {{--<a class="dropdown-item" href="{{ route('admin.organisations.add.store', [$organisation]) }}">
                                                            <i data-feather="plus-square" class="mr-50 text-primary"></i>
                                                            <span>@lang('general.action.add_store')</span>
                                                        </a>
                                                        <a class="dropdown-item" href="{{ route('admin.organisations.add.vendor', [$organisation]) }}">
                                                            <i data-feather="plus-square" class="mr-50 text-primary"></i>
                                                            <span>@lang('general.action.add_vendor')</span>
                                                        </a>--}}
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
                                {{ $countries->links('partials.backoffice.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection