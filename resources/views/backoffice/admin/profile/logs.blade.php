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
        </div>
        @include('partials.backoffice.admin.logs', compact('logs'))
    </div>
@endsection