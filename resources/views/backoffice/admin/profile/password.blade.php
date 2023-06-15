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
                        @include('partials.input.password', [
                            'label' => __('field.old_password'),
                            'field' => 'old_password',
                        ])
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        @include('partials.input.password', [
                            'label' => __('field.new_password'),
                            'field' => 'password',
                        ])
                    </div>
                    <div class="col-12 col-sm-6">
                        @include('partials.input.password', [
                           'label' => __('field.password_confirmation'),
                           'field' => 'password_confirmation',
                       ])
                    </div>
                    <div class="col-12">
                        @include('partials.input.button')
                    </div>
                </div>
            </form>
            <!--/ form -->
        </div>
    </div>
@endsection