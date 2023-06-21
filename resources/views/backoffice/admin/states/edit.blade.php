@extends('layouts.admin', [
    'title' => __('page.states.edit'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.states.index'), 'label' => __('page.states.states')],
        ['url' => route('admin.states.show', [$state]), 'label' => $state->name]
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
                                @include('partials.feedbacks.alert')
                                <form class="validate-form mt-1" method="POST" action="{{ route('admin.states.update', [$state]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            @include('partials.input.text', [
                                                'label' => __('field.name'),
                                                'field' => 'name',
                                                'required' => true,
                                                'value' => $state->name,
                                            ])
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            @include('partials.input.ajax-select', [
                                               'label' => __('field.country'),
                                               'required' => true,
                                               'field' => 'country',
                                               'value' => $state->country->id,
                                               'route' => route('api.countries.index'),
                                            ])
                                        </div>
                                        <div class="col-12">
                                            @include('partials.input.textarea', ['value' => $state->description])
                                        </div>
                                        <div class="col-12">
                                            @include('partials.input.button')
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('vendor.styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/vendors/css/forms/select/select2.min.css") }}">
@endpush

@push('vendor.scripts')
    <script src="{{ asset("app-assets/vendors/js/forms/select/select2.full.min.js") }}"></script>
@endpush

@push('custom.scripts')
    <script src="{{ asset("custom/js/country-select.js") }}"></script>
@endpush