@extends('layouts.backoffice.admin.brand-show')

@section('brand.content')
    <div class="card-body">
        <a href="{{ route('admin.brands.add.product', [$brand]) }}" class="btn btn-primary">
            <i data-feather="plus-square"></i>
            @lang('page.brands.add_product')
        </a>
        @include('partials.input.search')
    </div>
    @include('partials.backoffice.admin.products-table', ['products' => $products, 'brand' => false])
@endsection