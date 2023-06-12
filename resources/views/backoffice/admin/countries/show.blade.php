@extends('layouts.admin', [
    'title' => __('page.countries.detail', ['name' => $country->name]),
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
            <div class="content-body">
                <div class="card">
                    <!-- Product Details starts -->
                    <div class="card-body">
                        @include('partials.feedbacks.alert')
                        <div class="row">
                            <div class="col-12 col-md-4 mb-2 mb-md-0 text-center">
                                @include('partials.backoffice.round-image', ['url' => $country->flag?->url, 'initials' => $country->initials])
                                @include('partials.feedbacks.validation', ['field' => 'flag'])
                                <div class="mt-2">
                                    <button class="btn btn-primary" id="flag-change">@lang('field.change')</button>
                                    @if(!is_null($country->flag))
                                        <button class="btn btn-danger" id="flag-delete" data-toggle="modal" data-target="#toggle-flag-delete-modal">
                                            @lang('field.delete')
                                        </button>
                                    @endif
                                    <p class="mt-1">@lang('general.image_recommendation')</p>
                                    <form action="{{ route('admin.countries.flag.change', [$country]) }}" method="POST" hidden enctype="multipart/form-data" id="flag-change-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="file" id="flag-upload" hidden accept="image/jpg,image/jpeg,image/png" name="flag" />
                                    </form>
                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="mb-1">
                                    <a href="{{ route('admin.countries.edit', [$country]) }}" class="btn btn-warning mr-0 mr-sm-1 mb-1 mb-sm-0">
                                        <i data-feather="edit-2" class="mr-50"></i>
                                        <span>@lang('general.action.update')</span>
                                    </a>
                                </div>
                                <table class="table table-bordered table-hover mb-2">
                                    <tbody>
                                    <tr>
                                        <th>Creation</th>
                                        <td style="white-space: nowrap;">
                        <span class="badge badge-light-secondary">
                            {{ format_date($country->created_at) }}
                        </span>
                                            <span class="badge badge-light-secondary">
                            {{ format_time($country->created_at) }}
                        </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>@lang('field.name')</th>
                                        <td>{{ $country->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('field.phone_code')</th>
                                        <td>{{ $country->phone_code,}}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('field.status')</th>
                                        <td>
                        <span class="badge badge-light-{{ $country->status_badge['color'] }}">
                            {{ $country->status_badge['value'] }}
                        </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>@lang('field.description')</th>
                                        <td>
                                            {{ $country->description }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Product Details ends -->
                </div>
            </div>
        </div>
    </div>

    @component('components.modal', [
            'color' => 'danger',
            'id' => "toggle-flag-delete-modal",
            'size' => 'modal-sm',
            'title' => __('general.country.delete_flag'),
        ])
        <p>@lang('general.country.delete_flag_question')?</p>
        <form action="{{ route('admin.countries.flag.remove', [$country]) }}" method="POST" class="text-right mt-50">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">@lang('general.yes')</button>
        </form>
    @endcomponent
@endsection

@push('vendor.scripts')
    <script type="text/javascript">
        const flagChangeButton = $('#flag-change');
        const flagChangeForm = $('#flag-change-form');
        const flagInput = $('#flag-upload');

        flagChangeButton.on('click', () => {
            flagInput.click();
        });

        flagInput.on('change', (e) => {
            flagChangeForm.submit();
        });
    </script>
@endpush