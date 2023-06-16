@extends('layouts.backoffice.admin.country-show')

@section('country.content')
    <div class="card-body">
        {{--<a href="{{ route('admin.countries.edit', [$country]) }}" class="btn btn-warning mr-0 mr-sm-1 mb-1 mb-sm-0">
            <i data-feather="edit"></i>
            <span>@lang('general.action.update')</span>
        </a>--}}
        <form action="" method="GET" class="w-50 float-right">
            <div class="form-group">
                <input type="search" class="form-control" name="sq" value="{{ $q }}" placeholder="@lang('field.search')..." />
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-2">
            <thead>
                <tr>
                    <th>@lang('field.creation')</th>
                    <th>@lang('field.name') <i data-feather="search" class="text-secondary"></i></th>
                    <th>@lang('field.status')</th>
                    <th>@lang('field.creator')</th>
                    <th>@lang('field.actions')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($states as $state)
                    <tr>
                        <td style="white-space: nowrap;">
                            @include('partials.backoffice.date-badge', ['model' => $state])
                        </td>
                        <td>{{ $state->name }}</td>
                        <td>
                            <span class="badge badge-light-{{ $state->status_badge['color'] }}">
                                {{ $state->status_badge['value'] }}
                            </span>
                        </td>
                        <td>
                            @include('partials.backoffice.admin.creator-data', ['model' => $state])
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                    <i data-feather="more-vertical"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.states.show', [$state]) }}">
                                        <i data-feather="eye" class="mr-50 text-success"></i>
                                        @lang('general.action.detail')
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.states.edit', [$state]) }}">
                                        <i data-feather="edit-2" class="mr-50 text-warning"></i>
                                        @lang('general.action.update')
                                    </a>
                                    <hr>
                                    {{--                                                            TODO: add states links --}}
                                    {{--<a class="dropdown-item" href="{{ route('admin.organisations.add.store', [$organisation]) }}">
                                        <i data-feather="plus-square" class="mr-50 text-primary"></i>
                                        <span>@lang('general.action.add_store')</span>
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.organisations.add.vendor', [$organisation]) }}">
                                        <i data-feather="plus-square" class="mr-50 text-primary"></i>
                                        <span>@lang('general.action.add_vendor')</span>
                                    </a>--}}
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="alert alert-primary fade show" role="alert">
                                <div class="alert-body text-center">
                                    @lang('general.no_records')
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">
        @if(is_null($q))
            {{ $states->links('partials.backoffice.pagination') }}
        @endif
    </div>
@endsection