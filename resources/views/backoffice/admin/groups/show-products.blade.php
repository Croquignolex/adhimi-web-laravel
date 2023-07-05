@extends('layouts.backoffice.admin.group-show')

@section('group.content')
    <div class="card-body">
        <a href="{{ route('admin.groups.add.product', [$group]) }}" class="btn btn-primary">
            <i data-feather="plus-square"></i>
            @lang('page.groups.add_product')
        </a>
        @include('partials.input.search')
    </div>
    @include('partials.backoffice.admin.products-table', ['products' => $products])
@endsection