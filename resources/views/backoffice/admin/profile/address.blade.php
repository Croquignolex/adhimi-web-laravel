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
                        <div class="form-group">
                            <label for="account-street-address">
                                @lang('field.street_address') <span class="text-danger">*</span>
                                @include('partials.feedbacks.validation', ['field' => 'street_address'])
                            </label>
                            <input type="text" class="form-control" id="account-street-address"
                                   name="street_address" value="{{ old('street_address') ?? $address?->street_address }}" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="account-street-address-plus">
                                @lang('field.street_address_plus')
                                @include('partials.feedbacks.validation', ['field' => 'street_address_plus'])
                            </label>
                            <input type="text" class="form-control" id="account-street-address-plus"
                                   name="street_address_plus" value="{{ old('street_address_plus') ?? $address?->street_address_plus }}" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="account-zipcode">
                                @lang('field.zipcode')
                                @include('partials.feedbacks.validation', ['field' => 'zipcode'])
                            </label>
                            <input type="text" class="form-control" id="account-zipcode"
                                   name="zipcode" value="{{ old('zipcode') ?? $address?->zipcode }}" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="account-phone-number-one">
                                @lang('field.phone_number_one')
                                @include('partials.feedbacks.validation', ['field' => 'phone_number_one'])
                            </label>
                            <input type="text" class="form-control" id="account-phone-number-one"
                                   name="phone_number_one" value="{{ old('phone_number_one') ?? $address?->phone_number_one }}" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="account-phone-number-two">
                                @lang('field.phone_number_two')
                                @include('partials.feedbacks.validation', ['field' => 'phone_number_two'])
                            </label>
                            <input type="text" class="form-control" id="account-phone-number-two"
                                   name="phone_number_two" value="{{ old('phone_number_two') ?? $address?->phone_number_two }}" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="spinner-border text-primary mt-2" id="country-loader"></div>
                        <div class="form-group" id="country-area" style="display: none">
                            <label for="country">
                                @lang('field.country') <span class="text-danger">*</span>
                                @include('partials.feedbacks.validation', ['field' => 'country'])
                            </label>
                            <select class="select2 form-control" id="country" name="country"
                                    data-option="{{ $address?->state->country->id }}" data-old="{{ old('country') }}" data-url="{{ route('api.countries.index') }}">
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="spinner-border text-primary mt-2" id="state-loader"></div>
                        <div class="form-group" id="state-area" style="display: none">
                            <label for="state">
                                @lang('field.state') <span class="text-danger">*</span>
                                @include('partials.feedbacks.validation', ['field' => 'state'])
                            </label>
                            <select class="select2 form-control" id="state" name="state"
                                    data-option="{{ $address?->state->id }}" data-old="{{ old('state') }}" data-url="{{ route('api.states.index') }}">
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="account-description">
                                @lang('field.description')
                                @include('partials.feedbacks.validation', ['field' => 'description'])
                            </label>
                            <textarea class="form-control" id="account-description" name="description" rows="3">{{ old('description') ?? $address?->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mt-50">@lang('field.save')</button>
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