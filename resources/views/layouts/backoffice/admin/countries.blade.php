@extends('layouts.admin', compact('title', 'breadcrumb_items'))

@section('content')
    <div class="card">
        <div class="card-body">
            @include('partials.feedbacks.alert')
            <table class="table table-bordered table-hover mb-2">
                <tbody>
                <tr>
                    <th>Creation</th>
                    <td style="white-space: nowrap;">
                            <span class="badge badge-light-secondary">
                                {{ format_date($country->created_at) }}
                            </span>
                        <span class="badge badge-light-secondary">
                                {{ format_time($country->created_at) }}
                            </span>
                    </td>
                </tr>
                <tr>
                    <th>@lang('field.name')</th>
                    <td>{{ $country->name }}</td>
                </tr>
                <tr>
                    <th>@lang('field.phone_code')</th>
                    <td>{{ $country->phone_code,}}</td>
                </tr>
                <tr>
                    <th>@lang('field.status')</th>
                    <td>
                            <span class="badge badge-light-{{ $country->status_badge['color'] }}">
                                {{ $country->status_badge['value'] }}
                            </span>
                    </td>
                </tr>
                <tr>
                    <th>@lang('field.description')</th>
                    <td>
                        {{ $country->description }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>




    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row">
                    <!-- left menu section -->
                    <div class="col-md-3 mb-2 mb-md-0">
                        <ul class="nav nav-pills flex-column nav-left">
                            <!-- detail -->
                            <li class="nav-item">
                                <a class="nav-link {{ active_page('admin.countries.show') }}" href="{{ route('admin.countries.show', [$country]) }}">
                                    <i data-feather="eye" class="font-medium-3 mr-1"></i>
                                    <span class="font-weight-bold">@lang('general.action.detail')</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <!--/ left menu section -->

                    <!-- right content section -->
                    <div class="col-md-9">
                        @yield('countries.content')
                    </div>
                    <!--/ right content section -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('vendor.styles')
    @stack('countries.vendor.styles')
@endpush

@push('page.styles')
    @stack('countries.page.styles')
@endpush

@push('vendor.scripts')
    @stack('countries.vendor.scripts')
@endpush

@push('custom.scripts')
    @stack('countries.custom.scripts')
@endpush