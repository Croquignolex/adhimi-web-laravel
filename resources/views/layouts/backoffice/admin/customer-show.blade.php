@extends('layouts.admin', [
    'title' => __('page.customers.detail'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.customers.index'), 'label' => __('page.customers.customers')]
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
                                    @include('partials.backoffice.round-image', ['url' => $customer->avatar?->url, 'initials' => $customer->initials])
                                </div>
                            </div>

                            <div class="col-12 col-md-8">
                                @if(auth()->user()->is_admin)
                                    <div class="mb-1">
                                        <button class="btn btn-{{ $customer->status_toggle['color'] }} mb-50"  data-toggle="modal" data-target="#toggle-status-modal">
                                            <i data-feather="{{ $customer->status_toggle['icon'] }}"></i>
                                            {{ $customer->status_toggle['label'] }}
                                        </button>
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                        <tr>
                                            <th>@lang('field.creation')</th>
                                            <td style="white-space: nowrap;">
                                                @include('partials.backoffice.date-badge', ['model' => $customer])
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.first_name')</th>
                                            <td>{{ $customer->first_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.last_name')</th>
                                            <td>{{ $customer->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.email')</th>
                                            <td>{{ $customer->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.profession')</th>
                                            <td>{{ $customer->profession }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.phone')</th>
                                            <td>{{ $customer->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.gender')</th>
                                            <td>@lang('general.sex.' . $customer->gender->value)</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.birthdate')</th>
                                            <td>
                                                <span class="badge badge-light-secondary">
                                                    {{ format_date($customer->birthdate) }}
                                                </span>
                                                <span class="badge badge-light-primary">
                                                    {{ $customer->birthdate->age }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.status')</th>
                                            <td>@include('partials.backoffice.status-badge', ['model' => $customer])</td>
                                        </tr>
                                        <tr>
                                            <th>@lang('field.description')</th>
                                            <td>
                                                {{ $customer->description }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-1">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="default-tab" data-toggle="tab" href="#default" aria-controls="default" role="tab" aria-selected="true">
                                                @lang('general.default_address')
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="billing-tab" data-toggle="tab" href="#billing" aria-controls="billing" role="tab" aria-selected="false">
                                                @lang('general.billing_address')
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="shipping-tab" data-toggle="tab" href="#shipping" aria-controls="shipping" role="tab" aria-selected="false">
                                                @lang('general.shipping_address')
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="default" aria-labelledby="default-tab" role="tabpanel">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <tbody>
                                                    <tr>
                                                        <th>@lang('field.street_address')</th>
                                                        <td>{{ $customer->defaultAddress?->street_address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.street_address_plus')</th>
                                                        <td>{{ $customer->defaultAddress?->street_address_plus }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.zipcode')</th>
                                                        <td>{{ $customer->defaultAddress?->zipcode }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.phone_number_one')</th>
                                                        <td>{{ $customer->defaultAddress?->phone_number_one }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.phone_number_two')</th>
                                                        <td>{{ $customer->defaultAddress?->phone_number_two }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.country')</th>
                                                        <td>@include('partials.backoffice.admin.entity-data', ['model' => $customer->defaultAddress?->state->country])</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.state')</th>
                                                        <td>@include('partials.backoffice.admin.entity-data', ['model' => $customer->defaultAddress?->state])</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.description')</th>
                                                        <td>{{ $customer->defaultAddress?->description }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="billing" aria-labelledby="billing-tab" role="tabpanel">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <tbody>
                                                    <tr>
                                                        <th>@lang('field.street_address')</th>
                                                        <td>{{ $customer->defaultAddress?->street_address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.street_address_plus')</th>
                                                        <td>{{ $customer->defaultAddress?->street_address_plus }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.zipcode')</th>
                                                        <td>{{ $customer->defaultAddress?->zipcode }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.phone_number_one')</th>
                                                        <td>{{ $customer->defaultAddress?->phone_number_one }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.phone_number_two')</th>
                                                        <td>{{ $customer->defaultAddress?->phone_number_two }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.country')</th>
                                                        <td>@include('partials.backoffice.admin.entity-data', ['model' => $customer->defaultAddress?->state->country])</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.state')</th>
                                                        <td>@include('partials.backoffice.admin.entity-data', ['model' => $customer->defaultAddress?->state])</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.description')</th>
                                                        <td>{{ $customer->defaultAddress?->description }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="shipping" aria-labelledby="shipping-tab" role="tabpanel">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <tbody>
                                                    <tr>
                                                        <th>@lang('field.street_address')</th>
                                                        <td>{{ $customer->defaultAddress?->street_address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.street_address_plus')</th>
                                                        <td>{{ $customer->defaultAddress?->street_address_plus }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.zipcode')</th>
                                                        <td>{{ $customer->defaultAddress?->zipcode }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.phone_number_one')</th>
                                                        <td>{{ $customer->defaultAddress?->phone_number_one }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.phone_number_two')</th>
                                                        <td>{{ $customer->defaultAddress?->phone_number_two }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.country')</th>
                                                        <td>@include('partials.backoffice.admin.entity-data', ['model' => $customer->defaultAddress?->state->country])</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.state')</th>
                                                        <td>@include('partials.backoffice.admin.entity-data', ['model' => $customer->defaultAddress?->state])</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('field.description')</th>
                                                        <td>{{ $customer->defaultAddress?->description }}</td>
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
                </div>

                <div class="card">
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-tabs justify-content-center mt-1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ active_page('admin.customers.show.ratings') }}" href="{{ route('admin.customers.show.ratings', [$customer]) }}">
                                        <i data-feather="star" class="font-medium-3"></i>
                                        <span class="font-weight-bold">
                                            @lang('page.ratings.ratings')
                                            ({{ $customer->ratings_count }})
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ active_page('admin.customers.show.logs') }}" href="{{ route('admin.customers.show.logs', [$customer]) }}">
                                        <i data-feather="file-text" class="font-medium-3"></i>
                                        <span class="font-weight-bold">@lang('general.profile.logs')</span>
                                    </a>
                                </li>
                            </ul>
                            @yield('customer.content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @component('components.modal', [
        'color' => $customer->status_toggle['color'],
        'id' => "toggle-status-modal",
        'size' => 'modal-sm',
        'title' => $customer->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $customer->first_name, 'action' => $customer->status_toggle['label']])?</p>
        <form action="{{ route('admin.customers.status.toggle', [$customer]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $customer->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endsection