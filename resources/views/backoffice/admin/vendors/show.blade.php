@extends('layouts.backoffice.admin.vendor-show')

@section('vendor.content')
    {{--<div class="card-body">
        <a href="{{ route('admin.vendors.add.product', [$vendor]) }}" class="btn btn-primary">
            <i data-feather="plus-square"></i>
            @lang('page.vendors.add_product')
        </a>
        @include('partials.input.search')
    </div>
    @include('partials.backoffice.admin.products-table', ['products' => $products, 'vendor' => false])--}}
@endsection