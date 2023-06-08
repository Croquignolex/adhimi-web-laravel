@extends('layouts.admin', [
    'title' => __('page.shops.new'),
    'breadcrumb_items' => [
        ['url' => route('home'), 'label' => __('page.home')],
        ['url' => route('admin.organisations.index'), 'label' => __('page.shops.shops')]
    ]
])

@section('content')
    <div class="app-content content">
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
                                <form class="validate-form mt-1" method="POST" action="{{ route('admin.organisations.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-name">
                                                    @lang('field.name') <span class="text-danger">*</span>
                                                    @include('partials.feedbacks.validation', ['field' => 'name'])
                                                </label>
                                                <input type="text" class="form-control" id="account-name"
                                                       name="name" value="{{ old('name') }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-email">
                                                    @lang('field.email')
                                                    @include('partials.feedbacks.validation', ['field' => 'email'])
                                                </label>
                                                <input type="text" class="form-control" id="account-email"
                                                       name="email" value="{{ old('email') }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-website">
                                                    @lang('field.website')
                                                    @include('partials.feedbacks.validation', ['field' => 'website'])
                                                </label>
                                                <input type="text" class="form-control" id="account-website"
                                                       name="website" value="{{ old('website') }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-phone">
                                                    @lang('field.phone')
                                                    @include('partials.feedbacks.validation', ['field' => 'phone'])
                                                </label>
                                                <input type="text" class="form-control" id="account-phone"
                                                       name="phone" value="{{ old('phone') }}" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="account-description">
                                                    @lang('field.description')
                                                    @include('partials.feedbacks.validation', ['field' => 'description'])
                                                </label>
                                                <textarea class="form-control" id="account-description" name="description" rows="3">{{ old('description') }}</textarea>
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
                </div>
            </div>
        </div>
    </div>
@endsection