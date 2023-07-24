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

                        <button class="btn btn-success mb-1" data-toggle="modal" data-target="#garbage-modal">
                            <i data-feather="activity"></i>
                            @lang('field.clear')
                        </button>

                        <div class="row">
                            @foreach(\App\Enums\MediaTypeEnum::values() as $media)
                                @php
                                    $color = random_color();
                                    $dbFiles = \App\Models\Media::allowed()->where('type', $media)->count();
                                    $files = count(\Illuminate\Support\Facades\Storage::disk('public')->files($media));
                                @endphp
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <a href="{{ route('admin.medias.index.type', [$media]) }}">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="">
                                                    <h4 class="font-weight-bolder mb-0">
                                                        @lang('general.media.' . $media)
                                                        <small class="font-weight-bold">
                                                            (<span class="text-{{ $color }}">{{ $dbFiles }}</span> / <span class="text-secondary">{{ $files }}</span>)
                                                        </small>
                                                    </h4>
                                                </div>
                                                <div class="avatar bg-light-{{ $color }} p-50 m-0">
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

    @component('components.modal', [
        'color' => 'success',
        'id' => "garbage-modal",
        'size' => 'modal-sm',
        'title' => __('general.media.clear_garbage'),
    ])
        <p>@lang('general.media.clear_garbage_question')?</p>
        <form action="{{ route('admin.medias.garbage') }}" method="POST" class="text-right mt-50">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-success">
                @lang('general.yes')
            </button>
        </form>
    @endcomponent
@endsection