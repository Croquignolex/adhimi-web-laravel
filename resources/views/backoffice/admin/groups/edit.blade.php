@extends('layouts.backoffice.admin.group-edit', ['title' => __('page.groups.edit')])

@section('group.content')
    <form class="validate-form mt-1" method="POST" action="{{ route('admin.groups.update', [$group]) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.name'),
                    'field' => 'name',
                    'required' => true,
                    'value' => $group->name,
                ])
            </div>
            <div class="col-12">
                @include('partials.input.textarea', ['value' => $group->description])
            </div>
        </div>
        @include('partials.input.seo', ['model' => $group])
        <div class="row">
            <div class="col-12">
                @include('partials.input.button')
            </div>
        </div>
    </form>
@endsection