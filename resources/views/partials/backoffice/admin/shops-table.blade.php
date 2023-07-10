@props(['creator' => true, 'organisation' => true, 'manager' => true])

<div class="table-responsive">
    <table class="table table-bordered table-hover mb-2">
        <thead>
        <tr>
            <th>@lang('field.actions')</th>
            <th>@lang('field.creation')</th>
            <th>@lang('field.name') <i data-feather="search" class="text-secondary"></i></th>
            <th>@lang('field.status')</th>
            @if($organisation)
                <th>@lang('field.organisation')</th>
            @endif
            @if($manager)
                <th>@lang('field.manager')</th>
            @endif
            @if($creator)
                <th>@lang('field.creator')</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @forelse($shops as $shop)
            <tr>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                            <i data-feather="more-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.shops.show', [$shop]) }}">
                                <i data-feather="eye" class="mr-50 text-primary"></i>
                                @lang('general.action.detail')
                            </a>
                            @if(auth()->user()->is_admin)
                                <a class="dropdown-item"
                                   href="{{ route('admin.shops.edit', [$shop]) }}">
                                    <i data-feather="edit" class="mr-50 text-warning"></i>
                                    @lang('general.action.update')
                                </a>
                                <hr>
                                <a href="javascript:void(0);" class="dropdown-item"
                                   data-toggle="modal"
                                   data-target="#toggle-status-modal-{{ $shop->id }}"
                                >
                                    <i data-feather="{{ $shop->status_toggle['icon'] }}"
                                       class="mr-50 text-{{ $shop->status_toggle['color'] }}"></i>
                                    <span>{{ $shop->status_toggle['label'] }}</span>
                                </a>
                            @endif
                            <hr>
                            @if($shop->can_add_manager)
                                <a class="dropdown-item" href="{{ route('admin.shops.add.manager', [$shop]) }}">
                                    <i data-feather="plus-square" class="mr-50 text-secondary"></i>
                                    <span>@lang('page.shops.add_manager')</span>
                                </a>
                            @endif
                            <a class="dropdown-item" href="{{ route('admin.shops.add.seller', [$shop]) }}">
                                <i data-feather="plus-square" class="mr-50 text-secondary"></i>
                                <span>@lang('page.shops.add_seller')</span>
                            </a>
                        </div>
                    </div>
                </td>
                <td style="white-space: nowrap;">
                    @include('partials.backoffice.date-badge', ['model' => $shop])
                </td>
                <td>{{ $shop->name }}</td>
                <td>@include('partials.backoffice.status-badge', ['model' => $shop])</td>
                @if($organisation)
                    <td>@include('partials.backoffice.admin.entity-data', ['model' => $shop->organisation])</td>
                @endif
                @if($manager)
                    <td>@include('partials.backoffice.admin.entity-data', ['model' => $shop->manager])</td>
                @endif
                @if($creator)
                    <td>@include('partials.backoffice.admin.entity-data', ['model' => $shop->creator])</td>
                @endif
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
        {{ $shops->links('partials.backoffice.pagination') }}
    @endif
</div>

@foreach($shops as $shop)
    @component('components.modal', [
        'color' => $shop->status_toggle['color'],
        'id' => "toggle-status-modal-" . $shop->id,
        'size' => 'modal-sm',
        'title' => $shop->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $shop->name, 'action' => $shop->status_toggle['label']])?</p>
        <form action="{{ route('admin.states.status.toggle', [$shop]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $shop->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endforeach