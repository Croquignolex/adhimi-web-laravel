@extends('layouts.backoffice.admin.attribute-edit', ['title' => __('page.attributes.edit')])

@section('attribute.content')
    <form class="validate-form mt-1" method="POST" action="{{ route('admin.attributes.update', [$attribute]) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.name'),
                    'field' => 'name',
                    'required' => true,
                    'value' => $attribute->name,
                ])
            </div>
            <div class="col-12">
                @include('partials.input.textarea', ['value' => $attribute->description])
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('partials.input.button')
            </div>
        </div>
    </form>
@endsection