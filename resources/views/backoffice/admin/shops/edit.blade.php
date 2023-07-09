@extends('layouts.backoffice.admin.shop-edit', ['title' => __('page.shops.edit')])

@section('shop.content')
    <form class="validate-form mt-1" method="POST" action="{{ route('admin.shops.update', [$shop]) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('partials.input.ajax-select', [
                   'label' => __('field.organisation'),
                   'required' => true,
                   'field' => 'organisation',
                    'value' => $shop->organisation->id,
                   'route' => route('api.organisations.index'),
                   'add_url' => route('admin.organisations.create'),
                   'add_text' => __('general.action.add_organisation'),
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.name'),
                    'field' => 'name',
                    'required' => true,
                    'value' => $shop->name,
                ])
            </div>
            <div class="col-12">
                @include('partials.input.textarea', ['value' => $shop->description])
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('partials.input.button')
            </div>
        </div>
    </form>
@endsection

@push('shop.custom.scripts')
    <script src="{{ asset("custom/js/organisation-select.js") }}"></script>
@endpush