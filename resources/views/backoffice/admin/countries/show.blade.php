@extends('layouts.admin', [
    'title' => __('page.countries.detail', ['name' => $country->name]),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.countries.index'), 'label' => __('page.countries.countries')]
    ]
])

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="card">
                    <div class="card-body">
                        @include('partials.feedbacks.alert')
                        <div class="row">
                            <div class="col-12 col-md-4 d-flex justify-content-center align-items-center">
                                <div class="text-center">
                                    @include('partials.backoffice.round-image', ['url' => $country->flag?->url, 'initials' => $country->initials])
                                    @include('partials.feedbacks.validation', ['field' => 'flag'])
                                    <div class="mt-2">
                                        <button class="btn btn-primary" id="flag-change">
                                            <i data-feather="copy"></i>
                                            @lang('field.change')
                                        </button>
                                        @if(!is_null($country->flag))
                                            <button class="btn btn-danger" id="flag-delete" data-toggle="modal" data-target="#toggle-flag-delete-modal">
                                                <i data-feather="trash"></i>
                                                @lang('field.delete')
                                            </button>
                                        @endif
                                        <p class="mt-1">@lang('general.image_recommendation')</p>
                                        <form action="{{ route('admin.countries.flag.change', [$country]) }}" method="POST" hidden enctype="multipart/form-data" id="flag-change-form">
                                            @csrf
                                            @method('PUT')
                                            <input type="file" id="flag-upload" hidden accept="image/jpg,image/jpeg,image/png" name="flag" />
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-8">
                                <div class="mb-1">
                                    <a href="{{ route('admin.countries.edit', [$country]) }}" class="btn btn-warning mr-0 mr-sm-1 mb-1 mb-sm-0">
                                        <i data-feather="edit"></i>
                                        @lang('general.action.update')
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                        <tr>
                                            <th>Creation</th>
                                            <td style="white-space: nowrap;">
                                            <span class="badge badge-light-secondary">
                                                {{ format_date($country->created_at) }}
                                            </span>
                                                <span class="badge badge-light-secondary">
                                                {{ format_time($country->created_at) }}
                                            </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.name')</th>
                                            <td>{{ $country->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.phone_code')</th>
                                            <td>{{ $country->phone_code,}}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.status')</th>
                                            <td>
                                            <span class="badge badge-light-{{ $country->status_badge['color'] }}">
                                                {{ $country->status_badge['value'] }}
                                            </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.description')</th>
                                            <td>
                                                {{ $country->description }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-body">
                                <h4 class="mb-1">@lang('page.states.states')</h4>
                                {{--<a href="{{ route('admin.countries.edit', [$country]) }}" class="btn btn-warning mr-0 mr-sm-1 mb-1 mb-sm-0">
                                    <i data-feather="edit"></i>
                                    <span>@lang('general.action.update')</span>
                                </a>--}}
                                <form action="" method="GET" class="w-50 float-right">
                                    <div class="form-group">
                                        <input type="search" class="form-control" name="sq" value="{{ $sq }}" placeholder="@lang('field.search')..." />
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
                                        <th>@lang('field.actions')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($states as $state)
                                        <tr>
                                            <td>
                                                <span class="badge badge-light-secondary">
                                                    {{ format_date($state->created_at) }}
                                                </span>
                                            </td>
                                            <td>{{ $state->name }}</td>
                                            <td>
                                                <span class="badge badge-light-{{ $state->status_badge['color'] }}">
                                                    {{ $state->status_badge['value'] }}
                                                </span>
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
                                {{ $states->links('partials.backoffice.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @component('components.modal', [
            'color' => 'danger',
            'id' => "toggle-flag-delete-modal",
            'size' => 'modal-sm',
            'title' => __('general.country.delete_flag'),
        ])
        <p>@lang('general.country.delete_flag_question')?</p>
        <form action="{{ route('admin.countries.flag.remove', [$country]) }}" method="POST" class="text-right mt-50">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">@lang('general.yes')</button>
        </form>
    @endcomponent
@endsection

@push('vendor.scripts')
    <script type="text/javascript">
        const flagChangeButton = $('#flag-change');
        const flagChangeForm = $('#flag-change-form');
        const flagInput = $('#flag-upload');

        flagChangeButton.on('click', () => {
            flagInput.click();
        });

        flagInput.on('change', (e) => {
            flagChangeForm.submit();
        });
    </script>
@endpush