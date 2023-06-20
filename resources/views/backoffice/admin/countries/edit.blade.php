@extends('layouts.backoffice.admin.country-edit', ['title' => __('page.countries.edit')])

@section('country.content')
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
@endsection