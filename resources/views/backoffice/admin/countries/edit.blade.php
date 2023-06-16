@extends('layouts.admin', [
    'title' => __('page.countries.edit', ['name' => $country->name]),
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
            <div class="card">
                <div class="card-body">
                    @include('partials.feedbacks.alert')
                    <div class="row">
                        <div class="col-12 col-md-4 d-flex justify-content-center align-items-center">
                            <div class="text-center">
                                @include('partials.backoffice.round-image', ['url' => $flag?->url, 'initials' => $country->initials])
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <!-- form -->
                            <form class="validate-form mt-1" method="POST" action="{{ route('admin.countries.update', [$country]) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        @include('partials.input.text', [
                                            'label' => __('field.name'),
                                            'field' => 'name',
                                            'required' => true,
                                            'value' => $country->name,
                                        ])
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        @include('partials.input.text', [
                                            'label' => __('field.phone_code'),
                                            'field' => 'phone_code',
                                            'value' => $country->phone_code,
                                        ])
                                    </div>
                                    <div class="col-12">
                                        @include('partials.input.textarea', ['value' => $country->description])
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
@endsection