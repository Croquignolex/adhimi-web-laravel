@extends('layouts.backoffice.admin.profile', [
    'title' => __('page.update_my_profile'),
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
                    @if($user->hasRole([\App\Enums\UserRoleEnum::Merchant->value, \App\Enums\UserRoleEnum::ShopManager->value, \App\Enums\UserRoleEnum::Saler->value]))
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="account-store">@lang('field.store')</label>
                                <input type="text" class="form-control" id="account-store"
                                       value="{{ $user?->organisation->name }}" disabled />
                            </div>
                        </div>
                    @endif
                    @if($user->hasRole([\App\Enums\UserRoleEnum::ShopManager->value, \App\Enums\UserRoleEnum::Saler->value]))
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="account-shop">@lang('field.shop')</label>
                                <input type="text" class="form-control" id="account-shop"
                                       value="{{ $user?->shop->name }}" disabled />
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="account-first-name">
                                @lang('field.first_name') <span class="text-danger">*</span>
                                @include('partials.feedbacks.validation', ['field' => 'first_name'])
                            </label>
                            <input type="text" class="form-control" id="account-first-name"
                                   name="first_name" value="{{ old('first_name') ?? $user->first_name }}" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="account-last-name">
                                @lang('field.last_name')
                                @include('partials.feedbacks.validation', ['field' => 'last_name'])
                            </label>
                            <input type="text" class="form-control" id="account-last-name"
                                   name="last_name" value="{{ old('last_name') ?? $user->last_name }}" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="account-email">@lang('field.email')</label>
                            <input type="text" class="form-control" id="account-email"
                                   value="{{ $user->email }}" disabled />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="account-profession">
                                @lang('field.profession')
                                @include('partials.feedbacks.validation', ['field' => 'profession'])
                            </label>
                            <input type="text" class="form-control" id="account-profession"
                                   name="profession" value="{{ old('profession') ?? $user->profession }}" />
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="account-gender">
                                @lang('field.gender') <span class="text-danger">*</span>
                                @include('partials.feedbacks.validation', ['field' => 'gender'])
                            </label>
                            <select class="select2 form-control" id="account-gender" name="gender">
                                @foreach(\App\Enums\GenderEnum::values() as $gender)
                                    <option value="{{ $gender }}"
                                            {{ (old('gender') ?? $user->gender->value) == $gender ? 'selected' : '' }}>
                                        {{ $gender }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="account-birthdate">
                                @lang('field.birthdate')
                                @include('partials.feedbacks.validation', ['field' => 'birthdate'])
                            </label>
                            <input type="text" id="account-birthdate" class="form-control flatpickr-basic"
                                   name="birthdate" value="{{ old('birthdate') ?? $user->birthdate }}" />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="account-description">
                                @lang('field.description')
                                @include('partials.feedbacks.validation', ['field' => 'description'])
                            </label>
                            <textarea class="form-control" id="account-description" name="description" rows="3">{{ old('description') ?? $user->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mt-50">@lang('field.save')</button>
                    </div>
                </div>
            </form>
            <!--/ form -->
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
@endpush