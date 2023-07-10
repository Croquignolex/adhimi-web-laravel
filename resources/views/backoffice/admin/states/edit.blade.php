@extends('layouts.backoffice.admin.state-edit', ['title' => __('page.states.edit')])

@section('state.content')
    <form class="validate-form mt-1" method="POST" action="{{ route('admin.states.update', [$state]) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('partials.input.ajax-select', [
                   'label' => __('field.country'),
                   'required' => true,
                   'field' => 'country',
                   'value' => $state->country->id,
                   'route' => route('api.countries.index'),
                   'add_url' => route('admin.countries.create'),
                   'add_text' => __('general.action.add_country'),
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.name'),
                    'field' => 'name',
                    'required' => true,
                    'value' => $state->name,
                ])
            </div>
            <div class="col-12">
                @include('partials.input.textarea', ['value' => $state->description])
            </div>
            <div class="col-12">
                @include('partials.input.button')
            </div>
        </div>
    </form>
@endsection

@push('state.custom.scripts')
    <script src="{{ asset("custom/js/country-select.js") }}"></script>
@endpush
