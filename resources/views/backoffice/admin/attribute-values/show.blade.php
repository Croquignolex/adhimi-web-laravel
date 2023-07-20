@extends('layouts.backoffice.admin.attribute-value-show')

@section('attribute_value.content')
    <div class="card-body">
        <a href="{{ route('admin.attribute-values.add.product', [$attributeValue]) }}" class="btn btn-primary">
            <i data-feather="plus-square"></i>
            @lang('page.attribute_values.add_product')
        </a>
        @include('partials.input.search')
    </div>
    @include('partials.backoffice.admin.products-table', ['products' => $products])
@endsection