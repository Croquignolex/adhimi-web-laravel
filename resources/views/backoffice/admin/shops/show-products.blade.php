@extends('layouts.backoffice.admin.organisation-show')

@section('organisation.content')
    <div class="card-body">
        <a href="{{ route('admin.organisations.add.product', [$organisation]) }}" class="btn btn-primary">
            <i data-feather="plus-square"></i>
            @lang('page.organisations.add_product')
        </a>
        @include('partials.input.search')
    </div>
    @include('partials.backoffice.admin.products-table', ['products' => $products, 'organisation' => false])
@endsection