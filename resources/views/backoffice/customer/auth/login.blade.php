@extends('layouts.auth', ['title' => __('page.login')])

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-v1 px-2">
                    <div class="auth-inner py-2">
                        <div class="card mb-0">
                            <div class="card-body">
                                <!-- Brand logo-->
                                <a class="brand-logo" href="{{ route('home') }}">
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="adhimi-logo" class="img-fluid" width="200">
                                </a>
                                <!-- /Brand logo-->

                                <h4 class="card-title mb-1">@lang('general.welcome')!! 👋</h4>
                                <p class="card-text mb-2">@lang('general.login.enter_your_credentials')</p>
                                @include('partials.feedbacks.alert')

                                <form class="auth-login-form mt-2" action="" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label" for="login-email">
                                            @lang('field.email') <span class="text-danger">*</span>
                                            @include('partials.feedbacks.validation', ['field' => 'email'])
                                        </label>
                                        <input class="form-control" id="login-email" type="email" name="email"
                                               autofocus="" tabindex="1" value="{{ old('email') }}"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="login-password">
                                            @lang('field.password') <span class="text-danger">*</span>
                                            @include('partials.feedbacks.validation', ['field' => 'password'])
                                        </label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control form-control-merge" id="login-password"
                                                   type="password" name="password" tabindex="2"/>
                                            <div class="input-group-append">
                                                <span class="input-group-text cursor-pointer">
                                                    <i data-feather="eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <a href="{{ route('customer.password.request') }}">
                                                <small>@lang('general.login.forgotten_password')?</small>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" id="remember-me" name="remember"
                                                   type="checkbox"
                                                   tabindex="3" {{ old('remember') ? 'checked' : '' }} />
                                            <label class="custom-control-label" for="remember-me">
                                                @lang('general.login.remember_me')
                                            </label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block" tabindex="4" type="submit">
                                        @lang('field.login')
                                    </button>
                                </form>
                                <p class="text-center mt-2">
                                    <span>@lang('general.login.new_on_this_platform') ?</span>
                                    <a href="{{ route('customer.register') }}">
                                        <span>&nbsp;@lang('general.login.create_an_account')</span>
                                    </a>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('body.class', 'vertical-layout vertical-menu-modern navbar-floating footer-static blank-page')

@push('body.data-col', 'blank-page')