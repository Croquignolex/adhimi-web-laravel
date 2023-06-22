@extends('layouts.backoffice.admin.organisation-edit', ['title' => __('page.organisations.edit')])

@section('organisation.content')
    <form class="validate-form mt-1" method="POST" action="{{ route('admin.organisations.update', [$organisation]) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.name'),
                    'field' => 'name',
                    'required' => true,
                    'value' => $organisation->name,
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.email'),
                    'field' => 'email',
                    'value' => $organisation->email,
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.website'),
                    'field' => 'website',
                    'value' => $organisation->website,
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.phone'),
                    'field' => 'phone',
                    'value' => $organisation->phone,
                ])
            </div>
            <div class="col-12">
                @include('partials.input.textarea', ['value' => $organisation->description])
            </div>
            <div class="col-12">
                @include('partials.input.button')
            </div>
        </div>
    </form>
@endsection