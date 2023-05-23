@inject('languageService', 'App\Services\LanguageService')

@extends('layouts.app', [
    'title' => 'My settings',
    'breadcrumb_items' => [
        ['url' => route('home'), 'label' => 'Home']
    ]
])

@push('vendor.styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("assets/vendors/css/forms/select/select2.min.css") }}">
@endpush

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
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
                                                    Default Language*
                                                    @include('partials.feedbacks.validation', ['field' => 'language'])
                                                </label>
                                                <select class="select2 form-control" id="account-language" name="language">
                                                    @foreach($languageService->availableLanguages(true) as $language)
                                                        <option value="{{ $language['value'] }}"
                                                                {{ (old('language') ?? auth()->user()->setting->language) == $language['value'] ? 'selected' : '' }}>
                                                            {{ $language['label'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-timezone">
                                                    Default timezone*
                                                    @include('partials.feedbacks.validation', ['field' => 'timezone'])
                                                </label>
                                                <select class="select2 form-control" id="account-timezone" name="timezone">
                                                    @foreach(DateTimeZone::listIdentifiers() as $timezone)
                                                        <option value="{{ $timezone }}"
                                                                {{ (old('timezone') ?? auth()->user()->setting->timezone) == $timezone ? 'selected' : '' }}
                                                        >
                                                            {{ $timezone }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mt-50">Save</button>
                                        </div>
                                    </div>
                                </form>
                                <!--/ form -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('vendor.scripts')
    <script src="{{ asset("assets/vendors/js/forms/select/select2.full.min.js") }}"></script>
@endpush


