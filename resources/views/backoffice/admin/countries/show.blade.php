@extends('layouts.backoffice.admin.country-show')

@section('country.content')
    <div class="card-body">
        <a href="{{ route('admin.countries.add.state', [$country]) }}" class="btn btn-primary">
            <i data-feather="plus-square"></i>
            @lang('page.countries.add_state')
        </a>
        <form action="" method="GET" class="w-50 float-right">
            <div class="form-group">
                <input type="search" class="form-control" name="q" value="{{ $q }}" placeholder="@lang('field.search')..." />
            </div>
        </form>
    </div>
    @include('partials.backoffice.admin.states', ['states' => $states, 'country' => false])
@endsection