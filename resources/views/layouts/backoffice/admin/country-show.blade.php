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
                                    @include('partials.backoffice.round-image', ['url' => $flag?->url, 'initials' => $country->initials])
                                    @include('partials.feedbacks.validation', ['field' => 'flag'])
                                    <div class="mt-2">
                                        <button class="btn btn-primary" id="flag-change">
                                            <i data-feather="copy"></i>
                                            @lang('field.change')
                                        </button>
                                        @if(!is_null($flag))
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
                                                @include('partials.backoffice.date-badge', ['model' => $country])
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.name')</th>
                                            <td>{{ $country->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.phone_code')</th>
                                            <td>{{ $country->phone_code }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.states')</th>
                                            <td>{{ $country->states_count }}</td>
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
                                            <th>@lang('field.creator')</th>
                                            <td>
                                                @include('partials.backoffice.admin.creator-data', ['model' => $country])
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
                            <ul class="nav nav-tabs justify-content-center mt-1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ active_page('admin.countries.show') }}" href="{{ route('admin.countries.show', [$country]) }}">
                                        <i data-feather="map" class="font-medium-3"></i>
                                        <span class="font-weight-bold">
                                            @lang('page.states.states')
                                            ({{ $country->states_count }})
                                        </span>
                                    </a>
                                </li>
{{--                                TODO: Show products inventories --}}
                                <li class="nav-item">
                                    <a class="nav-link {{ active_page('admin.countries.show.logs') }}" href="{{ route('admin.countries.show.logs', [$country]) }}">
                                        <i data-feather="file-text" class="font-medium-3"></i>
                                        <span class="font-weight-bold">@lang('general.profile.logs')</span>
                                    </a>
                                </li>
                            </ul>
                            @yield('country.content')
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