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
                            'value' => $address?->street_address,
                            'label' => __('field.street_address'),
                            'field' => 'street_address',
                            'required' => true,
                        ])
                    </div>
                    <div class="col-12 col-sm-6">
                        @include('partials.input.text', [
                           'value' => $address?->street_address_plus,
                           'label' => __('field.street_address_plus'),
                           'field' => 'street_address_plus'
                        ])
                    </div>
                    <div class="col-12 col-sm-6">
                        @include('partials.input.text', [
                           'value' => $address?->zipcode,
                           'label' => __('field.zipcode'),
                           'field' => 'zipcode'
                        ])
                    </div>
                    <div class="col-12 col-sm-6">
                        @include('partials.input.text', [
                           'value' => $address?->phone_number_one,
                           'label' => __('field.phone_number_one'),
                           'field' => 'phone_number_one'
                        ])
                    </div>
                    <div class="col-12 col-sm-6">
                        @include('partials.input.text', [
                           'value' => $address?->phone_number_two,
                           'label' => __('field.phone_number_two'),
                           'field' => 'phone_number_two'
                        ])
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="spinner-border text-primary mt-2" id="country-loader"></div>
                        <div class="form-group" id="country-area" style="display: none">
                            @include('partials.input.label', [
                               'label' => __('field.country'),
                               'required' => true,
                               'field' => 'country',
                            ])
                            <select class="select2 form-control" id="country" name="country"
                                    data-option="{{ $address?->state->country->id }}" data-old="{{ old('country') }}" data-url="{{ route('api.countries.index') }}">
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="spinner-border text-primary mt-2" id="state-loader"></div>
                        <div class="form-group" id="state-area" style="display: none">
                            @include('partials.input.label', [
                               'label' => __('field.state'),
                               'required' => true,
                               'field' => 'state',
                            ])
                            <select class="select2 form-control" id="state" name="state"
                                    data-option="{{ $address?->state->id }}" data-old="{{ old('state') }}" data-url="{{ route('api.states.index') }}">
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        @include('partials.input.textarea', ['value' => $address?->description])
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