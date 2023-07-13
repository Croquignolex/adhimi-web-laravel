@props(['creator' => true])

<div class="table-responsive">
    <table class="table table-bordered table-hover mb-2">
        <thead>
        <tr>
            <th>@lang('field.actions')</th>
            <th>@lang('field.creation')</th>
            <th>@lang('field.name') <i data-feather="search" class="text-secondary"></i></th>
            <th>@lang('field.phone_code') <i data-feather="search" class="text-secondary"></i></th>
            <th>@lang('field.status')</th>
            @if($creator)
                <th>@lang('field.creator')</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @forelse($countries as $country)
            <tr>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                            <i data-feather="more-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.countries.show', [$country]) }}">
                                <i data-feather="eye" class="mr-50 text-primary"></i>
                                @lang('general.action.detail')
                            </a>
                            @if(auth()->user()->is_admin)
                                <a class="dropdown-item" href="{{ route('admin.countries.edit', [$country]) }}">
                                    <i data-feather="edit" class="mr-50 text-warning"></i>
                                    @lang('general.action.update')
                                </a>
                                <hr>
                                <a href="javascript:void(0);" class="dropdown-item"
                                   data-toggle="modal" data-target="#toggle-status-modal-{{ $country->id }}"
                                >
                                    <i data-feather="{{ $country->status_toggle['icon'] }}" class="mr-50 text-{{ $country->status_toggle['color'] }}"></i>
                                    <span>{{ $country->status_toggle['label'] }}</span>
                                </a>
                            @endif
                            <hr>
                            <a class="dropdown-item" href="{{ route('admin.countries.add.state', [$country]) }}">
                                <i data-feather="plus-square" class="mr-50 text-secondary"></i>
                                <span>@lang('general.action.add_state')</span>
                            </a>
                        </div>
                    </div>
                </td>
                <td style="white-space: nowrap;">
                    @include('partials.backoffice.date-badge', ['model' => $country])
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        @include('partials.backoffice.round-image', ['url' => $country->flag?->url, 'initials' => $country->initials, 'size' => 'xs'])
                        <div class="ml-50">
                            {{ $country->name }}
                        </div>
                    </div>
                </td>
                <td class="text-right">{{ $country->phone_code }}</td>
                <td class="text-center">@include('partials.backoffice.status-badge', ['model' => $country])</td>
                @if($creator)
                    <td>@include('partials.backoffice.admin.entity-data', ['model' => $country->creator])</td>
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
        {{ $countries->links('partials.backoffice.pagination') }}
    @endif
</div>

@foreach($countries as $country)
    @component('components.modal', [
        'color' => $country->status_toggle['color'],
        'id' => "toggle-status-modal-" . $country->id,
        'size' => 'modal-sm',
        'title' => $country->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $country->name, 'action' => $country->status_toggle['label']])?</p>
        <form action="{{ route('admin.countries.status.toggle', [$country]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $country->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endforeach