@extends('layouts.backoffice.admin.organisation-show')

@section('organisation.content')
    <div class="card-body">
        @if($organisation->can_add_merchant)
            <a href="{{ route('admin.organisations.add.merchant', [$organisation]) }}" class="btn btn-primary mb-50">
                <i data-feather="plus-square"></i>
                @lang('page.organisations.add_merchant')
            </a>
        @endif
        @if($organisation->can_add_manager)
            <a href="{{ route('admin.organisations.add.manager', [$organisation]) }}" class="btn btn-primary mb-50">
                <i data-feather="plus-square"></i>
                @lang('page.organisations.add_manager')
            </a>
        @endif
        <a href="{{ route('admin.organisations.add.seller', [$organisation]) }}" class="btn btn-primary mb-50">
            <i data-feather="plus-square"></i>
            @lang('page.organisations.add_seller')
        </a>
        @include('partials.input.search')
    </div>
    @include('partials.backoffice.admin.users', ['users' => $users, 'organisation' => false])
@endsection