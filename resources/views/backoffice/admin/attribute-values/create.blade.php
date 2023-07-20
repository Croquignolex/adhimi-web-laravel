@extends('layouts.admin', [
    'title' => __('page.attribute_values.new'),
    'breadcrumb_items' => [
        ['url' => route('admin.home'), 'label' => __('page.home')],
        ['url' => route('admin.attribute-values.index'), 'label' => __('page.attribute_values.attribute_values')]
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
                                @include('partials.feedbacks.alert')
                                <form class="validate-form mt-1" method="POST" action="{{ route('admin.attribute-values.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            @include('partials.input.ajax-select', [
                                               'label' => __('field.attribute'),
                                               'required' => true,
                                               'field' => 'attribute',
                                               'route' => route('api.attributes.index'),
                                               'add_url' => route('admin.attributes.create'),
                                               'add_text' => __('general.action.add_attribute'),
                                            ])
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            @include('partials.input.text', [
                                                'label' => __('field.name'),
                                                'field' => 'name',
                                                'required' => true,
                                            ])
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            @include('partials.input.text', [
                                                'label' => __('field.value'),
                                                'field' => 'value',
                                                'required' => true,
                                            ])
                                        </div>
                                        <div class="col-12">
                                            @include('partials.input.textarea')
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            @include('partials.input.button')
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('vendor.styles')
    <link rel="stylesheet" type="text/css" href="{{ asset("app-assets/vendors/css/forms/select/select2.min.css") }}">
@endpush

@push('vendor.scripts')
    <script src="{{ asset("app-assets/vendors/js/forms/select/select2.full.min.js") }}"></script>
@endpush

@push('custom.scripts')
    <script src="{{ asset("custom/js/attribute-select.js") }}"></script>
@endpush