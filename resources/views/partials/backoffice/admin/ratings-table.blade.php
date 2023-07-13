@props(['customer' => true, 'entity' => true])

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>@lang('field.creation')</th>
            @if($entity)
                <th>@lang('field.entity')</th>
            @endif
            <th>@lang('field.note')</th>
            <th>@lang('field.status')</th>
            @if($customer)
                <th>@lang('field.customer')</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @forelse($ratings as $rating)
            <tr>
                <td style="white-space: nowrap;">
                    @include('partials.backoffice.date-badge', ['model' => $rating])
                </td>
                @if($entity)
                    <td>@include('partials.backoffice.admin.entity-data', ['model' => $rating->ratable])</td>
                @endif
                <td>{{ $rating->note }}</td>
                <td class="text-center">@include('partials.backoffice.status-badge', ['model' => $rating])</td>
                @if($customer)
                    <td>@include('partials.backoffice.admin.entity-data', ['model' => $rating->customer])</td>
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
        {{ $ratings->links('partials.backoffice.pagination') }}
    @endif
</div>

@foreach($ratings as $rating)
    @component('components.modal', [
        'color' => $rating->status_toggle['color'],
        'id' => "toggle-status-modal-" . $rating->id,
        'size' => 'modal-sm',
        'title' => $rating->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $rating->customer->name, 'action' => $rating->status_toggle['label']])?</p>
        <form action="{{ route('admin.ratings.status.toggle', [$rating]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $rating->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endforeach