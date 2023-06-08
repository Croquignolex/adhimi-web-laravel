@extends('layouts.backoffice.admin.profile', [
    'title' => __('page.logs'),
    'breadcrumb_items' => [
        ['url' => route('home'), 'label' => __('page.home')]
    ]
])

@section('profile.content')
    <div class="card">
        <div class="card-body">
            @include('partials.feedbacks.alert')
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>@lang('field.creation')</th>
                        <th>@lang('field.type')</th>
                        <th>@IP</th>
                        <th>@lang('field.description')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>
                                <span class="badge badge-light-secondary">
                                    {{ format_date($log->created_at) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-light-{{ $log->action_badge['color'] }}">
                                    {{ $log->action_badge['value'] }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-light-secondary">
                                    {{ $log->ip }}
                                </span>
                            </td>
                            <td>
                                {{ $log->description }}
                                @if(!is_null($log->detail_url))
                                    <a href="{{ $log->detail_url }}" class="font-small-1">Detail...</a>
                                @endif
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
            <div>
                {{ $logs->links('partials.backoffice.pagination') }}
            </div>
        </div>
    </div>
@endsection