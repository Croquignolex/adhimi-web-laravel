@extends('layouts.admin', [
    'title' => __('page.categories.detail'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.categories.index'), 'label' => __('page.categories.categories')]
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
                                    @include('partials.backoffice.landscape-image', ['url' => $category->banner?->url, 'initials' => $category->initials])
                                    @include('partials.feedbacks.validation', ['field' => 'banner'])
                                    @if(auth()->user()->is_admin)
                                        <div class="mt-2">
                                            <button class="btn btn-primary" id="banner-change">
                                                <i data-feather="copy"></i>
                                                @lang('field.change')
                                            </button>
                                            @if(!is_null($category->banner))
                                                <button class="btn btn-danger" id="banner-delete" data-toggle="modal" data-target="#toggle-banner-delete-modal">
                                                    <i data-feather="trash"></i>
                                                    @lang('field.delete')
                                                </button>
                                            @endif
                                            <p class="mt-1">@lang('general.square_image_recommendation')</p>
                                            <form action="{{ route('admin.categories.banner.change', [$category]) }}" method="POST" hidden enctype="multipart/form-data" id="banner-change-form">
                                                @csrf
                                                @method('PUT')
                                                <input type="file" id="banner-upload" hidden accept="image/jpg,image/jpeg,image/png" name="banner" />
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12 col-md-8">
                                @if(auth()->user()->is_admin)
                                    <div class="mb-1">
                                        <a href="{{ route('admin.categories.edit', [$category]) }}" class="btn btn-warning mb-50">
                                            <i data-feather="edit"></i>
                                            @lang('general.action.update')
                                        </a>
                                        <button class="btn btn-{{ $category->status_toggle['color'] }} mb-50"  data-toggle="modal" data-target="#toggle-status-modal">
                                            <i data-feather="{{ $category->status_toggle['icon'] }}"></i>
                                            {{ $category->status_toggle['label'] }}
                                        </button>
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                        <tr>
                                            <th>@lang('field.creation')</th>
                                            <td style="white-space: nowrap;">
                                                @include('partials.backoffice.date-badge', ['model' => $category])
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.name')</th>
                                            <td>{{ $category->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.status')</th>
                                            <td>@include('partials.backoffice.status-badge', ['model' => $category])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.country')</th>
                                            <td>
                                                <a href="{{ route('admin.groups.show', [$category->group]) }}">
                                                    {{ $category->group->name }}
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.creator')</th>
                                            <td>
                                                @include('partials.backoffice.admin.user-data', ['user' => $category->creator])
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.description')</th>
                                            <td>
                                                {{ $category->description }}
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
                                            <td>{{ $category->seo_title }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.seo_description')</th>
                                            <td>{{ $category->seo_description }}</td>
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
                                    <a class="nav-link {{ active_page('admin.categories.show') }}" href="{{ route('admin.categories.show', [$category]) }}">
                                        <i data-feather="shopping-cart" class="font-medium-3"></i>
                                        <span class="font-weight-bold">
                                            @lang('page.products.products')
                                            ({{ $category->products_count }})
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ active_page('admin.categories.show.logs') }}" href="{{ route('admin.categories.show.logs', [$category]) }}">
                                        <i data-feather="file-text" class="font-medium-3"></i>
                                        <span class="font-weight-bold">@lang('general.profile.logs')</span>
                                    </a>
                                </li>
                            </ul>
                            @yield('category.content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @component('components.modal', [
        'color' => 'danger',
        'id' => "toggle-banner-delete-modal",
        'size' => 'modal-sm',
        'title' => __('general.category.delete_banner'),
    ])
        <p>@lang('general.category.delete_banner_question')?</p>
        <form action="{{ route('admin.categories.banner.remove', [$category]) }}" method="POST" class="text-right mt-50">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent

    @component('components.modal', [
        'color' => $category->status_toggle['color'],
        'id' => "toggle-status-modal",
        'size' => 'modal-sm',
        'title' => $category->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $category->name, 'action' => $category->status_toggle['label']])?</p>
        <form action="{{ route('admin.categories.status.toggle', [$category]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $category->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endsection

@push('vendor.scripts')
    <script src="{{ asset("custom/js/logo-banner-upload.js") }}"></script>
@endpush