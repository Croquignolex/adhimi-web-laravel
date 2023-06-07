@extends('layouts.admin', [
    'title' => __('page.update_my_avatar'),
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
                                <div class="text-center">
                                    @include('partials.backoffice.round-avatar', ['user' => auth()->user(), 'class' => 'mb-1'])
                                    @include('partials.feedbacks.validation', ['field' => 'avatar'])
                                    <div class="mt-2">
                                        <button class="btn btn-primary" id="avatar-change">@lang('field.change')</button>
                                        @if(!is_null($avatar))
                                            <button class="btn btn-danger" id="avatar-delete" data-toggle="modal" data-target="#toggle-avatar-delete-modal">
                                                @lang('field.delete')
                                            </button>
                                        @endif
                                        <p class="mt-1">@lang('general.profile.avatar_recommendation')</p>
                                        <form action="" method="POST" hidden enctype="multipart/form-data" id="avatar-change-form">
                                            @csrf
                                            @method('PUT')
                                            <input type="file" id="avatar-upload" hidden accept="image/jpg,image/jpeg,image/png" name="avatar" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ right content section -->
                </div>
            </div>
        </div>
    </div>

    @component('components.modal', [
            'color' => 'danger',
            'id' => "toggle-avatar-delete-modal",
            'size' => 'modal-sm',
            'title' => __('general.profile.delete_avatar'),
        ])
        <p>@lang('general.profile.delete_avatar_question')?</p>
        <form action="" method="POST" class="text-right mt-50">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">@lang('general.yes')</button>
        </form>
    @endcomponent
@endsection

@push('vendor.scripts')
    <script src="{{ asset("custom/js/avatar.js") }}"></script>
@endpush