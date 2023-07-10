@extends('layouts.admin', [
    'title' => __('page.vendors.detail'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.vendors.index'), 'label' => __('page.vendors.vendors')]
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
                                    @include('partials.backoffice.round-image', ['url' => $vendor->logo?->url, 'initials' => $vendor->initials])
                                    @include('partials.feedbacks.validation', ['field' => 'logo'])
                                    @if(auth()->user()->is_admin)
                                        <div class="mt-2">
                                            <button class="btn btn-primary" id="logo-change">
                                                <i data-feather="copy"></i>
                                                @lang('field.change')
                                            </button>
                                            @if(!is_null($vendor->logo))
                                                <button class="btn btn-danger" id="logo-delete" data-toggle="modal" data-target="#toggle-logo-delete-modal">
                                                    <i data-feather="trash"></i>
                                                    @lang('field.delete')
                                                </button>
                                            @endif
                                            <p class="mt-1">@lang('general.square_image_recommendation')</p>
                                            <form action="{{ route('admin.vendors.logo.change', [$vendor]) }}" method="POST" hidden enctype="multipart/form-data" id="logo-change-form">
                                                @csrf
                                                @method('PUT')
                                                <input type="file" id="logo-upload" hidden accept="image/jpg,image/jpeg,image/png" name="logo" />
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12 col-md-8">
                                @if(auth()->user()->is_admin)
                                    <div class="mb-1">
                                        <a href="{{ route('admin.vendors.edit', [$vendor]) }}" class="btn btn-warning mb-50">
                                            <i data-feather="edit"></i>
                                            @lang('general.action.update')
                                        </a>
                                        <button class="btn btn-{{ $vendor->status_toggle['color'] }} mb-50"  data-toggle="modal" data-target="#toggle-status-modal">
                                            <i data-feather="{{ $vendor->status_toggle['icon'] }}"></i>
                                            {{ $vendor->status_toggle['label'] }}
                                        </button>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                        <tr>
                                            <th>@lang('field.creation')</th>
                                            <td style="white-space: nowrap;">
                                                @include('partials.backoffice.date-badge', ['model' => $vendor])
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.name')</th>
                                            <td>{{ $vendor->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.status')</th>
                                            <td>@include('partials.backoffice.status-badge', ['model' => $vendor])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.organisation')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $vendor->organisation])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.creator')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $vendor->creator])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.description')</th>
                                            <td>{{ $vendor->description }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-2">
                                    <a href="{{ route('admin.vendors.address', [$vendor]) }}" class="btn btn-info mb-50">
                                        <i data-feather="map-pin"></i>
                                        @lang('general.action.update_address')
                                    </a>
                                </div>

                                <div class="table-responsive mt-1">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                        <tr>
                                            <th>@lang('field.street_address')</th>
                                            <td>{{ $vendor->defaultAddress?->street_address }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.street_address_plus')</th>
                                            <td>{{ $vendor->defaultAddress?->street_address_plus }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.zipcode')</th>
                                            <td>{{ $vendor->defaultAddress?->zipcode }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.phone_number_one')</th>
                                            <td>{{ $vendor->defaultAddress?->phone_number_one }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.phone_number_two')</th>
                                            <td>{{ $vendor->defaultAddress?->phone_number_two }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.country')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $vendor->defaultAddress?->state->country])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.state')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $vendor->defaultAddress?->state])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.description')</th>
                                            <td>{{ $vendor->defaultAddress?->description }}</td>
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
                                    <a class="nav-link {{ active_page('admin.vendors.show.logs') }}" href="{{ route('admin.vendors.show.logs', [$vendor]) }}">
                                        <i data-feather="file-text" class="font-medium-3"></i>
                                        <span class="font-weight-bold">@lang('general.profile.logs')</span>
                                    </a>
                                </li>
                            </ul>
                            @yield('vendor.content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @component('components.modal', [
        'color' => 'danger',
        'id' => "toggle-logo-delete-modal",
        'size' => 'modal-sm',
        'title' => __('general.vendor.delete_logo'),
    ])
        <p>@lang('general.vendor.delete_logo_question')?</p>
        <form action="{{ route('admin.vendors.logo.remove', [$vendor]) }}" method="POST" class="text-right mt-50">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent

    @component('components.modal', [
        'color' => $vendor->status_toggle['color'],
        'id' => "toggle-status-modal",
        'size' => 'modal-sm',
        'title' => $vendor->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $vendor->name, 'action' => $vendor->status_toggle['label']])?</p>
        <form action="{{ route('admin.vendors.status.toggle', [$vendor]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $vendor->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endsection

@push('vendor.scripts')
    <script src="{{ asset("custom/js/image-upload.js") }}"></script>
@endpush