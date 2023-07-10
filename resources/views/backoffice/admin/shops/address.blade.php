@extends('layouts.backoffice.admin.shop-edit', ['title' => __('general.action.update_address')])

@section('shop.content')
    <form class="validate-form mt-1" method="POST" action="">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-12">
                @include('partials.input.text', [
                    'value' => $shop->defaultAddress?->street_address,
                    'label' => __('field.street_address'),
                    'field' => 'street_address',
                    'required' => true,
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                   'value' => $shop->defaultAddress?->street_address_plus,
                   'label' => __('field.street_address_plus'),
                   'field' => 'street_address_plus'
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                   'value' => $shop->defaultAddress?->zipcode,
                   'label' => __('field.zipcode'),
                   'field' => 'zipcode'
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                   'value' => $shop->defaultAddress?->phone_number_one,
                   'label' => __('field.phone_number_one'),
                   'field' => 'phone_number_one'
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                   'value' => $shop->defaultAddress?->phone_number_two,
                   'label' => __('field.phone_number_two'),
                   'field' => 'phone_number_two'
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.ajax-select', [
                    'label' => __('field.country'),
                    'required' => true,
                    'field' => 'country',
                    'value' => $shop->defaultAddress?->state->country->id,
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
                    'value' => $shop->defaultAddress?->state->id,
                    'route' => route('api.states.index'),
                    'add_url' => route('admin.states.create'),
                    'add_text' => __('general.action.add_state'),
                ])
            </div>
            <div class="col-12">
                @include('partials.input.textarea', ['value' => $shop->defaultAddress?->description])
            </div>
            <div class="col-12">
                @include('partials.input.button')
            </div>
        </div>
    </form>
@endsection

@push('shop.custom.scripts')
    <script src="{{ asset("custom/js/country-state-select.js") }}"></script>
@endpush
