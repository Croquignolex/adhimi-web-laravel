@extends('layouts.admin', [
    'title' => __('page.states.detail'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.states.index'), 'label' => __('page.states.states')]
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
                                @if(auth()->user()->is_admin)
                                    <div class="mb-1">
                                        <a href="{{ route('admin.states.edit', [$state]) }}"
                                           class="btn btn-warning mb-50">
                                            <i data-feather="edit"></i>
                                            @lang('general.action.update')
                                        </a>
                                        <button class="btn btn-{{ $state->status_toggle['color'] }} mb-50"
                                                data-toggle="modal" data-target="#toggle-status-modal">
                                            <i data-feather="{{ $state->status_toggle['icon'] }}"></i>
                                            {{ $state->status_toggle['label'] }}
                                        </button>
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                        <tr>
                                            <th>@lang('field.creation')</th>
                                            <td style="white-space: nowrap;">
                                                @include('partials.backoffice.date-badge', ['model' => $state])
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.name')</th>
                                            <td>{{ $state->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.status')</th>
                                            <td>@include('partials.backoffice.status-badge', ['model' => $state])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.country')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $state->country])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.creator')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $state->creator])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.description')</th>
                                            <td>
                                                {{ $state->description }}
                                            </td>
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
                                    <a class="nav-link {{ active_page('admin.states.show.logs') }}" href="{{ route('admin.states.show.logs', [$state]) }}">
                                        <i data-feather="file-text" class="font-medium-3"></i>
                                        <span class="font-weight-bold">@lang('general.profile.logs')</span>
                                    </a>
                                </li>
                            </ul>
                            @yield('state.content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @component('components.modal', [
        'color' => $state->status_toggle['color'],
        'id' => "toggle-status-modal",
        'size' => 'modal-sm',
        'title' => $state->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $state->name, 'action' => $state->status_toggle['label']])
            ?</p>
        <form action="{{ route('admin.states.status.toggle', [$state]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $state->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endsection