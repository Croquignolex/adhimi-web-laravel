@extends('layouts.backoffice.admin.category-show')

@section('category.content')
    <div class="card-body">
        <a href="{{ route('admin.categories.add.product', [$category]) }}" class="btn btn-primary">
            <i data-feather="plus-square"></i>
            @lang('page.categories.add_product')
        </a>
        @include('partials.input.search')
    </div>
    @include('partials.backoffice.admin.products-table', ['products' => $products, 'category' => false])
@endsection