@props(['creator' => true])

<div class="table-responsive">
    <table class="table table-bordered table-hover mb-2">
        <thead>
        <tr>
            <th>@lang('field.actions')</th>
            <th>@lang('field.creation')</th>
            <th>@lang('field.name') <i data-feather="search" class="text-secondary"></i>
            </th>
            <th>@lang('field.status')</th>
            @if($creator)
                <th>@lang('field.creator')</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @forelse($brands as $brand)
            <tr>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow"
                                data-toggle="dropdown">
                            <i data-feather="more-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item"
                               href="{{ route('admin.brands.show', [$brand]) }}">
                                <i data-feather="eye" class="mr-50 text-primary"></i>
                                @lang('general.action.detail')
                            </a>
                            @if(auth()->user()->is_admin)
                                <a class="dropdown-item"
                                   href="{{ route('admin.brands.edit', [$brand]) }}">
                                    <i data-feather="edit" class="mr-50 text-warning"></i>
                                    @lang('general.action.update')
                                </a>
                                <hr>
                                <a href="javascript:void(0);" class="dropdown-item"
                                   data-toggle="modal"
                                   data-target="#toggle-status-modal-{{ $brand->id }}"
                                >
                                    <i data-feather="{{ $brand->status_toggle['icon'] }}"
                                       class="mr-50 text-{{ $brand->status_toggle['color'] }}"></i>
                                    <span>{{ $brand->status_toggle['label'] }}</span>
                                </a>
                            @endif
                            <hr>
                            <a class="dropdown-item"
                               href="{{ route('admin.brands.add.product', [$brand]) }}">
                                <i data-feather="plus-square"
                                   class="mr-50 text-secondary"></i>
                                <span>@lang('general.action.add_product')</span>
                            </a>
                        </div>
                    </div>
                </td>
                <td style="white-space: nowrap;">
                    @include('partials.backoffice.date-badge', ['model' => $brand])
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        @include('partials.backoffice.round-image', ['url' => $brand->logo?->url, 'initials' => $brand->initials, 'size' => 'xs'])
                        <div class="ml-50">
                            {{ $brand->name }}
                        </div>
                    </div>
                </td>
                <td class="text-center">@include('partials.backoffice.status-badge', ['model' => $brand])</td>
                @if($creator)
                    <td>@include('partials.backoffice.admin.entity-data', ['model' => $brand->creator])</td>
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
        {{ $brands->links('partials.backoffice.pagination') }}
    @endif
</div>

@foreach($brands as $brand)
    @component('components.modal', [
        'color' => $brand->status_toggle['color'],
        'id' => "toggle-status-modal-" . $brand->id,
        'size' => 'modal-sm',
        'title' => $brand->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $brand->name, 'action' => $brand->status_toggle['label']])
            ?</p>
        <form action="{{ route('admin.brands.status.toggle', [$brand]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $brand->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endforeach