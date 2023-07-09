@extends('layouts.backoffice.admin.profile', [
    'title' => __('page.update_my_avatar'),
    'breadcrumb_items' => [
        ['url' => route('home'), 'label' => __('page.home')]
    ]
])

@section('profile.content')
    <div class="card">
        <div class="card-body">
            @include('partials.feedbacks.alert')
            @include('partials.backoffice.image-upload-area', ['model' => $user])
        </div>
    </div>
@endsection

@push('profile.vendor.scripts')
    <script src="{{ asset("custom/js/image-upload.js") }}"></script>
@endpush