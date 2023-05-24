@extends('layouts.app', [
    'title' => 'My logs',
    'breadcrumb_items' => [
        ['url' => route('home'), 'label' => 'Home']
    ]
])

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                @include('partials.feedbacks.alert')
                            </div>
                            @include('partials.logs')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection