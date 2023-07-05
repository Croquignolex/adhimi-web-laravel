@extends('layouts.admin', [
    'title' => $title,
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.groups.index'), 'label' => __('page.groups.groups')],
        ['url' => route('admin.groups.show', [$group]), 'label' => $group->name]
    ]
])

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="card">
                <div class="card-body">
                    @include('partials.feedbacks.alert')
                    <div class="row">
                        <div class="col-12 col-md-4 d-flex flex-column justify-content-center align-items-center">
                            <div class="text-center mb-50">
                                <h4>{{ $group->name }}</h4>
                            </div>
                            <div class="text-center">
                                @include('partials.backoffice.landscape-image', ['url' => $group->banner?->url, 'initials' => $group->initials])
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            @yield('group.content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
