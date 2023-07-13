@props(['creator' => true])

<div class="table-responsive">
    <table class="table table-bordered table-hover mb-2">
        <thead>
        <tr>
            <th>@lang('field.actions')</th>
            <th>@lang('field.creation')</th>
            <th>@lang('field.code') <i data-feather="search" class="text-secondary"></i></th>
            <th>@lang('field.discount') <i data-feather="search" class="text-secondary"></i></th>
            <th>@lang('field.uses')</th>
            <th>@lang('field.status')</th>
            @if($creator)
                <th>@lang('field.creator')</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @forelse($coupons as $coupon)
            <tr>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                            <i data-feather="more-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.coupons.show', [$coupon]) }}">
                                <i data-feather="eye" class="mr-50 text-primary"></i>
                                @lang('general.action.detail')
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.coupons.edit', [$coupon]) }}">
                                <i data-feather="edit" class="mr-50 text-warning"></i>
                                @lang('general.action.update')
                            </a>
                            <hr>
                            <a href="javascript:void(0);" class="dropdown-item"
                               data-toggle="modal" data-target="#toggle-status-modal-{{ $coupon->id }}"
                            >
                                <i data-feather="{{ $coupon->status_toggle['icon'] }}" class="mr-50 text-{{ $coupon->status_toggle['color'] }}"></i>
                                <span>{{ $coupon->status_toggle['label'] }}</span>
                            </a>
                        </div>
                    </div>
                </td>
                <td style="white-space: nowrap;">
                    @include('partials.backoffice.date-badge', ['model' => $coupon])
                </td>
                <td>{{ $coupon->code }}</td>
                <td>{{ $coupon->discount }}%</td>
                <td>{{ $coupon->total_use }}</td>
                <td class="text-center">@include('partials.backoffice.status-badge', ['model' => $coupon])</td>
                @if($creator)
                    <td>@include('partials.backoffice.admin.entity-data', ['model' => $coupon->creator])</td>
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
        {{ $coupons->links('partials.backoffice.pagination') }}
    @endif
</div>

@foreach($coupons as $coupon)
    @component('components.modal', [
        'color' => $coupon->status_toggle['color'],
        'id' => "toggle-status-modal-" . $coupon->id,
        'size' => 'modal-sm',
        'title' => $coupon->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $coupon->code, 'action' => $coupon->status_toggle['label']])?</p>
        <form action="{{ route('admin.coupons.status.toggle', [$coupon]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $coupon->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endforeach