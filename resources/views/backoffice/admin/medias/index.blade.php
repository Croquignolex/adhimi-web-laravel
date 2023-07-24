@extends('layouts.admin', [
    'title' => __('page.medias.all'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')]
    ]
])

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row" id="basic-table">
                    <div class="col-12">
                        @include('partials.feedbacks.alert')
                        <div class="row">
                            @foreach(\App\Enums\MediaTypeEnum::values() as $media)
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <a href="{{ route('admin.medias.index.type', [$media]) }}">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="">
                                                    <h4 class="font-weight-bolder mb-0">
                                                        @lang('general.media.' . $media)
                                                    </h4>
                                                </div>
                                                <div class="avatar bg-light-{{ random_color() }} p-50 m-0">
                                                    <div class="avatar-content">
                                                        @switch($media)
                                                            @case(\App\Enums\MediaTypeEnum::Document->value)
                                                                <i data-feather="file-text" class="font-medium-5"></i>
                                                                @break
                                                            @case(\App\Enums\MediaTypeEnum::Video->value)
                                                                <i data-feather="film" class="font-medium-5"></i>
                                                                @break
                                                            @default
                                                                <i data-feather="image" class="font-medium-5"></i>
                                                        @endswitch
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection