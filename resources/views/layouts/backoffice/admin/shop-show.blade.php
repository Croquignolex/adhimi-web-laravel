@extends('layouts.admin', [
    'title' => __('page.shops.detail'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.shops.index'), 'label' => __('page.shops.shops')]
    ]
])

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="card">
                    <div class="card-body">
                        @include('partials.feedbacks.alert')
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1">
                                    <a href="{{ route('admin.shops.edit', [$shop]) }}" class="btn btn-warning mb-50">
                                        <i data-feather="edit"></i>
                                        @lang('general.action.update')
                                    </a>
                                    <button class="btn btn-{{ $shop->status_toggle['color'] }} mb-50"  data-toggle="modal" data-target="#toggle-status-modal">
                                        <i data-feather="{{ $shop->status_toggle['icon'] }}"></i>
                                        {{ $shop->status_toggle['label'] }}
                                    </button>
                                    @if($shop->can_add_manager)
                                        <a href="{{ route('admin.shops.add.manager', [$shop]) }}" class="btn btn-primary mb-50">
                                            <i data-feather="plus-square"></i>
                                            @lang('page.shops.add_manager')
                                        </a>
                                    @endif
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                        <tr>
                                            <th>@lang('field.creation')</th>
                                            <td style="white-space: nowrap;">
                                                @include('partials.backoffice.date-badge', ['model' => $shop])
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.name')</th>
                                            <td>{{ $shop->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.status')</th>
                                            <td>@include('partials.backoffice.status-badge', ['model' => $shop])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.organisation')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $shop->organisation])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.merchant')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $shop->manager])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.creator')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $shop->creator])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.description')</th>
                                            <td>
                                                {{ $shop->description }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-tabs justify-content-center mt-1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ active_page('admin.shops.show') }}" href="{{ route('admin.shops.show', [$shop]) }}">
                                <i data-feather="users" class="font-medium-3"></i>
                                <span class="font-weight-bold">
                                    @lang('page.staffs.staffs')
                                    ({{ $shop->users_count }})
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_page('admin.shops.show.logs') }}" href="{{ route('admin.shops.show.logs', [$shop]) }}">
                                <i data-feather="file-text" class="font-medium-3"></i>
                                <span class="font-weight-bold">@lang('general.profile.logs')</span>
                            </a>
                        </li>
                    </ul>
                    @yield('shop.content')
                </div>
            </div>
        </div>
    </div>

    @component('components.modal', [
           'color' => $shop->status_toggle['color'],
           'id' => "toggle-status-modal",
           'size' => 'modal-sm',
           'title' => $shop->status_toggle['label'],
       ])
        <p>@lang('general.change_status_question', ['name' => $shop->name, 'action' => $shop->status_toggle['label']])?</p>
        <form action="{{ route('admin.shops.status.toggle', [$shop]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $shop->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endsection