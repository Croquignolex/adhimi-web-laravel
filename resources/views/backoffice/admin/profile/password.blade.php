@extends('layouts.backoffice.admin.profile', [
    'title' => __('page.update_my_password'),
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
                            <label for="account-old-password">
                                @lang('field.old_password') <span class="text-danger">*</span>
                                @include('partials.feedbacks.validation', ['field' => 'old_password'])
                            </label>
                            <div class="input-group form-password-toggle input-group-merge">
                                <input type="password" class="form-control" id="account-old-password" name="old_password" />
                                <div class="input-group-append">
                                    <div class="input-group-text cursor-pointer">
                                        <i data-feather="eye"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="account-new-password">
                                @lang('field.new_password') <span class="text-danger">*</span>
                                @include('partials.feedbacks.validation', ['field' => 'password'])
                            </label>
                            <div class="input-group form-password-toggle input-group-merge">
                                <input type="password" id="account-new-password" name="password" class="form-control" />
                                <div class="input-group-append">
                                    <div class="input-group-text cursor-pointer">
                                        <i data-feather="eye"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="account-retype-new-password">
                                @lang('field.password_confirmation') <span class="text-danger">*</span>
                            </label>
                            <div class="input-group form-password-toggle input-group-merge">
                                <input type="password" class="form-control" id="account-retype-new-password" name="password_confirmation" />
                                <div class="input-group-append">
                                    <div class="input-group-text cursor-pointer"><i data-feather="eye"></i></div>
                                </div>
                            </div>
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