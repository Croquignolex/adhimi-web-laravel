@extends('layouts.admin', [
    'title' => __('page.countries.detail', ['name' => $country->name]),
    'breadcrumb_items' => [
        ['url' => route('home'), 'label' => __('page.home')],
        ['url' => route('admin.countries.index'), 'label' => __('page.countries.countries')]
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
                            @include('partials.feedbacks.alert')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection