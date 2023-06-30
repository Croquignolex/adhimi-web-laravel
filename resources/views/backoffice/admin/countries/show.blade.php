@extends('layouts.backoffice.admin.country-show')

@section('country.content')
    <div class="card-body">
        <a href="{{ route('admin.countries.add.state', [$country]) }}" class="btn btn-primary">
            <i data-feather="plus-square"></i>
            @lang('page.countries.add_state')
        </a>
        @include('partials.input.search')
    </div>
    @include('partials.backoffice.admin.states-table', ['states' => $states, 'country' => false])
@endsection