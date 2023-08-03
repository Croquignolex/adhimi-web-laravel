@extends('layouts.backoffice.admin.profile', [
    'title' => __('page.update_my_profile'),
    'breadcrumb_items' => [
        ['url' => route('home'), 'label' => __('page.home')]
    ]
]) 

@section('profile.content')
    <div class="card">
        <div class="card-body">
            @include('partials.feedbacks.alert')
            <form class="validate-form mt-1" method="POST" action="">
                @csrf
                @method('put')
                <div class="row">
                    @if($user->hasRole([\App\Enums\UserRoleEnum::Merchant->value, \App\Enums\UserRoleEnum::ShopManager->value, \App\Enums\UserRoleEnum::Seller->value]))
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                @include('partials.input.label', ['label' => __('field.store'), 'field' => 'store'])
                                <input type="text" class="form-control" value="{{ $user->organisation?->name }}" disabled />
                            </div>
                        </div>
                    @endif
                    @if($user->hasRole([\App\Enums\UserRoleEnum::ShopManager->value, \App\Enums\UserRoleEnum::Seller->value]))
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                @include('partials.input.label', ['label' => __('field.shop'), 'field' => 'shop'])
                                <input type="text" class="form-control" value="{{ $user->shop?->name }}" disabled />
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            @include('partials.input.label', ['label' => __('field.email'), 'field' => 'email'])
                            <input type="text" class="form-control" value="{{ $user->email }}" disabled />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        @include('partials.input.text', [
                            'value' => $user->name,
                            'label' => __('field.name'),
                            'field' => 'name',
                            'required' => true,
                        ])
                    </div>
                    <div class="col-12 col-sm-6">
                        @include('partials.input.text', [
                            'value' => $user->phone,
                            'label' => __('field.phone'),
                            'field' => 'phone',
                        ])
                    </div>
                    <div class="col-12">
                        @include('partials.input.textarea', ['value' => $user->description])
                    </div>
                    <div class="col-12">
                        @include('partials.input.button')
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('profile.vendor.styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/vendors/css/forms/select/select2.min.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css") }}">
@endpush

@push('profile.page.styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/css/plugins/forms/pickers/form-flat-pickr.css") }}">
@endpush

@push('profile.vendor.scripts')
    <script src="{{ asset("app-assets/vendors/js/forms/select/select2.full.min.js") }}"></script>
    <script src="{{ asset("app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js") }}"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>
@endpush