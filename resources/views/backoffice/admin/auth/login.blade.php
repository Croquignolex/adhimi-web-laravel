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
                                    @include('partials.input.text', [
                                        'label' => __('field.email'),
                                        'field' => 'email',
                                        'required' => true,
                                    ])
                                    @include('partials.input.password', [
                                       'label' => __('field.password'),
                                       'field' => 'password',
                                       'required' => true,
                                   ])
                                    @include('partials.input.checkbox', [
                                       'label' => __('general.login.remember_me'),
                                       'field' => 'remember',
                                   ])
                                    <button class="btn btn-primary btn-block" type="submit">
                                        @lang('field.login')
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('body.class', 'vertical-layout vertical-menu-modern dark-layout navbar-floating footer-static blank-page')

@push('body.data-layout', 'dark-layout')

@push('body.data-col', 'blank-page')