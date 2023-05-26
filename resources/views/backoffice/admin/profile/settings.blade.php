@inject('languageService', 'App\Services\LanguageService')

@extends('layouts.admin', [
    'title' => __('page.update_settings'),
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
                                <!-- form -->
                                @include('partials.feedbacks.alert')
                                <form class="validate-form mt-1" method="POST" action="">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-language">
                                                    @lang('field.language') <span class="text-danger">*</span>
                                                    @include('partials.feedbacks.validation', ['field' => 'language'])
                                                </label>
                                                <select class="select2 form-control" id="account-language" name="language">
                                                    @foreach($languageService->availableLanguages(true) as $language)
                                                        <option value="{{ $language['value'] }}"
                                                                {{ (old('language') ?? $setting->language) == $language['value'] ? 'selected' : '' }}>
                                                            {{ $language['label'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-timezone">
                                                    @lang('field.timezone') <span class="text-danger">*</span>
                                                    @include('partials.feedbacks.validation', ['field' => 'timezone'])
                                                </label>
                                                <select class="select2 form-control" id="account-timezone" name="timezone">
                                                    @foreach(DateTimeZone::listIdentifiers() as $timezone)
                                                        <option value="{{ $timezone }}"
                                                                {{ (old('timezone') ?? $setting->timezone) == $timezone ? 'selected' : '' }}
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
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="account-super-admin" name="enable_super_admin"
                                                            {{ (old('enable_super_admin') ?? $setting->enable_action_on_super_admin_notification) ? 'checked' : '' }} />
                                                    <label class="custom-control-label" for="account-super-admin">
                                                        @lang('field.notification.enable_super_admin')
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                        @if($user->hasRole([\App\Enums\UserRoleEnum::SuperAdmin->value, \App\Enums\UserRoleEnum::Admin->value]))
                                            <div class="col-12 col-sm-6 mb-2">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="account-admin" name="enable_admin"
                                                            {{ (old('enable_admin') ?? $setting->enable_action_on_admin_notification) ? 'checked' : '' }} />
                                                    <label class="custom-control-label" for="account-admin">
                                                        @lang('field.notification.enable_admin')
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                        @if($user->hasRole([\App\Enums\UserRoleEnum::SuperAdmin->value, \App\Enums\UserRoleEnum::Admin->value, \App\Enums\UserRoleEnum::Merchant->value]))
                                        <div class="col-12 col-sm-6 mb-2">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="account-merchant" name="enable_merchant"
                                                        {{ (old('enable_merchant') ?? $setting->enable_action_on_merchant_notification) ? 'checked' : '' }} />
                                                <label class="custom-control-label" for="account-merchant">
                                                    @lang('field.notification.enable_merchant')
                                                </label>
                                            </div>
                                        </div>
                                        @endif
                                        @if($user->hasRole([\App\Enums\UserRoleEnum::SuperAdmin->value, \App\Enums\UserRoleEnum::Admin->value, \App\Enums\UserRoleEnum::Merchant->value, \App\Enums\UserRoleEnum::ShopManager->value]))
                                            <div class="col-12 col-sm-6 mb-2">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="account-manager" name="enable_manager"
                                                            {{ (old('enable_manager') ?? $setting->enable_action_on_manager_notification) ? 'checked' : '' }} />
                                                    <label class="custom-control-label" for="account-manager">
                                                        @lang('field.notification.enable_manager')
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                        @if($user->hasRole([\App\Enums\UserRoleEnum::SuperAdmin->value, \App\Enums\UserRoleEnum::Admin->value, \App\Enums\UserRoleEnum::Merchant->value, \App\Enums\UserRoleEnum::ShopManager->value]))
                                            <div class="col-12 col-sm-6 mb-2">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="account-saler" name="enable_saler"
                                                            {{ (old('enable_saler') ?? $setting->enable_action_on_saler_notification) ? 'checked' : '' }} />
                                                    <label class="custom-control-label" for="account-saler">
                                                        @lang('field.notification.enable_saler')
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-2">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="account-customer" name="enable_customer"
                                                            {{ (old('enable_customer') ?? $setting->enable_action_on_customer_notification) ? 'checked' : '' }} />
                                                    <label class="custom-control-label" for="account-customer">
                                                        @lang('field.notification.enable_customer')
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                        @if($user->hasRole([\App\Enums\UserRoleEnum::Merchant->value, \App\Enums\UserRoleEnum::ShopManager->value, \App\Enums\UserRoleEnum::Saler->value]))
                                            <div class="col-12 col-sm-6 mb-2">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="account-product" name="enable_product"
                                                            {{ (old('enable_product') ?? $setting->enable_product_notification) ? 'checked' : '' }} />
                                                    <label class="custom-control-label" for="account-product">
                                                        @lang('field.notification.enable_product')
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-2">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="account-purchase" name="enable_purchase"
                                                            {{ (old('enable_purchase') ?? $setting->enable_purchase_notification) ? 'checked' : '' }} />
                                                    <label class="custom-control-label" for="account-purchase">
                                                        @lang('field.notification.enable_purchase')
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                        @if($user->hasRole([\App\Enums\UserRoleEnum::Merchant->value, \App\Enums\UserRoleEnum::ShopManager->value]))
                                            <div class="col-12 col-sm-6 mb-2">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="account-payement" name="enable_payement"
                                                            {{ (old('enable_payement') ?? $setting->enable_payment_notification) ? 'checked' : '' }} />
                                                    <label class="custom-control-label" for="account-payement">
                                                        @lang('field.notification.enable_payement')
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mt-50">@lang('field.save')</button>
                                        </div>
                                    </div>
                                </form>
                                <!--/ form -->
                            </div>
                        </div>
                    </div>
                    <!--/ right content section -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('vendor.styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/vendors/css/forms/select/select2.min.css") }}">
@endpush

@push('vendor.scripts')
    <script src="{{ asset("app-assets/vendors/js/forms/select/select2.full.min.js") }}"></script>
@endpush