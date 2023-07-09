@extends('layouts.admin', [
    'title' => __('page.organisations.detail'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.organisations.index'), 'label' => __('page.organisations.organisations')]
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
                                    @include('partials.backoffice.round-image', ['url' => $organisation->logo?->url, 'initials' => $organisation->initials])
                                    @include('partials.feedbacks.validation', ['field' => 'logo'])
                                    <div class="mt-2">
                                        <button class="btn btn-primary" id="logo-change">
                                            <i data-feather="copy"></i>
                                            @lang('field.change')
                                        </button>
                                        @if(!is_null($organisation->logo))
                                            <button class="btn btn-danger" id="logo-delete" data-toggle="modal" data-target="#toggle-logo-delete-modal">
                                                <i data-feather="trash"></i>
                                                @lang('field.delete')
                                            </button>
                                        @endif
                                        <p class="mt-1">@lang('general.square_image_recommendation')</p>
                                        <form action="{{ route('admin.organisations.logo.change', [$organisation]) }}" method="POST" hidden enctype="multipart/form-data" id="logo-change-form">
                                            @csrf
                                            @method('PUT')
                                            <input type="file" id="logo-upload" hidden accept="image/jpg,image/jpeg,image/png" name="logo" />
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-8 d-flex justify-content-center align-items-center">
                                <div class="text-center">
                                    @include('partials.backoffice.landscape-image', ['url' => $organisation->banner?->url, 'initials' => $organisation->initials])
                                    @include('partials.feedbacks.validation', ['field' => 'banner'])
                                    <div class="mt-2">
                                        <button class="btn btn-primary" id="banner-change">
                                            <i data-feather="copy"></i>
                                            @lang('field.change')
                                        </button>
                                        @if(!is_null($organisation->banner))
                                            <button class="btn btn-danger" id="banner-delete" data-toggle="modal" data-target="#toggle-banner-delete-modal">
                                                <i data-feather="trash"></i>
                                                @lang('field.delete')
                                            </button>
                                        @endif
                                        <p class="mt-1">@lang('general.landscape_image_recommendation')</p>
                                        <form action="{{ route('admin.organisations.banner.change', [$organisation]) }}" method="POST" hidden enctype="multipart/form-data" id="banner-change-form">
                                            @csrf
                                            @method('PUT')
                                            <input type="file" id="banner-upload" hidden accept="image/jpg,image/jpeg,image/png" name="banner" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1">
                                    <a href="{{ route('admin.organisations.edit', [$organisation]) }}" class="btn btn-warning mb-50">
                                        <i data-feather="edit"></i>
                                        @lang('general.action.update')
                                    </a>
                                    <button class="btn btn-{{ $organisation->status_toggle['color'] }} mb-50"  data-toggle="modal" data-target="#toggle-status-modal">
                                        <i data-feather="{{ $organisation->status_toggle['icon'] }}"></i>
                                        {{ $organisation->status_toggle['label'] }}
                                    </button>
                                    @if($organisation->can_add_merchant)
                                        <a href="{{ route('admin.organisations.add.merchant', [$organisation]) }}" class="btn btn-primary mb-50">
                                            <i data-feather="plus-square"></i>
                                            @lang('page.organisations.add_merchant')
                                        </a>
                                    @endif
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                        <tr>
                                            <th>@lang('field.creation')</th>
                                            <td style="white-space: nowrap;">
                                                @include('partials.backoffice.date-badge', ['model' => $organisation])
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.name')</th>
                                            <td>{{ $organisation->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.email')</th>
                                            <td>{{ $organisation->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.website')</th>
                                            <td>{{ $organisation->website }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.phone')</th>
                                            <td>{{ $organisation->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.status')</th>
                                            <td>@include('partials.backoffice.status-badge', ['model' => $organisation])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.merchant')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $organisation->merchant])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.creator')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $organisation->creator])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.description')</th>
                                            <td>
                                                {{ $organisation->description }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="table-responsive mt-1">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                        <tr>
                                            <th>@lang('field.seo_title')</th>
                                            <td>{{ $organisation->seo_title }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.seo_description')</th>
                                            <td>{{ $organisation->seo_description }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
                            <a class="nav-link {{ active_page('admin.organisations.show') }}" href="{{ route('admin.organisations.show', [$organisation]) }}">
                                <i data-feather="tablet" class="font-medium-3"></i>
                                <span class="font-weight-bold">
                                    @lang('page.shops.shops')
                                    ({{ $organisation->shops_count }})
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_page('admin.organisations.show.users') }}" href="{{ route('admin.organisations.show.users', [$organisation]) }}">
                                <i data-feather="users" class="font-medium-3"></i>
                                <span class="font-weight-bold">
                                    @lang('page.staffs.staffs')
                                    ({{ $organisation->users_count }})
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_page('admin.organisations.show.products') }}" href="{{ route('admin.organisations.show.products', [$organisation]) }}">
                                <i data-feather="shopping-cart" class="font-medium-3"></i>
                                <span class="font-weight-bold">
                                    @lang('page.products.products')
                                    ({{ $organisation->products_count }})
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_page('admin.organisations.show.vendors') }}" href="{{ route('admin.organisations.show.vendors', [$organisation]) }}">
                                <i data-feather="truck" class="font-medium-3"></i>
                                <span class="font-weight-bold">
                                    @lang('page.vendors.vendors')
                                    ({{ $organisation->vendors_count }})
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_page('admin.organisations.show.coupons') }}" href="{{ route('admin.organisations.show.coupons', [$organisation]) }}">
                                <i data-feather="percent" class="font-medium-3"></i>
                                <span class="font-weight-bold">
                                    @lang('page.coupons.coupons')
                                    ({{ $organisation->coupons_count }})
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_page('admin.organisations.show.logs') }}" href="{{ route('admin.organisations.show.logs', [$organisation]) }}">
                                <i data-feather="file-text" class="font-medium-3"></i>
                                <span class="font-weight-bold">@lang('general.profile.logs')</span>
                            </a>
                        </li>
                    </ul>
                    @yield('organisation.content')
                </div>
            </div>
        </div>
    </div>

    @component('components.modal', [
        'color' => 'danger',
        'id' => "toggle-logo-delete-modal",
        'size' => 'modal-sm',
        'title' => __('general.organisation.delete_logo'),
    ])
        <p>@lang('general.organisation.delete_logo_question')?</p>
        <form action="{{ route('admin.organisations.logo.remove', [$organisation]) }}" method="POST" class="text-right mt-50">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent

    @component('components.modal', [
        'color' => 'danger',
        'id' => "toggle-banner-delete-modal",
        'size' => 'modal-sm',
        'title' => __('general.organisation.delete_banner'),
    ])
        <p>@lang('general.organisation.delete_banner_question')?</p>
        <form action="{{ route('admin.organisations.banner.remove', [$organisation]) }}" method="POST" class="text-right mt-50">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent

    @component('components.modal', [
           'color' => $organisation->status_toggle['color'],
           'id' => "toggle-status-modal",
           'size' => 'modal-sm',
           'title' => $organisation->status_toggle['label'],
       ])
        <p>@lang('general.change_status_question', ['name' => $organisation->name, 'action' => $organisation->status_toggle['label']])?</p>
        <form action="{{ route('admin.organisations.status.toggle', [$organisation]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $organisation->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endsection

@push('vendor.scripts')
    <script src="{{ asset("custom/js/image-upload.js") }}"></script>
@endpush