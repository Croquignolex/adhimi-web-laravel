@extends('layouts.admin', [
    'title' => __('page.groups.detail'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.groups.index'), 'label' => __('page.groups.groups')]
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
                                    @include('partials.backoffice.landscape-image', ['url' => $group->banner?->url, 'initials' => $group->initials])
                                    @include('partials.feedbacks.validation', ['field' => 'banner'])
                                    @if(auth()->user()->is_admin)
                                        <div class="mt-2">
                                            <button class="btn btn-primary" id="banner-change">
                                                <i data-feather="copy"></i>
                                                @lang('field.change')
                                            </button>
                                            @if(!is_null($group->banner))
                                                <button class="btn btn-danger" id="banner-delete" data-toggle="modal" data-target="#toggle-banner-delete-modal">
                                                    <i data-feather="trash"></i>
                                                    @lang('field.delete')
                                                </button>
                                            @endif
                                            <p class="mt-1">@lang('general.square_image_recommendation')</p>
                                            <form action="{{ route('admin.groups.banner.change', [$group]) }}" method="POST" hidden enctype="multipart/form-data" id="banner-change-form">
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
                                        <a href="{{ route('admin.groups.edit', [$group]) }}" class="btn btn-warning mb-50">
                                            <i data-feather="edit"></i>
                                            @lang('general.action.update')
                                        </a>
                                        <button class="btn btn-{{ $group->status_toggle['color'] }} mb-50"  data-toggle="modal" data-target="#toggle-status-modal">
                                            <i data-feather="{{ $group->status_toggle['icon'] }}"></i>
                                            {{ $group->status_toggle['label'] }}
                                        </button>
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                        <tr>
                                            <th>@lang('field.creation')</th>
                                            <td style="white-space: nowrap;">
                                                @include('partials.backoffice.date-badge', ['model' => $group])
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.name')</th>
                                            <td>{{ $group->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.status')</th>
                                            <td>@include('partials.backoffice.status-badge', ['model' => $group])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.creator')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $group->creator])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.description')</th>
                                            <td>
                                                {{ $group->description }}
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
                                            <td>{{ $group->seo_title }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.seo_description')</th>
                                            <td>{{ $group->seo_description }}</td>
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
                                    <a class="nav-link {{ active_page('admin.groups.show') }}" href="{{ route('admin.groups.show', [$group]) }}">
                                        <i data-feather="codesandbox" class="font-medium-3"></i>
                                        <span class="font-weight-bold">
                                            @lang('page.categories.categories')
                                            ({{ $group->categories_count }})
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ active_page('admin.groups.show.products') }}" href="{{ route('admin.groups.show.products', [$group]) }}">
                                        <i data-feather="shopping-cart" class="font-medium-3"></i>
                                        <span class="font-weight-bold">
                                            @lang('page.products.products')
                                            ({{ $group->products_count }})
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ active_page('admin.groups.show.logs') }}" href="{{ route('admin.groups.show.logs', [$group]) }}">
                                        <i data-feather="file-text" class="font-medium-3"></i>
                                        <span class="font-weight-bold">@lang('general.profile.logs')</span>
                                    </a>
                                </li>
                            </ul>
                            @yield('group.content')
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
        'title' => __('general.group.delete_banner'),
    ])
        <p>@lang('general.group.delete_banner_question')?</p>
        <form action="{{ route('admin.groups.banner.remove', [$group]) }}" method="POST" class="text-right mt-50">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent

    @component('components.modal', [
        'color' => $group->status_toggle['color'],
        'id' => "toggle-status-modal",
        'size' => 'modal-sm',
        'title' => $group->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $group->name, 'action' => $group->status_toggle['label']])?</p>
        <form action="{{ route('admin.groups.status.toggle', [$group]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $group->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endsection

@push('vendor.scripts')
    <script src="{{ asset("custom/js/image-upload.js") }}"></script>
@endpush