@props(['creator' => true, 'organisation' => true])

<div class="table-responsive">
    <table class="table table-bordered table-hover mb-2">
        <thead>
        <tr>
            <th>@lang('field.creation')</th>
            <th>@lang('field.code') <i data-feather="search" class="text-secondary"></i></th>
            <th>@lang('field.discount') <i data-feather="search" class="text-secondary"></i></th>
            <th>@lang('field.uses')</th>
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
        @forelse($coupons as $coupon)
            <tr>
                <td style="white-space: nowrap;">
                    @include('partials.backoffice.date-badge', ['model' => $coupon])
                </td>
                <td>{{ $coupon->code }}</td>
                <td>{{ $coupon->discount }}%</td>
                <td>{{ $coupon->total_use }}</td>
                <td>@include('partials.backoffice.status-badge', ['model' => $coupon])</td>
                @if($organisation)
                    <td>@include('partials.backoffice.admin.entity-data', ['model' => $coupon->organisation])</td>
                @endif
                @if($creator)
                    <td>@include('partials.backoffice.admin.entity-data', ['model' => $coupon->creator])</td>
                @endif
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                            <i data-feather="more-vertical"></i>
                        </button>
                        {{--<div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.shops.show', [$coupon]) }}">
                                <i data-feather="eye" class="mr-50 text-primary"></i>
                                @lang('general.action.detail')
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.shops.edit', [$coupon]) }}">
                                <i data-feather="edit-2" class="mr-50 text-warning"></i>
                                @lang('general.action.update')
                            </a>
                            <hr>
                            <a href="javascript:void(0);" class="dropdown-item"
                               data-toggle="modal" data-target="#toggle-status-modal-{{ $coupon->id }}"
                            >
                                <i data-feather="{{ $coupon->status_toggle['icon'] }}" class="mr-50 text-{{ $coupon->status_toggle['color'] }}"></i>
                                <span>{{ $coupon->status_toggle['label'] }}</span>
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
        <p>@lang('general.change_status_question', ['name' => $coupon->name, 'action' => $coupon->status_toggle['label']])?</p>
        <form action="{{ route('admin.states.status.toggle', [$coupon]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $coupon->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endforeach