@props(['creator' => true, 'group' => true])

<div class="table-responsive">
    <table class="table table-bordered table-hover mb-2">
        <thead>
        <tr>
            <th>@lang('field.creation')</th>
            <th>@lang('field.name') <i data-feather="search" class="text-secondary"></i>
            </th>
            <th>@lang('field.status')</th>
            @if($group)
                <th>@lang('field.category')</th>
            @endif
            @if($creator)
                <th>@lang('field.creator')</th>
            @endif
            <th>@lang('field.actions')</th>
        </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td style="white-space: nowrap;">
                    @include('partials.backoffice.date-badge', ['model' => $category])
                </td>
                <td>{{ $category->name }}</td>
                <td>@include('partials.backoffice.status-badge', ['model' => $category])</td>
                @if($group)
                    <td>
                        <a href="{{ route('admin.groups.show', [$category->group]) }}">
                            {{ $category->group->name }}
                        </a>
                    </td>
                @endif
                @if($creator)
                    <td>@include('partials.backoffice.admin.user-data', ['user' => $category->creator])</td>
                @endif
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow"
                                data-toggle="dropdown">
                            <i data-feather="more-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item"
                               href="{{ route('admin.categories.show', [$category]) }}">
                                <i data-feather="eye" class="mr-50 text-primary"></i>
                                @lang('general.action.detail')
                            </a>
                            @if(auth()->user()->is_admin)
                                <a class="dropdown-item"
                                   href="{{ route('admin.categories.edit', [$category]) }}">
                                    <i data-feather="edit" class="mr-50 text-warning"></i>
                                    @lang('general.action.update')
                                </a>
                                <hr>
                                <a href="javascript:void(0);" class="dropdown-item"
                                   data-toggle="modal"
                                   data-target="#toggle-status-modal-{{ $category->id }}"
                                >
                                    <i data-feather="{{ $category->status_toggle['icon'] }}"
                                       class="mr-50 text-{{ $category->status_toggle['color'] }}"></i>
                                    <span>{{ $category->status_toggle['label'] }}</span>
                                </a>
                            @endif
                            <hr>
                            <a class="dropdown-item"
                               href="{{ route('admin.categories.add.product', [$category]) }}">
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
        {{ $categories->links('partials.backoffice.pagination') }}
    @endif
</div>

@foreach($categories as $category)
    @component('components.modal', [
        'color' => $category->status_toggle['color'],
        'id' => "toggle-status-modal-" . $category->id,
        'size' => 'modal-sm',
        'title' => $category->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $category->name, 'action' => $category->status_toggle['label']])
            ?</p>
        <form action="{{ route('admin.categories.status.toggle', [$category]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $category->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endforeach