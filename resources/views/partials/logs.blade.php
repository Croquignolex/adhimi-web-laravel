<div class="card-body">
    @include('partials.feedbacks.alert')
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>
                            @if(auth()->user()->id === $log->user->id)
                                Me
                            @else
                                <a href="{{ route('users.show', [$log->user]) }}">
                                    {{ $log->user->name }}
                                </a>
                            @endif
                        </td>
                        <td>
                             <span class="badge badge-light-{{ $log->action_badge['color'] }}">
                                {{ $log->action_badge['value'] }}
                            </span>
                        </td>
                        <td style="white-space: nowrap;">
                            <span class="badge badge-light-secondary">
                                {{ $log->tz_created_at['date'] }}
                            </span>
                            <span class="badge badge-light-secondary">
                                {{ $log->tz_created_at['time'] }}
                            </span>
                        </td>
                        <td>{{ $log->description }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="alert alert-primary fade show" role="alert">
                                <div class="alert-body text-center">
                                    No records
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">
        {{ $logs->links('partials.pagination') }}
    </div>
</div>