@extends('layouts.admin', [
    'title' => __('page.home'),
    'breadcrumb_items' => []
])

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        @include('partials.feedbacks.alert')
                        <div class="card card-congratulations">
                            <div class="card-body text-center">
                                <img src="{{ asset("app-assets/images/elements/decore-left.png") }}" class="congratulations-img-left" alt="..." />
                                <img src="{{ asset("app-assets/images/elements/decore-right.png") }}" class="congratulations-img-right" alt="..." />
                                <div class="avatar avatar-xl bg-primary shadow">
                                    <div class="avatar-content">
                                        <i data-feather="pie-chart" class="font-large-1 text-white"></i>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h1 class="mb-1 text-white">{{ __('general.welcome') }} {{ auth()->user()->first_name }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection