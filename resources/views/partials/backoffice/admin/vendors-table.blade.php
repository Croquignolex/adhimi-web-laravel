@props(['creator' => true, 'organisation' => true])

<div class="table-responsive">
    <table class="table table-bordered table-hover mb-2">
        <thead>
        <tr>
            <th>@lang('field.creation')</th>
            <th>@lang('field.name') <i data-feather="search" class="text-secondary"></i></th>
            <th>@lang('field.status')</th>
            @if($organisation)
                <th>@lang('field.organisation')</th>
            @endif
            @if($creator)
                <th>@lang('field.creator')</th>
            @endif
            <th>@lang('field.actions')</th>
        </tr>
        </thead>
        <tbody>
        @forelse($vendors as $vendor)
            <tr>
                <td style="white-space: nowrap;">
                    @include('partials.backoffice.date-badge', ['model' => $vendor])
                </td>
                <td>
                    <div class="d-flex">
                        @include('partials.backoffice.round-image', ['url' => $vendor->logo?->url, 'initials' => $vendor->initials, 'size' => 'xs'])
                        <div class="ml-50 mt-25">
                            {{ $vendor->name }}
                        </div>
                    </div>
                </td>
                <td>@include('partials.backoffice.status-badge', ['model' => $vendor])</td>
                @if($organisation)
                    <td>@include('partials.backoffice.admin.organisation-data', ['organisation' => $vendor->organisation])</td>
                @endif
                @if($creator)
                    <td>@include('partials.backoffice.admin.user-data', ['user' => $vendor->creator])</td>
                @endif
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                            <i data-feather="more-vertical"></i>
                        </button>
                        {{--<div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.shops.show', [$vendor]) }}">
                                <i data-feather="eye" class="mr-50 text-primary"></i>
                                @lang('general.action.detail')
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.shops.edit', [$vendor]) }}">
                                <i data-feather="edit-2" class="mr-50 text-warning"></i>
                                @lang('general.action.update')
                            </a>
                            <hr>
                            <a href="javascript:void(0);" class="dropdown-item"
                               data-toggle="modal" data-target="#toggle-status-modal-{{ $vendor->id }}"
                            >
                                <i data-feather="{{ $vendor->status_toggle['icon'] }}" class="mr-50 text-{{ $vendor->status_toggle['color'] }}"></i>
                                <span>{{ $vendor->status_toggle['label'] }}</span>
                            </a>
                            <hr>
                        </div>--}}
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
        {{ $vendors->links('partials.backoffice.pagination') }}
    @endif
</div>

@foreach($vendors as $vendor)
    @component('components.modal', [
        'color' => $vendor->status_toggle['color'],
        'id' => "toggle-status-modal-" . $vendor->id,
        'size' => 'modal-sm',
        'title' => $vendor->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $vendor->name, 'action' => $vendor->status_toggle['label']])?</p>
        <form action="{{ route('admin.states.status.toggle', [$vendor]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $vendor->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endforeach