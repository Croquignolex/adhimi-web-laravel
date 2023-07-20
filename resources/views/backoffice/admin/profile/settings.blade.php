@inject('languageService', 'App\Services\LanguageService')

@extends('layouts.backoffice.admin.profile', [
    'title' => __('page.update_my_settings'),
    'breadcrumb_items' => [
        ['url' => route('home'), 'label' => __('page.home')]
    ]
])

@section('profile.content')
    <div class="card">
        <div class="card-body">
            <!-- form -->
            @include('partials.feedbacks.alert')
            <form class="validate-form mt-1" method="POST" action="">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            @include('partials.input.label', [
                               'label' => __('field.language'),
                               'required' => true,
                               'field' => 'language',
                           ])
                            <select class="select2 form-control" id="language" name="language">
                                @foreach($languageService->availableLanguages(true) as $language)
                                    <option value="{{ $language['value'] }}"
                                            {{ (old('language') ?? $user->setting->language->value) == $language['value'] ? 'selected' : '' }}>
                                        {{ $language['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            @include('partials.input.label', [
                               'label' => __('field.timezone'),
                               'required' => true,
                               'field' => 'timezone',
                           ])
                            <select class="select2 form-control" id="timezone" name="timezone">
                                @foreach(DateTimeZone::listIdentifiers() as $timezone)
                                    <option value="{{ $timezone }}"
                                            {{ (old('timezone') ?? $user->setting->timezone) == $timezone ? 'selected' : '' }}
                                    >
                                        {{ $timezone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="divider divider-dark col-12">
                        <div class="divider-text font-weight-bold">@lang('general.profile.notifications')</div>
                    </div>
                    @if($user->hasRole([\App\Enums\UserRoleEnum::SuperAdmin->value]))
                        <div class="col-12 col-sm-6 mb-2">
                            @include('partials.input.checkbox', [
                                'value' => $user->setting->enable_action_on_super_admin_notification,
                                'label' => __('field.notification.enable_super_admin'),
                                'field' => 'enable_super_admin',
                                'toggle' => true,
                                'required' => true,
                            ])
                        </div>
                    @endif
                    @if($user->hasRole([\App\Enums\UserRoleEnum::SuperAdmin->value, \App\Enums\UserRoleEnum::Admin->value]))
                        <div class="col-12 col-sm-6 mb-2">
                            @include('partials.input.checkbox', [
                                'value' => $user->setting->enable_action_on_admin_notification,
                                'label' => __('field.notification.enable_admin'),
                                'field' => 'enable_admin',
                                'toggle' => true,
                                'required' => true,
                            ])
                        </div>
                    @endif
                    @if($user->hasRole([\App\Enums\UserRoleEnum::SuperAdmin->value, \App\Enums\UserRoleEnum::Admin->value, \App\Enums\UserRoleEnum::Merchant->value]))
                        <div class="col-12 col-sm-6 mb-2">
                            @include('partials.input.checkbox', [
                                'value' => $user->setting->enable_action_on_merchant_notification,
                                'label' => __('field.notification.enable_merchant'),
                                'field' => 'enable_merchant',
                                'toggle' => true,
                                'required' => true,
                            ])
                        </div>
                    @endif
                    @if($user->hasRole([\App\Enums\UserRoleEnum::SuperAdmin->value, \App\Enums\UserRoleEnum::Admin->value, \App\Enums\UserRoleEnum::Merchant->value, \App\Enums\UserRoleEnum::ShopManager->value]))
                        <div class="col-12 col-sm-6 mb-2">
                            @include('partials.input.checkbox', [
                                'value' => $user->setting->enable_action_on_manager_notification,
                                'label' => __('field.notification.enable_manager'),
                                'field' => 'enable_manager',
                                'toggle' => true,
                                'required' => true,
                            ])
                        </div>
                    @endif
                    @if($user->hasRole([\App\Enums\UserRoleEnum::SuperAdmin->value, \App\Enums\UserRoleEnum::Admin->value, \App\Enums\UserRoleEnum::Merchant->value, \App\Enums\UserRoleEnum::ShopManager->value]))
                        <div class="col-12 col-sm-6 mb-2">
                            @include('partials.input.checkbox', [
                                'value' => $user->setting->enable_action_on_saler_notification,
                                'label' => __('field.notification.enable_saler'),
                                'field' => 'enable_saler',
                                'toggle' => true,
                                'required' => true,
                            ])
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            @include('partials.input.checkbox', [
                               'value' => $user->setting->enable_action_on_customer_notification,
                                'label' => __('field.notification.enable_customer'),
                                'field' => 'enable_customer',
                                'toggle' => true,
                                'required' => true,
                            ])
                        </div>
                    @endif
                    @if($user->hasRole([\App\Enums\UserRoleEnum::Merchant->value, \App\Enums\UserRoleEnum::ShopManager->value, \App\Enums\UserRoleEnum::Seller->value]))
                        <div class="col-12 col-sm-6 mb-2">
                            @include('partials.input.checkbox', [
                                 'value' => $user->setting->enable_product_notification,
                                'label' => __('field.notification.enable_product'),
                                'field' => 'enable_product',
                                'toggle' => true,
                                'required' => true,
                            ])
                        </div>
                        <div class="col-12 col-sm-6 mb-2">
                            @include('partials.input.checkbox', [
                                'value' => $user->setting->enable_purchase_notification,
                                'label' => __('field.notification.enable_purchase'),
                                'field' => 'enable_purchase',
                                'toggle' => true,
                                'required' => true,
                            ])
                        </div>
                    @endif
                    @if($user->hasRole([\App\Enums\UserRoleEnum::Merchant->value, \App\Enums\UserRoleEnum::ShopManager->value]))
                        <div class="col-12 col-sm-6 mb-2">
                            @include('partials.input.checkbox', [
                                'value' => $user->setting->enable_payment_notification,
                                'label' => __('field.notification.enable_payement'),
                                'field' => 'enable_payement',
                                'toggle' => true,
                                'required' => true,
                            ])
                        </div>
                    @endif
                    <div class="col-12">
                        @include('partials.input.button')
                    </div>
                </div>
            </form>
            <!--/ form -->
        </div>
    </div>
@endsection

@push('profile.vendor.styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/vendors/css/forms/select/select2.min.css") }}">
@endpush

@push('profile.vendor.scripts')
    <script src="{{ asset("app-assets/vendors/js/forms/select/select2.full.min.js") }}"></script>
@endpush