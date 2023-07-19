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
        @forelse($attrs as $attribute)
            <tr>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow"
                                data-toggle="dropdown">
                            <i data-feather="more-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item"
                               href="{{ route('admin.attributes.show', [$attribute]) }}">
                                <i data-feather="eye" class="mr-50 text-primary"></i>
                                @lang('general.action.detail')
                            </a>
                            @if(auth()->user()->is_admin)
                                <a class="dropdown-item"
                                   href="{{ route('admin.attributes.edit', [$attribute]) }}">
                                    <i data-feather="edit" class="mr-50 text-warning"></i>
                                    @lang('general.action.update')
                                </a>
                                <hr>
                                <a href="javascript:void(0);" class="dropdown-item"
                                   data-toggle="modal"
                                   data-target="#toggle-status-modal-{{ $attribute->id }}"
                                >
                                    <i data-feather="{{ $attribute->status_toggle['icon'] }}"
                                       class="mr-50 text-{{ $attribute->status_toggle['color'] }}"></i>
                                    <span>{{ $attribute->status_toggle['label'] }}</span>
                                </a>
                            @endif
                            <hr>
                            <a class="dropdown-item"
                               href="{{ route('admin.attributes.add.attribute-value', [$attribute]) }}">
                                <i data-feather="plus-square"
                                   class="mr-50 text-secondary"></i>
                                <span>@lang('general.action.add_attribute_value')</span>
                            </a>
                            <a class="dropdown-item"
                               href="{{ route('admin.attributes.add.product', [$attribute]) }}">
                                <i data-feather="plus-square"
                                   class="mr-50 text-secondary"></i>
                                <span>@lang('general.action.add_product')</span>
                            </a>
                        </div>
                    </div>
                </td>
                <td style="white-space: nowrap;">
                    @include('partials.backoffice.date-badge', ['model' => $attribute])
                </td>
                <td>{{ $attribute->name }}</td>
                <td class="text-center">@include('partials.backoffice.status-badge', ['model' => $attribute])</td>
                @if($creator)
                    <td>@include('partials.backoffice.admin.entity-data', ['model' => $attribute->creator])</td>
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
        {{ $attrs->links('partials.backoffice.pagination') }}
    @endif
</div>

@foreach($attrs as $attribute)
    @component('components.modal', [
        'color' => $attribute->status_toggle['color'],
        'id' => "toggle-status-modal-" . $attribute->id,
        'size' => 'modal-sm',
        'title' => $attribute->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $attribute->name, 'action' => $attribute->status_toggle['label']])
            ?</p>
        <form action="{{ route('admin.attributes.status.toggle', [$attribute]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $attribute->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endforeach