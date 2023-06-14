@extends('layouts.admin', [
    'title' => __('page.countries.edit', ['name' => $country->name]),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.countries.index'), 'label' => __('page.countries.countries')]
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
                        <div class="col-12 col-md-4 d-flex justify-content-center align-items-center">
                            <div class="text-center">
                                @include('partials.backoffice.round-image', ['url' => $country->flag?->url, 'initials' => $country->initials])
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <!-- form -->
                            <form class="validate-form mt-1" method="POST" action="{{ route('admin.countries.update', [$country]) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="account-name">
                                                @lang('field.name') <span class="text-danger">*</span>
                                                @include('partials.feedbacks.validation', ['field' => 'name'])
                                            </label>
                                            <input type="text" class="form-control" id="account-name"
                                                   name="name" value="{{ old('name') ?? $country->name }}" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="account-phone_code">
                                                @lang('field.phone_code')
                                                @include('partials.feedbacks.validation', ['field' => 'phone_code'])
                                            </label>
                                            <input type="text" class="form-control" id="account-phone_code"
                                                   name="phone_code" value="{{ old('phone_code') ?? $country->phone_code }}" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="account-description">
                                                @lang('field.description')
                                                @include('partials.feedbacks.validation', ['field' => 'description'])
                                            </label>
                                            <textarea class="form-control" id="account-description" name="description" rows="3">{{ old('description') ?? $country->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary mt-50">
                                            @lang('field.save')
                                        </button>
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
@endsection