@extends('layouts.backoffice.admin.attribute-show')

@section('attribute.content')
    <div class="card-body">
        <a href="{{ route('admin.attributes.add.product', [$attribute]) }}" class="btn btn-primary">
            <i data-feather="plus-square"></i>
            @lang('page.attributes.add_product')
        </a>
        @include('partials.input.search')
    </div>
    @include('partials.backoffice.admin.products-table', ['products' => $products])
@endsection