@extends('layouts.admin', [
    'title' => __('general.media.' . $mediaTypeEnum->value),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.medias.index'), 'label' => __('page.medias.medias')]
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
                            @include('partials.backoffice.admin.medias-card', ['medias' => $medias])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection