@extends('layouts.backoffice.admin.organisation-show')

@section('organisation.content')
    <div class="card-body">
        <a href="{{ route('admin.organisations.add.shop', [$organisation]) }}" class="btn btn-primary">
            <i data-feather="plus-square"></i>
            @lang('page.organisations.add_shop')
        </a>
        <form action="" method="GET" class="w-50 float-right">
            <div class="form-group">
                <input type="search" class="form-control" name="q" value="{{ $q }}" placeholder="@lang('field.search')..." />
            </div>
        </form>
    </div>
    @include('partials.backoffice.admin.shops', ['shops' => $shops, 'organisation' => false])
@endsection