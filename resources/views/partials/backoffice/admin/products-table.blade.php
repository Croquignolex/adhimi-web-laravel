@props(['creator' => true, 'category' => true, 'brand' => true, 'organisation' => true])

<div class="table-responsive">
    <table class="table table-bordered table-hover mb-2">
        <thead>
        <tr>
            <th>@lang('field.actions')</th>
            <th>@lang('field.creation')</th>
            <th>@lang('field.name') <i data-feather="search" class="text-secondary"></i></th>
            <th>@lang('field.status')</th>
            @if($category)
                <th>@lang('field.category')</th>
            @endif
            @if($brand)
                <th>@lang('field.brand')</th>
            @endif
            @if($creator)
                <th>@lang('field.creator')</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @forelse($products as $product)
            <tr>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                            <i data-feather="more-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.products.show', [$product]) }}">
                                <i data-feather="eye" class="mr-50 text-primary"></i>
                                @lang('general.action.detail')
                            </a>
                            @if(auth()->user()->is_admin)
                                <a class="dropdown-item" href="{{ route('admin.products.edit', [$product]) }}">
                                    <i data-feather="edit" class="mr-50 text-warning"></i>
                                    @lang('general.action.update')
                                </a>
                                <hr>
                                <a href="javascript:void(0);" class="dropdown-item"
                                   data-toggle="modal" data-target="#toggle-status-modal-{{ $product->id }}"
                                >
                                    <i data-feather="{{ $product->status_toggle['icon'] }}" class="mr-50 text-{{ $product->status_toggle['color'] }}"></i>
                                    <span>{{ $product->status_toggle['label'] }}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </td>
                <td style="white-space: nowrap;">
                    @include('partials.backoffice.date-badge', ['model' => $product])
                </td>
                <td>{{ $product->name }}</td>
                <td>
                    <span class="badge badge-light-{{ $product->status_badge['color'] }}">
                        {{ $product->status_badge['value'] }}
                    </span>
                </td>
                @if($category)
                    <td>@include('partials.backoffice.admin.entity-data', ['model' => $product->category])</td>
                @endif
                @if($brand)
                    <td>@include('partials.backoffice.admin.entity-data', ['model' => $product->brand])</td>
                @endif
                @if($creator)
                    <td>@include('partials.backoffice.admin.entity-data', ['model' => $product->creator])</td>
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
        {{ $products->links('partials.backoffice.pagination') }}
    @endif
</div>

@foreach($products as $product)
    @component('components.modal', [
        'color' => $product->status_toggle['color'],
        'id' => "toggle-status-modal-" . $product->id,
        'size' => 'modal-sm',
        'title' => $product->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $product->name, 'action' => $product->status_toggle['label']])?</p>
        <form action="{{ route('admin.products.status.toggle', [$product]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $product->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endforeach