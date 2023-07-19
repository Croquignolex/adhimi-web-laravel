@extends('layouts.backoffice.admin.attribute-edit', ['title' => __('page.attributes.add_attribute_value')])

@section('group.content')
    <form class="validate-form mt-1" method="POST" action="">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.name'),
                    'field' => 'name',
                    'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('partials.input.textarea')
            </div>
        </div>
        @include('partials.input.seo')
        <div class="row">
            <div class="col-12">
                @include('partials.input.button')
            </div>
        </div>
    </form>
@endsection

