@extends('layouts.admin', [
    'title' => __('page.ratings.detail'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.ratings.index'), 'label' => __('page.ratings.ratings')]
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
                                        <button class="btn btn-{{ $rating->status_toggle['color'] }} mb-50"
                                                data-toggle="modal" data-target="#toggle-status-modal">
                                            <i data-feather="{{ $rating->status_toggle['icon'] }}"></i>
                                            {{ $rating->status_toggle['label'] }}
                                        </button>
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                        <tr>
                                            <th>@lang('field.creation')</th>
                                            <td style="white-space: nowrap;">
                                                @include('partials.backoffice.date-badge', ['model' => $rating])
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.note')</th>
                                            <td>{{ $rating->note }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.status')</th>
                                            <td>@include('partials.backoffice.status-badge', ['model' => $rating])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.entity')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $rating->ratable])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.customer')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $rating->customer])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.comment')</th>
                                            <td>{{ $rating->comment }}</td>
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
                                    <a class="nav-link {{ active_page('admin.ratings.show.logs') }}" href="{{ route('admin.ratings.show.logs', [$rating]) }}">
                                        <i data-feather="file-text" class="font-medium-3"></i>
                                        <span class="font-weight-bold">@lang('general.profile.logs')</span>
                                    </a>
                                </li>
                            </ul>
                            @yield('rating.content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @component('components.modal', [
        'color' => $rating->status_toggle['color'],
        'id' => "toggle-status-modal",
        'size' => 'modal-sm',
        'title' => $rating->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $rating->customer->name, 'action' => $rating->status_toggle['label']])
            ?</p>
        <form action="{{ route('admin.ratings.status.toggle', [$rating]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $rating->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endsection