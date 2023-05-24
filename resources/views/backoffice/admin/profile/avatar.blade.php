@extends('layouts.admin', [
    'title' => __('page.my_profile'),
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
                                <!-- header media -->
                                <div class="media mb-1">
                                    <div id="avatar">
                                        @if(is_null($user->avatar))
                                            <div class="avatar bg-light-primary avatar-xl">
                                                <span class="avatar-content font-large-1">{{ $user->initials }}</span>
                                            </div>
                                        @else
                                            <img src="{{ $user->avatar->url }}" class="rounded" alt="profile-image" height="70" width="70" />
                                        @endif
                                    </div>

                                    <div class="media-body mt-75 ml-1">
                                        <label for="account-upload" class="btn btn-sm btn-primary mb-75 mr-75">Upload</label>
                                        <input type="file" id="account-upload" hidden accept="image/*" />
                                        <button class="btn btn-sm btn-outline-secondary mb-75">Reset</button>
                                        <p>Allowed JPG, GIF or PNG. Max size of 800kB</p>
                                    </div>
                                </div>
                                <!--/ header media -->
                                <!-- form -->
                                @include('partials.feedbacks.alert')
                                <form class="validate-form mt-1" method="POST" action="">
                                    @csrf
                                    @method('put')
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
                    </div>
                    <!--/ right content section -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('vendor.styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/vendors/css/forms/select/select2.min.css") }}">
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css") }}">
@endpush

@push('page.styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/css/plugins/forms/pickers/form-flat-pickr.css") }}">
@endpush

@push('vendor.scripts')
    <script src="{{ asset("app-assets/vendors/js/forms/select/select2.full.min.js") }}"></script>
    <script src="{{ asset("app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js") }}"></script>
@endpush