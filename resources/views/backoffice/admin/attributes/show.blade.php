@extends('layouts.backoffice.admin.attribute-show')

@section('attribute.content')
    <div class="card-body">
        <a href="{{ route('admin.attributes.add.attribute-value', [$attribute]) }}" class="btn btn-primary">
            <i data-feather="plus-square"></i>
            @lang('page.attributes.add_attribute_value')
        </a>
        @include('partials.input.search')
    </div>
    @include('partials.backoffice.admin.attribute-values-table', ['attributeValues' => $attributeValues, 'attribute' => false])
@endsection