@extends('layouts.backoffice.admin.organisation-show')

@section('organisation.content')
    <div class="card-body">
        <a href="{{ route('admin.organisations.add.vendor', [$organisation]) }}" class="btn btn-primary">
            <i data-feather="plus-square"></i>
            @lang('page.organisations.add_vendor')
        </a>
        @include('partials.input.search')
    </div>
    @include('partials.backoffice.admin.vendors-table', ['vendors' => $vendors, 'organisation' => false])
@endsection