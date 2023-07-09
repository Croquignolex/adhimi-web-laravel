@extends('layouts.backoffice.admin.profile', [
    'title' => __('page.update_my_address'),
    'breadcrumb_items' => [
        ['url' => route('home'), 'label' => __('page.home')]
    ]
]) 

@section('profile.content')
    <div class="card">
        <div class="card-body">
            <!-- form -->
            @include('partials.feedbacks.alert')
            <form class="validate-form mt-1" method="POST" action="">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-12 col-sm-12">
                        @include('partials.input.text', [
                            'value' => $user->defaultAddress?->street_address,
                            'label' => __('field.street_address'),
                            'field' => 'street_address',
                            'required' => true,
                        ])
                    </div>
                    <div class="col-12 col-sm-6">
                        @include('partials.input.text', [
                           'value' => $user->defaultAddress?->street_address_plus,
                           'label' => __('field.street_address_plus'),
                           'field' => 'street_address_plus'
                        ])
                    </div>
                    <div class="col-12 col-sm-6">
                        @include('partials.input.text', [
                           'value' => $user->defaultAddress?->zipcode,
                           'label' => __('field.zipcode'),
                           'field' => 'zipcode'
                        ])
                    </div>
                    <div class="col-12 col-sm-6">
                        @include('partials.input.text', [
                           'value' => $user->defaultAddress?->phone_number_one,
                           'label' => __('field.phone_number_one'),
                           'field' => 'phone_number_one'
                        ])
                    </div>
                    <div class="col-12 col-sm-6">
                        @include('partials.input.text', [
                           'value' => $user->defaultAddress?->phone_number_two,
                           'label' => __('field.phone_number_two'),
                           'field' => 'phone_number_two'
                        ])
                    </div>
                    <div class="col-12 col-sm-6">
                        @include('partials.input.ajax-select', [
                            'label' => __('field.country'),
                            'required' => true,
                            'field' => 'country',
                            'value' => $user->defaultAddress?->state->country->id,
                            'route' => route('api.countries.index'),
                            'add_url' => route('admin.countries.create'),
                            'add_text' => __('general.action.add_country'),
                        ])
                    </div>
                    <div class="col-12 col-sm-6">
                        @include('partials.input.ajax-select', [
                            'label' => __('field.state'),
                            'required' => true,
                            'field' => 'state',
                            'value' => $user->defaultAddress?->state->id,
                            'route' => route('api.states.index'),
                            'add_url' => route('admin.states.create'),
                            'add_text' => __('general.action.add_state'),
                        ])
                    </div>
                    <div class="col-12">
                        @include('partials.input.textarea', ['value' => $user->defaultAddress?->description])
                    </div>
                    <div class="col-12">
                        @include('partials.input.button')
                    </div>
                </div>
            </form>
            <!--/ form -->
        </div>
    </div>
@endsection

@push('profile.vendor.styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/vendors/css/forms/select/select2.min.css") }}">
@endpush

@push('profile.vendor.scripts')
    <script src="{{ asset("app-assets/vendors/js/forms/select/select2.full.min.js") }}"></script>
@endpush

@push('profile.custom.scripts')
    <script src="{{ asset("custom/js/country-state-select.js") }}"></script>
@endpush