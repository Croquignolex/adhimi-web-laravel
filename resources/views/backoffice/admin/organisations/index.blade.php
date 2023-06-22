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
                                <a href="{{ route('admin.organisations.create') }}" class="btn btn-primary">
                                    <i data-feather="plus"></i>
                                    @lang('page.organisations.new')
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
                                        <th>@lang('field.phone') <i data-feather="search" class="text-secondary"></i></th>
                                        <th>@lang('field.status')</th>
                                        <th>@lang('field.creator')</th>
                                        <th>@lang('field.actions')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($organisations as $organisation)
                                        <tr>
                                            <td style="white-space: nowrap;">
                                                @include('partials.backoffice.date-badge', ['model' => $organisation])
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    @include('partials.backoffice.round-image', ['url' => $organisation->logo?->url, 'initials' => $organisation->initials, 'size' => 'xs'])
                                                    <div class="ml-50 mt-25">
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
                                                @include('partials.backoffice.admin.user-data', ['user' => $organisation->creator])
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('admin.organisations.show', [$organisation]) }}">
                                                            <i data-feather="eye" class="mr-50 text-primary"></i>
                                                            @lang('general.action.detail')
                                                        </a>
                                                        <a class="dropdown-item" href="{{ route('admin.organisations.edit', [$organisation]) }}">
                                                            <i data-feather="edit" class="mr-50 text-warning"></i>
                                                            @lang('general.action.update')
                                                        </a>
                                                        <hr>
                                                        <a href="javascript:void(0);" class="dropdown-item"
                                                           data-toggle="modal" data-target="#toggle-status-modal-{{ $organisation->id }}"
                                                        >
                                                            <i data-feather="{{ $organisation->status_toggle['icon'] }}" class="mr-50 text-{{ $organisation->status_toggle['color'] }}"></i>
                                                            <span>{{ $organisation->status_toggle['label'] }}</span>
                                                        </a>
                                                        <hr>
                                                        @if(is_null($organisation->merchant))
                                                            <a class="dropdown-item" href="{{ route('admin.organisations.add.merchant', [$organisation]) }}">
                                                                <i data-feather="plus-square" class="mr-50 text-secondary"></i>
                                                                <span>@lang('page.organisations.add_merchant')</span>
                                                            </a>
                                                        @endif
                                                        <a class="dropdown-item" href="{{ route('admin.organisations.add.shop', [$organisation]) }}">
                                                            <i data-feather="plus-square" class="mr-50 text-secondary"></i>
                                                            <span>@lang('general.action.add_shop')</span>
                                                        </a>
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
                                @if(is_null($q))
                                    {{ $organisations->links('partials.backoffice.pagination') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($organisations as $organisation)
        @component('components.modal', [
            'color' => $organisation->status_toggle['color'],
            'id' => "toggle-status-modal-" . $organisation->id,
            'size' => 'modal-sm',
            'title' => $organisation->status_toggle['label'],
        ])
            <p>@lang('general.change_status_question', ['name' => $organisation->name, 'action' => $organisation->status_toggle['label']])?</p>
            <form action="{{ route('admin.organisations.status.toggle', [$organisation]) }}" method="POST" class="text-right mt-50">
                @csrf
                <button type="submit" class="btn btn-{{ $organisation->status_toggle['color'] }}">
                    @lang('general.yes')
                </button>
            </form>
        @endcomponent
    @endforeach
@endsection