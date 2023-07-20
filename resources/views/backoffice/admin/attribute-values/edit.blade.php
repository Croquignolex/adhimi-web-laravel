@extends('layouts.backoffice.admin.attribute-value-edit', ['title' => __('page.attribute_values.edit')])

@section('attribute_value.content')
    <form class="validate-form mt-1" method="POST" action="{{ route('admin.attribute-values.update', [$attributeValue]) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('partials.input.ajax-select', [
                  'label' => __('field.attribute'),
                  'required' => true,
                  'field' => 'attribute',
                  'value' => $attributeValue->attribute->id,
                  'route' => route('api.attributes.index'),
                  'add_url' => route('admin.attributes.create'),
                  'add_text' => __('general.action.add_attribute'),
               ])
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.name'),
                    'field' => 'name',
                    'required' => true,
                    'value' => $attributeValue->name,
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.value'),
                    'field' => 'value',
                    'required' => true,
                    'value' => $attributeValue->value,
                ])
            </div>
            <div class="col-12">
                @include('partials.input.textarea', ['value' => $attributeValue->description])
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('partials.input.button')
            </div>
        </div>
    </form>
@endsection

@push('attribute_value.custom.scripts')
    <script src="{{ asset("custom/js/attribute-select.js") }}"></script>
@endpush