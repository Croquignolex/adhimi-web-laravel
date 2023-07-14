@extends('layouts.backoffice.admin.organisation-edit', ['title' => __('page.organisations.add_manager')])

@section('organisation.content')
    <form class="validate-form mt-1" method="POST" action="">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('partials.input.ajax-select', [
                   'label' => __('field.shop'),
                   'required' => true,
                   'field' => 'shop',
                   'add_url' => route('admin.organisations.add.shop', [$organisation]),
                   'add_text' => __('general.action.add_shop'),
                   'route' => route('api.organisations.shops', [$organisation]) . '?q=free',
                ])
            </div>
        </div>
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
                    'label' => __('field.email'),
                    'field' => 'email',
                    'required' => true,
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
@endsection

@push('organisation.custom.scripts')
    <script src="{{ asset("custom/js/shop-select.js") }}"></script>
@endpush

