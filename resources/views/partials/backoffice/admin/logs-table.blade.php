@props(['creator' => true, 'entity' => true])

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>@lang('field.creation')</th>
                @if($entity)
                    <th>@lang('field.entity')</th>
                @endif
                <th>@lang('field.type')</th>
                <th>@IP</th>
                @if($creator)
                    <th>@lang('field.user')</th>
                @endif
                <th>@lang('field.description')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr>
                    <td style="white-space: nowrap;">
                        @include('partials.backoffice.date-badge', ['model' => $log])
                    </td>
                    @if($entity)
                        <td>
                            @if($log->entity)
                                @if($log->entity['has_image'])
                                    <div class="d-flex">
                                        @include('partials.backoffice.round-image', ['url' => $log->entity['image'], 'initials' => $log->entity['initials'], 'size' => 'xs'])
                                        <div class="ml-50 mt-25">
                                            <a href="{{ $log->entity['url'] }}">
                                                {{ $log->entity['name'] }}
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ $log->entity['url'] }}">
                                        {{ $log->entity['name'] }}
                                    </a>
                                @endif
                            @endif
                        </td>
                    @endif
                    <td>
                        <span class="badge badge-light-{{ $log->action_badge['color'] }}">
                            @lang('general.action.' . $log->action_badge['value'])
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-light-secondary">
                            {{ $log->ip }}
                        </span>
                    </td>
                    @if($creator)
                        <td>@include('partials.backoffice.admin.user-data', ['user' => $log->creator])</td>
                    @endif
                    <td>{{ $log->description }}</td>
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
    {{ $logs->links('partials.backoffice.pagination') }}
</div>