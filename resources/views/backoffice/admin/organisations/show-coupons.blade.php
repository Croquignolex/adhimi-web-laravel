@extends('layouts.backoffice.admin.organisation-show')

@section('organisation.content')
    <div class="card-body">
        <a href="{{ route('admin.organisations.add.coupon', [$organisation]) }}" class="btn btn-primary">
            <i data-feather="plus-square"></i>
            @lang('page.organisations.add_coupon')
        </a>
        @include('partials.input.search')
    </div>
    @include('partials.backoffice.admin.coupons-table', ['coupons' => $coupons, 'organisation' => false])
@endsection