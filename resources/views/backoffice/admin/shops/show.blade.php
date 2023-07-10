@extends('layouts.backoffice.admin.shop-show')

@section('shop.content')
    <div class="card-body">
        @if($shop->can_add_manager)
            <a href="{{ route('admin.shops.add.manager', [$shop]) }}" class="btn btn-primary mb-50">
                <i data-feather="plus-square"></i>
                @lang('page.shops.add_manager')
            </a>
        @endif
        <a href="{{ route('admin.shops.add.seller', [$shop]) }}" class="btn btn-primary mb-50">
            <i data-feather="plus-square"></i>
            @lang('page.shops.add_seller')
        </a>
        @include('partials.input.search')
    </div>
    @include('partials.backoffice.admin.users-table', ['users' => $users, 'shop' => false])
@endsection