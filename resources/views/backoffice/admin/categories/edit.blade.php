@extends('layouts.backoffice.admin.category-edit', ['title' => __('page.categories.edit')])

@section('category.content')
    <form class="validate-form mt-1" method="POST" action="{{ route('admin.categories.update', [$category]) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('partials.input.ajax-select', [
                   'label' => __('field.group'),
                   'required' => true,
                   'field' => 'group',
                   'value' => $category->group->id,
                   'route' => route('api.groups.index'),
                   'add_url' => route('admin.groups.create'),
                   'add_text' => __('general.action.add_group'),
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.name'),
                    'field' => 'name',
                    'required' => true,
                    'value' => $category->name,
                ])
            </div>
            <div class="col-12">
                @include('partials.input.textarea', ['value' => $category->description])
            </div>
        </div>
        @include('partials.input.seo', ['model' => $category])
        <div class="row">
            <div class="col-12">
                @include('partials.input.button')
            </div>
        </div>
    </form>
@endsection

@push('category.custom.scripts')
    <script src="{{ asset("custom/js/group-select.js") }}"></script>
@endpush