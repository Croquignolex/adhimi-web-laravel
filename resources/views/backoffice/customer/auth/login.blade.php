@extends('layouts.auth', ['title' => __('page.login')])

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row"></div>
            <div class="content-body">
                <div class="auth-wrapper auth-v2">
                    <div class="auth-inner row m-0">
                        <!-- Brand logo-->
                        <a class="brand-logo" href="{{ route('home') }}">
                            <h2 class="brand-text text-primary ml-1">{{ config('app.name') }}</h2>
                        </a>
                        <!-- /Brand logo-->
                        <!-- Left Text-->
                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                                <img class="img-fluid"
                                     src="{{ asset("app-assets/images/pages/login-v2-dark.svg") }}"
                                     alt="Login V2"
                                />
                            </div>
                        </div>
                        <!-- /Left Text-->
                        <!-- Login-->
                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                <h4 class="card-title mb-1">Welcome to {{ config('app.name') }}! 👋</h4>
                                <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>
                                @include('partials.feedbacks.alert')
                                <form class="auth-login-form mt-2" action="" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label" for="login-email">
                                            Email*
                                            @include('partials.feedbacks.validation', ['field' => 'email'])
                                        </label>
                                        <input class="form-control" id="login-email" type="email" name="email"
                                               autofocus="" tabindex="1" value="{{ old('email') }}"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="login-password">
                                            Password*
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
                                            <a href="{{ route('customer.password.request') }}"><small>Forgot Password?</small></a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" id="remember-me" name="remember"
                                                   type="checkbox"
                                                   tabindex="3" {{ old('remember') ? 'checked' : '' }} />
                                            <label class="custom-control-label" for="remember-me"> Remember Me</label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block" tabindex="4" type="submit">Login</button>
                                </form>
                                <p class="text-center mt-2">
                                    <span>New on our platform?</span>
                                    <a href="{{ route('customer.register') }}">
                                        <span>&nbsp;Create an account</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                        <!-- /Login-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('body.class', 'vertical-layout vertical-menu-modern navbar-floating footer-static blank-page')

@push('body.data-col', 'blank-page')