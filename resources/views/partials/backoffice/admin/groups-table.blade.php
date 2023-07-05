@props(['creator' => true])

<div class="table-responsive">
    <table class="table table-bordered table-hover mb-2">
        <thead>
        <tr>
            <th>@lang('field.creation')</th>
            <th>@lang('field.name') <i data-feather="search" class="text-secondary"></i>
            </th>
            <th>@lang('field.status')</th>
            @if($creator)
                <th>@lang('field.creator')</th>
            @endif
            <th>@lang('field.actions')</th>
        </tr>
        </thead>
        <tbody>
        @forelse($groups as $group)
            <tr>
                <td style="white-space: nowrap;">
                    @include('partials.backoffice.date-badge', ['model' => $group])
                </td>
                <td>{{ $group->name }}</td>
                <td>@include('partials.backoffice.status-badge', ['model' => $group])</td>
                @if($creator)
                    <td>@include('partials.backoffice.admin.user-data', ['user' => $group->creator])</td>
                @endif
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow"
                                data-toggle="dropdown">
                            <i data-feather="more-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item"
                               href="{{ route('admin.groups.show', [$group]) }}">
                                <i data-feather="eye" class="mr-50 text-primary"></i>
                                @lang('general.action.detail')
                            </a>
                            @if(auth()->user()->is_admin)
                                <a class="dropdown-item"
                                   href="{{ route('admin.groups.edit', [$group]) }}">
                                    <i data-feather="edit" class="mr-50 text-warning"></i>
                                    @lang('general.action.update')
                                </a>
                                <hr>
                                <a href="javascript:void(0);" class="dropdown-item"
                                   data-toggle="modal"
                                   data-target="#toggle-status-modal-{{ $group->id }}"
                                >
                                    <i data-feather="{{ $group->status_toggle['icon'] }}"
                                       class="mr-50 text-{{ $group->status_toggle['color'] }}"></i>
                                    <span>{{ $group->status_toggle['label'] }}</span>
                                </a>
                            @endif
                            <hr>
                            <a class="dropdown-item"
                               href="{{ route('admin.groups.add.category', [$group]) }}">
                                <i data-feather="plus-square"
                                   class="mr-50 text-secondary"></i>
                                <span>@lang('general.action.add_category')</span>
                            </a>
                            <a class="dropdown-item"
                               href="{{ route('admin.groups.add.product', [$group]) }}">
                                <i data-feather="plus-square"
                                   class="mr-50 text-secondary"></i>
                                <span>@lang('general.action.add_product')</span>
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
        {{ $groups->links('partials.backoffice.pagination') }}
    @endif
</div>

@foreach($groups as $group)
    @component('components.modal', [
        'color' => $group->status_toggle['color'],
        'id' => "toggle-status-modal-" . $group->id,
        'size' => 'modal-sm',
        'title' => $group->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $group->name, 'action' => $group->status_toggle['label']])
            ?</p>
        <form action="{{ route('admin.groups.status.toggle', [$group]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $group->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endforeach