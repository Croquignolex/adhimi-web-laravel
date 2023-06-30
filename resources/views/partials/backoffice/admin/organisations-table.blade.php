@props(['creator' => true, 'merchant' => true])

<div class="table-responsive">
    <table class="table table-bordered table-hover mb-2">
        <thead>
        <tr>
            <th>@lang('field.creation')</th>
            <th>@lang('field.name') <i data-feather="search" class="text-secondary"></i></th>
            <th>@lang('field.phone') <i data-feather="search" class="text-secondary"></i></th>
            <th>@lang('field.status')</th>
            @if($merchant)
                <th>@lang('field.merchant')</th>
            @endif
            @if($creator)
                <th>@lang('field.creator')</th>
            @endif
            <th>@lang('field.actions')</th>
        </tr>
        </thead>
        <tbody>
        @forelse($organisations as $organisation)
            <tr>
                <td style="white-space: nowrap;">
                    @include('partials.backoffice.date-badge', ['model' => $organisation])
                </td>
                <td>
                    <div class="d-flex">
                        @include('partials.backoffice.round-image', ['url' => $organisation->logo?->url, 'initials' => $organisation->initials, 'size' => 'xs'])
                        <div class="ml-50 mt-25">
                            {{ $organisation->name }}
                        </div>
                    </div>
                </td>
                <td>{{ $organisation->phone }}</td>
                <td>@include('partials.backoffice.status-badge', ['model' => $organisation])</td>
                @if($merchant)
                    <td>@include('partials.backoffice.admin.user-data', ['user' => $organisation->merchant])</td>
                @endif
                @if($creator)
                    <td>@include('partials.backoffice.admin.user-data', ['user' => $organisation->creator])</td>
                @endif
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                            <i data-feather="more-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.organisations.show', [$organisation]) }}">
                                <i data-feather="eye" class="mr-50 text-primary"></i>
                                @lang('general.action.detail')
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.organisations.edit', [$organisation]) }}">
                                <i data-feather="edit" class="mr-50 text-warning"></i>
                                @lang('general.action.update')
                            </a>
                            <hr>
                            <a href="javascript:void(0);" class="dropdown-item"
                               data-toggle="modal" data-target="#toggle-status-modal-{{ $organisation->id }}"
                            >
                                <i data-feather="{{ $organisation->status_toggle['icon'] }}" class="mr-50 text-{{ $organisation->status_toggle['color'] }}"></i>
                                <span>{{ $organisation->status_toggle['label'] }}</span>
                            </a>
                            <hr>
                            @if($organisation->can_add_merchant)
                                <a class="dropdown-item" href="{{ route('admin.organisations.add.merchant', [$organisation]) }}">
                                    <i data-feather="plus-square" class="mr-50 text-secondary"></i>
                                    <span>@lang('page.organisations.add_merchant')</span>
                                </a>
                            @endif
                            @if($organisation->can_add_manager)
                                <a class="dropdown-item" href="{{ route('admin.organisations.add.manager', [$organisation]) }}">
                                    <i data-feather="plus-square" class="mr-50 text-secondary"></i>
                                    <span>@lang('page.organisations.add_manager')</span>
                                </a>
                            @endif
                            <a class="dropdown-item" href="{{ route('admin.organisations.add.seller', [$organisation]) }}">
                                <i data-feather="plus-square" class="mr-50 text-secondary"></i>
                                <span>@lang('page.organisations.add_seller')</span>
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.organisations.add.shop', [$organisation]) }}">
                                <i data-feather="plus-square" class="mr-50 text-secondary"></i>
                                <span>@lang('general.action.add_shop')</span>
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.organisations.add.vendor', [$organisation]) }}">
                                <i data-feather="plus-square" class="mr-50 text-secondary"></i>
                                <span>@lang('general.action.add_vendor')</span>
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.organisations.add.product', [$organisation]) }}">
                                <i data-feather="plus-square" class="mr-50 text-secondary"></i>
                                <span>@lang('page.organisations.add_product')</span>
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.organisations.add.coupon', [$organisation]) }}">
                                <i data-feather="plus-square" class="mr-50 text-secondary"></i>
                                <span>@lang('general.action.add_coupon')</span>
                            </a>
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
    @if(is_null($q))
        {{ $organisations->links('partials.backoffice.pagination') }}
    @endif
</div>

@foreach($organisations as $organisation)
    @component('components.modal', [
        'color' => $organisation->status_toggle['color'],
        'id' => "toggle-status-modal-" . $organisation->id,
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
@endforeach