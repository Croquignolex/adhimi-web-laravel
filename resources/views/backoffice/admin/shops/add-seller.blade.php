@extends('layouts.backoffice.admin.shop-edit', ['title' => __('page.shops.add_seller')])

@section('shop.content')
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
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.email'),
                    'field' => 'email',
                    'required' => true,
                ])
            </div>
            <div class="col-12">
                @include('partials.input.textarea')
            </div>
            <div class="col-12">
                @include('partials.input.button')
            </div>
        </div>
    </form>
@endsection
