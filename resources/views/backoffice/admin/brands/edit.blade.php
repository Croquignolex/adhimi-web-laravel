@extends('layouts.backoffice.admin.brand-edit', ['title' => __('page.brands.edit')])

@section('brand.content')
    <form class="validate-form mt-1" method="POST" action="{{ route('admin.brands.update', [$brand]) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.name'),
                    'field' => 'name',
                    'required' => true,
                    'value' => $brand->name,
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.website'),
                    'field' => 'website',
                    'value' => $brand->website,
                ])
            </div>
            <div class="col-12">
                @include('partials.input.textarea', ['value' => $brand->description])
            </div>
        </div>
        @include('partials.input.seo', ['model' => $brand])
        <div class="row">
            <div class="col-12">
                @include('partials.input.button')
            </div>
        </div>
    </form>
@endsection