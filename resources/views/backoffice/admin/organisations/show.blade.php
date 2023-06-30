@extends('layouts.backoffice.admin.organisation-show')

@section('organisation.content')
    <div class="card-body">
        <a href="{{ route('admin.organisations.add.shop', [$organisation]) }}" class="btn btn-primary">
            <i data-feather="plus-square"></i>
            @lang('page.organisations.add_shop')
        </a>
        @include('partials.input.search')
    </div>
    @include('partials.backoffice.admin.shops-table', ['shops' => $shops, 'organisation' => false])
@endsection