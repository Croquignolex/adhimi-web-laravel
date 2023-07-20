@props(['creator' => true, 'attribute' => true])

<div class="table-responsive">
    <table class="table table-bordered table-hover mb-2">
        <thead>
        <tr>
            <th>@lang('field.actions')</th>
            <th>@lang('field.creation')</th>
            <th>@lang('field.name') <i data-feather="search" class="text-secondary"></i>
            <th>@lang('field.value') <i data-feather="search" class="text-secondary"></i>
            </th>
            <th>@lang('field.status')</th>
            @if($attribute)
                <th>@lang('field.attribute')</th>
            @endif
            @if($creator)
                <th>@lang('field.creator')</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @forelse($attributeValues as $attributeValue)
            <tr>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow"
                                data-toggle="dropdown">
                            <i data-feather="more-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item"
                               href="{{ route('admin.attribute-values.show', [$attributeValue]) }}">
                                <i data-feather="eye" class="mr-50 text-primary"></i>
                                @lang('general.action.detail')
                            </a>
                            @if(auth()->user()->is_admin)
                                <a class="dropdown-item"
                                   href="{{ route('admin.attribute-values.edit', [$attributeValue]) }}">
                                    <i data-feather="edit" class="mr-50 text-warning"></i>
                                    @lang('general.action.update')
                                </a>
                                <hr>
                                <a href="javascript:void(0);" class="dropdown-item"
                                   data-toggle="modal"
                                   data-target="#toggle-status-modal-{{ $attributeValue->id }}"
                                >
                                    <i data-feather="{{ $attributeValue->status_toggle['icon'] }}"
                                       class="mr-50 text-{{ $attributeValue->status_toggle['color'] }}"></i>
                                    <span>{{ $attributeValue->status_toggle['label'] }}</span>
                                </a>
                            @endif
                            <hr>
                            <a class="dropdown-item"
                               href="{{ route('admin.attribute-values.add.product', [$attributeValue]) }}">
                                <i data-feather="plus-square"
                                   class="mr-50 text-secondary"></i>
                                <span>@lang('general.action.add_product')</span>
                            </a>
                        </div>
                    </div>
                </td>
                <td style="white-space: nowrap;">
                    @include('partials.backoffice.date-badge', ['model' => $attributeValue])
                </td>
                <td>{{ $attributeValue->name }}</td>
                <td>{{ $attributeValue->value }}</td>
                <td class="text-center">@include('partials.backoffice.status-badge', ['model' => $attributeValue])</td>
                @if($attribute)
                    <td>@include('partials.backoffice.admin.entity-data', ['model' => $attributeValue->attribute])</td>
                @endif
                @if($creator)
                    <td>@include('partials.backoffice.admin.entity-data', ['model' => $attributeValue->creator])</td>
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
        {{ $attributeValues->links('partials.backoffice.pagination') }}
    @endif
</div>

@foreach($attributeValues as $attributeValue)
    @component('components.modal', [
        'color' => $attributeValue->status_toggle['color'],
        'id' => "toggle-status-modal-" . $attributeValue->id,
        'size' => 'modal-sm',
        'title' => $attributeValue->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $attributeValue->name, 'action' => $attributeValue->status_toggle['label']])
            ?</p>
        <form action="{{ route('admin.attribute-values.status.toggle', [$attributeValue]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $attributeValue->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endforeach