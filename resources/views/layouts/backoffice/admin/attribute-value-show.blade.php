@extends('layouts.admin', [
    'title' => __('page.attribute_values.detail'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.attribute-values.index'), 'label' => __('page.attribute_values.attribute_values')]
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
                                @if(auth()->user()->is_admin)
                                    <div class="mb-1">
                                        <a href="{{ route('admin.attribute-values.edit', [$attributeValue]) }}" class="btn btn-warning mb-50">
                                            <i data-feather="edit"></i>
                                            @lang('general.action.update')
                                        </a>
                                        <button class="btn btn-{{ $attributeValue->status_toggle['color'] }} mb-50"  data-toggle="modal" data-target="#toggle-status-modal">
                                            <i data-feather="{{ $attributeValue->status_toggle['icon'] }}"></i>
                                            {{ $attributeValue->status_toggle['label'] }}
                                        </button>
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                        <tr>
                                            <th>@lang('field.creation')</th>
                                            <td style="white-space: nowrap;">
                                                @include('partials.backoffice.date-badge', ['model' => $attributeValue])
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.name')</th>
                                            <td>{{ $attributeValue->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.value')</th>
                                            <td>{{ $attributeValue->value }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.status')</th>
                                            <td>@include('partials.backoffice.status-badge', ['model' => $attributeValue])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.attribute')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $attributeValue->attribute])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.creator')</th>
                                            <td>@include('partials.backoffice.admin.entity-data', ['model' => $attributeValue->creator])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.description')</th>
                                            <td>{{ $attributeValue->description }}</td>
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
                                    <a class="nav-link {{ active_page('admin.attribute-values.show') }}" href="{{ route('admin.attribute-values.show', [$attributeValue]) }}">
                                        <i data-feather="shopping-cart" class="font-medium-3"></i>
                                        <span class="font-weight-bold">
                                            @lang('page.products.products')
                                            ({{ $attributeValue->attributed_products_count }})
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ active_page('admin.attribute-values.show.logs') }}" href="{{ route('admin.attribute-values.show.logs', [$attributeValue]) }}">
                                        <i data-feather="file-text" class="font-medium-3"></i>
                                        <span class="font-weight-bold">@lang('general.profile.logs')</span>
                                    </a>
                                </li>
                            </ul>
                            @yield('attribute_value.content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @component('components.modal', [
        'color' => $attributeValue->status_toggle['color'],
        'id' => "toggle-status-modal",
        'size' => 'modal-sm',
        'title' => $attributeValue->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $attributeValue->name, 'action' => $attributeValue->status_toggle['label']])?</p>
        <form action="{{ route('admin.attribute-values.status.toggle', [$attributeValue]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $attributeValue->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endsection