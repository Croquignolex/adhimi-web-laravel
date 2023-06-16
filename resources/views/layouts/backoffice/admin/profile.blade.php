@extends('layouts.admin', compact('title', 'breadcrumb_items'))

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row">
                    <!-- left menu section -->
                    <div class="col-md-2 m-0">
                        <ul class="nav nav-pills flex-column nav-left">
                            <!-- general -->
                            <li class="nav-item">
                                <a class="nav-link {{ active_page('admin.profile.general') }}" href="{{ route('admin.profile.general') }}">
                                    <i data-feather="user" class="font-medium-3"></i>
                                    <span class="font-weight-bold">@lang('general.profile.general')</span>
                                </a>
                            </li>
                            <!-- avatar -->
                            <li class="nav-item">
                                <a class="nav-link {{ active_page('admin.profile.avatar') }}" href="{{ route('admin.profile.avatar') }}">
                                    <i data-feather="image" class="font-medium-3"></i>
                                    <span class="font-weight-bold">@lang('general.profile.avatar')</span>
                                </a>
                            </li>
                            <!-- address -->
                            <li class="nav-item">
                                <a class="nav-link {{ active_page('admin.profile.address') }}" href="{{ route('admin.profile.address') }}">
                                    <i data-feather="map-pin" class="font-medium-3"></i>
                                    <span class="font-weight-bold">@lang('general.profile.address')</span>
                                </a>
                            </li>
                            <!-- password -->
                            <li class="nav-item">
                                <a class="nav-link {{ active_page('admin.profile.password') }}" href="{{ route('admin.profile.password') }}">
                                    <i data-feather="lock" class="font-medium-3"></i>
                                    <span class="font-weight-bold">@lang('general.profile.password')</span>
                                </a>
                            </li>
                            <!-- Settings -->
                            <li class="nav-item">
                                <a class="nav-link {{ active_page('admin.profile.settings') }}" href="{{ route('admin.profile.settings') }}">
                                    <i data-feather="settings" class="font-medium-3"></i>
                                    <span class="font-weight-bold">@lang('general.profile.settings')</span>
                                </a>
                            </li>
                            <!-- Logs -->
                            <li class="nav-item">
                                <a class="nav-link {{ active_page('admin.profile.logs') }}" href="{{ route('admin.profile.logs') }}">
                                    <i data-feather="file-text" class="font-medium-3"></i>
                                    <span class="font-weight-bold">@lang('general.profile.logs')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--/ left menu section -->

                    <!-- right content section -->
                    <div class="col-md-10 m-0">
                        @yield('profile.content')
                    </div>
                    <!--/ right content section -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('vendor.styles')
    @stack('profile.vendor.styles')
@endpush

@push('page.styles')
    @stack('profile.page.styles')
@endpush

@push('vendor.scripts')
    @stack('profile.vendor.scripts')
@endpush

@push('custom.scripts')
    @stack('profile.custom.scripts')
@endpush