@extends('layouts.admin', [
    'title' => __('page.countries.new'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.countries.index'), 'label' => __('page.countries.countries')]
    ]
])

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- form -->
                                @include('partials.feedbacks.alert')
                                <form class="validate-form mt-1" method="POST" action="{{ route('admin.countries.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            @include('partials.input.text', [
                                                'label' => __('field.name'),
                                                'field' => 'name',
                                                'required' => true,
                                            ])
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            @include('partials.input.text', [
                                                'label' => __('field.phone_code'),
                                                'field' => 'phone_code'
                                            ])
                                        </div>
                                        <div class="col-12">
                                            @include('partials.input.textarea')
                                        </div>
                                        <div class="col-12">
                                            @include('partials.input.button')
                                        </div>
                                    </div>
                                </form>
                                <!--/ form -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection