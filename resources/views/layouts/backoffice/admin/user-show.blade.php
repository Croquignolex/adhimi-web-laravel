@extends('layouts.admin', [
    'title' => __('page.staffs.detail'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.users.index'), 'label' => __('page.staffs.staffs')]
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
                            <div class="col-12 col-md-4 d-flex justify-content-center align-items-center">
                                <div class="text-center">
                                    @include('partials.backoffice.round-image', ['url' => $user->avatar?->url, 'initials' => $user->initials])
                                </div>
                            </div>

                            <div class="col-12 col-md-8">
                                @if(auth()->user()->is_admin)
                                    <div class="mb-1">
                                        <button class="btn btn-{{ $user->status_toggle['color'] }} mb-50"  data-toggle="modal" data-target="#toggle-status-modal">
                                            <i data-feather="{{ $user->status_toggle['icon'] }}"></i>
                                            {{ $user->status_toggle['label'] }}
                                        </button>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                        <tr>
                                            <th>@lang('field.creation')</th>
                                            <td style="white-space: nowrap;">
                                                @include('partials.backoffice.date-badge', ['model' => $user])
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.name')</th>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.email')</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.role')</th>
                                            <td>@include('partials.backoffice.role-badge', ['model' => $user])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.status')</th>
                                            <td>@include('partials.backoffice.status-badge', ['model' => $user])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.organisation')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $user->organisation])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.shop')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $user->shop])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.creator')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $user->creator])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.description')</th>
                                            <td>{{ $user->description }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
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
                                    <a class="nav-link {{ active_page('admin.users.show.logs') }}" href="{{ route('admin.users.show.logs', [$user]) }}">
                                        <i data-feather="file-text" class="font-medium-3"></i>
                                        <span class="font-weight-bold">@lang('general.profile.logs')</span>
                                    </a>
                                </li>
                            </ul>
                            @yield('user.content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @component('components.modal', [
        'color' => $user->status_toggle['color'],
        'id' => "toggle-status-modal",
        'size' => 'modal-sm',
        'title' => $user->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $user->name, 'action' => $user->status_toggle['label']])?</p>
        <form action="{{ route('admin.users.status.toggle', [$user]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $user->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endsection