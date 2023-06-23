@props(['creator' => true, 'organisation' => true, 'shop' => true])

<div class="table-responsive">
    <table class="table table-bordered table-hover mb-2">
        <thead>
        <tr>
            <th>@lang('field.creation')</th>
            <th>@lang('field.first_name') <i data-feather="search" class="text-secondary"></i></th>
            <th>@lang('field.role')
            <th>@lang('field.status')</th>
            @if($organisation)
                <th>@lang('field.organisation')</th>
            @endif
            @if($shop)
                <th>@lang('field.shop')</th>
            @endif
            @if($creator)
                <th>@lang('field.creator')</th>
            @endif
            <th>@lang('field.actions')</th>
        </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            <tr>
                <td style="white-space: nowrap;">
                    @include('partials.backoffice.date-badge', ['model' => $user])
                </td>
                <td>
                    <div class="d-flex">
                        @include('partials.backoffice.round-image', ['url' => $user->avatar?->url, 'initials' => $user->initials, 'size' => 'xs'])
                        <div class="ml-50 mt-25">
                            {{ $user->first_name }}
                        </div>
                    </div>
                </td>
                <td>@include('partials.backoffice.role-badge', compact('user'))</td>
                <td>
                    <span class="badge badge-light-{{ $user->status_badge['color'] }}">
                        {{ $user->status_badge['value'] }}
                    </span>
                </td>
                @if($organisation)
                    <td>@include('partials.backoffice.admin.organisation-data', ['model' => $user])</td>
                @endif
                @if($shop)
                    <td>
                        @if($user->shop)
                            <a href="{{ route('admin.shops.show', [$user->shop]) }}">
                                {{ $user->shop->name }}
                            </a>
                        @endif
                    </td>
                @endif
                @if($creator)
                    <td>@include('partials.backoffice.admin.user-data', ['user' => $user->creator])</td>
                @endif
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                            <i data-feather="more-vertical"></i>
                        </button>
                        {{--<div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.shops.show', [$user]) }}">
                                <i data-feather="eye" class="mr-50 text-primary"></i>
                                @lang('general.action.detail')
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.shops.edit', [$user]) }}">
                                <i data-feather="edit-2" class="mr-50 text-warning"></i>
                                @lang('general.action.update')
                            </a>
                            <hr>
                            <a href="javascript:void(0);" class="dropdown-item"
                               data-toggle="modal" data-target="#toggle-status-modal-{{ $user->id }}"
                            >
                                <i data-feather="{{ $user->status_toggle['icon'] }}" class="mr-50 text-{{ $user->status_toggle['color'] }}"></i>
                                <span>{{ $user->status_toggle['label'] }}</span>
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
        {{ $users->links('partials.backoffice.pagination') }}
    @endif
</div>

@foreach($users as $user)
    @component('components.modal', [
        'color' => $user->status_toggle['color'],
        'id' => "toggle-status-modal-" . $user->id,
        'size' => 'modal-sm',
        'title' => $user->status_toggle['label'],
    ])
        <p>@lang('general.change_status_question', ['name' => $user->name, 'action' => $user->status_toggle['label']])?</p>
        <form action="{{ route('admin.states.status.toggle', [$user]) }}" method="POST" class="text-right mt-50">
            @csrf
            <button type="submit" class="btn btn-{{ $user->status_toggle['color'] }}">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endforeach