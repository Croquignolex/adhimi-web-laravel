@extends('layouts.admin', [
    'title' => __('page.attributes.detail'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.attributes.index'), 'label' => __('page.attributes.attributes')]
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
                            <div class="col-12">
                                <div class="mb-1">
                                    <a href="{{ route('admin.attributes.edit', [$attribute]) }}" class="btn btn-warning mb-50">
                                        <i data-feather="edit"></i>
                                        @lang('general.action.update')
                                    </a>
                                    <button class="btn btn-{{ $attribute->status_toggle['color'] }} mb-50"  data-toggle="modal" data-target="#toggle-status-modal">
                                        <i data-feather="{{ $attribute->status_toggle['icon'] }}"></i>
                                        {{ $attribute->status_toggle['label'] }}
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                        <tr>
                                            <th>@lang('field.creation')</th>
                                            <td style="white-space: nowrap;">
                                                @include('partials.backoffice.date-badge', ['model' => $attribute])
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.name')</th>
                                            <td>{{ $attribute->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.type')</th>
                                            <td>@lang('general.type.' . $attribute->type->value)</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.status')</th>
                                            <td>@include('partials.backoffice.status-badge', ['model' => $attribute])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.creator')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $attribute->creator])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.description')</th>
                                            <td>{{ $attribute->description }}</td>
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
                            <a class="nav-link {{ active_page('admin.attributes.show') }}" href="{{ route('admin.attributes.show', [$attribute]) }}">
                                <i data-feather="users" class="font-medium-3"></i>
                                <span class="font-weight-bold">
                                    @lang('page.attribute_values.attribute_values')
                                    ({{ $attribute->attribute_values_count }})
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_page('admin.attributes.show.products') }}" href="{{ route('admin.attributes.show.products', [$attribute]) }}">
                                <i data-feather="file-text" class="font-medium-3"></i>
                                <span class="font-weight-bold">
                                    @lang('page.products.products')
                                    ({{ $attribute->attributed_products_count }})
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_page('admin.attributes.show.logs') }}" href="{{ route('admin.attributes.show.logs', [$attribute]) }}">
                                <i data-feather="file-text" class="font-medium-3"></i>
                                <span class="font-weight-bold">@lang('general.profile.logs')</span>
                            </a>
                        </li>
                    </ul>
                    @yield('attribute.content')
                </div>
            </div>
        </div>
    </div>

    @component('components.modal', [
           'color' => $attribute->status_toggle['color'],
           'id' => "toggle-status-modal",
           'size' => 'modal-sm',
           'title' => $attribute->status_toggle['label'],
       ])
        <p>@lang('general.change_status_question', ['name' => $attribute->name, 'action' => $attribute->status_toggle['label']])?</p>
        <form action="{{ route('admin.attributes.status.toggle', [$attribute]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $attribute->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endsection