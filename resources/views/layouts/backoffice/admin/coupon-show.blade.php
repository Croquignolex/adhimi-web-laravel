@extends('layouts.admin', [
    'title' => __('page.coupons.detail'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.coupons.index'), 'label' => __('page.coupons.coupons')]
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
                                    <a href="{{ route('admin.coupons.edit', [$coupon]) }}"
                                       class="btn btn-warning mb-50">
                                        <i data-feather="edit"></i>
                                        @lang('general.action.update')
                                    </a>
                                    <button class="btn btn-{{ $coupon->status_toggle['color'] }} mb-50"
                                            data-toggle="modal" data-target="#toggle-status-modal">
                                        <i data-feather="{{ $coupon->status_toggle['icon'] }}"></i>
                                        {{ $coupon->status_toggle['label'] }}
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                        <tr>
                                            <th>@lang('field.creation')</th>
                                            <td style="white-space: nowrap;">
                                                @include('partials.backoffice.date-badge', ['model' => $coupon])
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.code')</th>
                                            <td>{{ $coupon->code }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.discount')</th>
                                            <td>{{ $coupon->discount }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.uses')</th>
                                            <td>{{ $coupon->total_use }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.promotion_started_at')</th>
                                            <td>
                                                <span class="badge badge-light-info">
                                                    {{ format_date($coupon->promotion_started_at) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.promotion_ended_at')</th>
                                            <td>
                                                <span class="badge badge-light-secondary">
                                                    {{ format_date($coupon->promotion_ended_at) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.status')</th>
                                            <td>@include('partials.backoffice.status-badge', ['model' => $coupon])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.creator')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $coupon->creator])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.description')</th>
                                            <td>{{ $coupon->description }}</td>
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
                                    <a class="nav-link {{ active_page('admin.coupons.show.logs') }}" href="{{ route('admin.coupons.show.logs', [$coupon]) }}">
                                        <i data-feather="file-text" class="font-medium-3"></i>
                                        <span class="font-weight-bold">@lang('general.profile.logs')</span>
                                    </a>
                                </li>
                            </ul>
                            @yield('coupon.content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @component('components.modal', [
        'color' => $coupon->status_toggle['color'],
        'id' => "toggle-status-modal",
        'size' => 'modal-sm',
        'title' => $coupon->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $coupon->code, 'action' => $coupon->status_toggle['label']])
            ?</p>
        <form action="{{ route('admin.coupons.status.toggle', [$coupon]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $coupon->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endsection