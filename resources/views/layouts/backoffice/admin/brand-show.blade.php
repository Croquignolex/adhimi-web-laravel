@extends('layouts.admin', [
    'title' => __('page.brands.detail'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.brands.index'), 'label' => __('page.brands.brands')]
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
                                    @include('partials.backoffice.round-image', ['url' => $brand->logo?->url, 'initials' => $brand->initials])
                                    @include('partials.feedbacks.validation', ['field' => 'logo'])
                                    @if(auth()->user()->is_admin)
                                        <div class="mt-2">
                                            <button class="btn btn-primary" id="logo-change">
                                                <i data-feather="copy"></i>
                                                @lang('field.change')
                                            </button>
                                            @if(!is_null($brand->logo))
                                                <button class="btn btn-danger" id="logo-delete" data-toggle="modal" data-target="#toggle-logo-delete-modal">
                                                    <i data-feather="trash"></i>
                                                    @lang('field.delete')
                                                </button>
                                            @endif
                                            <p class="mt-1">@lang('general.square_image_recommendation')</p>
                                            <form action="{{ route('admin.brands.logo.change', [$brand]) }}" method="POST" hidden enctype="multipart/form-data" id="logo-change-form">
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
                                        <a href="{{ route('admin.brands.edit', [$brand]) }}" class="btn btn-warning mb-50">
                                            <i data-feather="edit"></i>
                                            @lang('general.action.update')
                                        </a>
                                        <button class="btn btn-{{ $brand->status_toggle['color'] }} mb-50"  data-toggle="modal" data-target="#toggle-status-modal">
                                            <i data-feather="{{ $brand->status_toggle['icon'] }}"></i>
                                            {{ $brand->status_toggle['label'] }}
                                        </button>
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                        <tr>
                                            <th>@lang('field.creation')</th>
                                            <td style="white-space: nowrap;">
                                                @include('partials.backoffice.date-badge', ['model' => $brand])
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.name')</th>
                                            <td>{{ $brand->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.website')</th>
                                            <td>{{ $brand->website }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.status')</th>
                                            <td>@include('partials.backoffice.status-badge', ['model' => $brand])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.creator')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $brand->creator])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.description')</th>
                                            <td>
                                                {{ $brand->description }}
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
                                            <td>{{ $brand->seo_title }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.seo_description')</th>
                                            <td>{{ $brand->seo_description }}</td>
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
                                    <a class="nav-link {{ active_page('admin.brands.show') }}" href="{{ route('admin.brands.show', [$brand]) }}">
                                        <i data-feather="map" class="font-medium-3"></i>
                                        <span class="font-weight-bold">
                                            @lang('page.products.products')
                                            ({{ $brand->products_count }})
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ active_page('admin.brands.show.logs') }}" href="{{ route('admin.brands.show.logs', [$brand]) }}">
                                        <i data-feather="file-text" class="font-medium-3"></i>
                                        <span class="font-weight-bold">@lang('general.profile.logs')</span>
                                    </a>
                                </li>
                            </ul>
                            @yield('brand.content')
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
        'title' => __('general.brand.delete_logo'),
    ])
        <p>@lang('general.brand.delete_logo_question')?</p>
        <form action="{{ route('admin.brands.logo.remove', [$brand]) }}" method="POST" class="text-right mt-50">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent

    @component('components.modal', [
        'color' => $brand->status_toggle['color'],
        'id' => "toggle-status-modal",
        'size' => 'modal-sm',
        'title' => $brand->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $brand->name, 'action' => $brand->status_toggle['label']])?</p>
        <form action="{{ route('admin.brands.status.toggle', [$brand]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $brand->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endsection

@push('vendor.scripts')
    <script src="{{ asset("custom/js/image-upload.js") }}"></script>
@endpush