<div class="table-responsive">
    <table class="table table-bordered table-hover mb-2">
        <thead>
        <tr>
            <th>@lang('field.actions')</th>
            <th>@lang('field.creation')</th>
            <th>@lang('field.first_name') <i data-feather="search" class="text-secondary"></i></th>
            <th>@lang('field.email') <i data-feather="search" class="text-secondary"></i></th>
            <th>@lang('field.phone') <i data-feather="search" class="text-secondary"></i></th>
            <th>@lang('field.status')</th>
        </tr>
        </thead>
        <tbody>
        @forelse($customers as $customer)
            <tr>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                            <i data-feather="more-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.customers.show', [$customer]) }}">
                                <i data-feather="eye" class="mr-50 text-primary"></i>
                                @lang('general.action.detail')
                            </a>
                            <hr>
                            <a href="javascript:void(0);" class="dropdown-item"
                               data-toggle="modal" data-target="#toggle-status-modal-{{ $customer->id }}"
                            >
                                <i data-feather="{{ $customer->status_toggle['icon'] }}" class="mr-50 text-{{ $customer->status_toggle['color'] }}"></i>
                                <span>{{ $customer->status_toggle['label'] }}</span>
                            </a>
                        </div>
                    </div>
                </td>
                <td style="white-space: nowrap;">
                    @include('partials.backoffice.date-badge', ['model' => $customer])
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        @include('partials.backoffice.round-image', ['url' => $customer->avatar?->url, 'initials' => $customer->initials, 'size' => 'xs'])
                        <div class="ml-50">
                            {{ $customer->first_name }}
                        </div>
                    </div>
                </td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone }}</td>
                <td class="text-center">@include('partials.backoffice.status-badge', ['model' => $customer])</td>
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
        {{ $customers->links('partials.backoffice.pagination') }}
    @endif
</div>

@foreach($customers as $customer)
    @component('components.modal', [
        'color' => $customer->status_toggle['color'],
        'id' => "toggle-status-modal-" . $customer->id,
        'size' => 'modal-sm',
        'title' => $customer->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $customer->first, 'action' => $customer->status_toggle['label']])?</p>
        <form action="{{ route('admin.customers.status.toggle', [$customer]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $customer->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endforeach