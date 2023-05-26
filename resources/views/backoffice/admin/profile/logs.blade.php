@extends('layouts.admin', [
    'title' => __('page.logs'),
    'breadcrumb_items' => [
        ['url' => route('home'), 'label' => __('page.home')]
    ]
])

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row">
                    <!-- left menu section -->
                    @include('partials.backoffice.admin.profile-sidebar')
                    <!--/ left menu section -->

                    <!-- right content section -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                @include('partials.feedbacks.alert')
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>IP</th>
                                                <th>Date</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($logs as $log)
                                                <tr>
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
                                                    <td style="white-space: nowrap;">
                                                        @include('partials.backoffice.date-badge', ['date' => $log->tz_created_at])
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
                                                                No records
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
                    </div>
                    <!--/ right content section -->
                </div>
            </div>
        </div>
    </div>
@endsection