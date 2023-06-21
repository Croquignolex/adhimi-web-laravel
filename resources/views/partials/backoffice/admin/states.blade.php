@props(['creator' => true, 'country' => true])

<div class="table-responsive">
    <table class="table table-bordered table-hover mb-2">
        <thead>
        <tr>
            <th>@lang('field.creation')</th>
            <th>@lang('field.name') <i data-feather="search" class="text-secondary"></i></th>
            <th>@lang('field.status')</th>
            @if($country)
                <th>@lang('field.country')</th>
            @endif
            @if($creator)
                <th>@lang('field.creator')</th>
            @endif
            <th>@lang('field.actions')</th>
        </tr>
        </thead>
        <tbody>
        @forelse($states as $state)
            <tr>
                <td style="white-space: nowrap;">
                    @include('partials.backoffice.date-badge', ['model' => $state])
                </td>
                <td>{{ $state->name }}</td>
                <td>
                    <span class="badge badge-light-{{ $state->status_badge['color'] }}">
                        {{ $state->status_badge['value'] }}
                    </span>
                </td>
                @if($country)
                    <td>@include('partials.backoffice.admin.country-data', ['model' => $state])</td>
                @endif
                @if($creator)
                    <td>@include('partials.backoffice.admin.creator-data', ['model' => $state])</td>
                @endif
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                            <i data-feather="more-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.states.show', [$state]) }}">
                                <i data-feather="eye" class="mr-50 text-primary"></i>
                                @lang('general.action.detail')
                            </a>
                            @if(auth()->user()->is_admin)
                                <a class="dropdown-item" href="{{ route('admin.states.edit', [$state]) }}">
                                    <i data-feather="edit-2" class="mr-50 text-warning"></i>
                                    @lang('general.action.update')
                                </a>
                                <hr>
                                <a href="javascript:void(0);" class="dropdown-item"
                                   data-toggle="modal" data-target="#toggle-status-modal-{{ $state->id }}"
                                >
                                    <i data-feather="{{ $state->status_toggle['icon'] }}" class="mr-50 text-{{ $state->status_toggle['color'] }}"></i>
                                    <span>{{ $state->status_toggle['label'] }}</span>
                                </a>
                            @endif
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
        {{ $states->links('partials.backoffice.pagination') }}
    @endif
</div>

@foreach($states as $state)
    @component('components.modal', [
        'color' => $state->status_toggle['color'],
        'id' => "toggle-status-modal-" . $state->id,
        'size' => 'modal-sm',
        'title' => $state->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $state->name, 'action' => $state->status_toggle['label']])?</p>
        <form action="{{ route('admin.states.status.toggle', [$state]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $state->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endforeach