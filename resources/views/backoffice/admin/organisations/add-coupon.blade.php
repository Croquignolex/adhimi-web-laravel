@extends('layouts.backoffice.admin.organisation-edit', ['title' => __('page.organisations.add_coupon')])

@section('organisation.content')
    <form class="validate-form mt-1" method="POST" action="">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.code'),
                    'field' => 'code',
                    'required' => true,
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.number', [
                    'label' => __('field.discount'),
                    'field' => 'discount',
                    'required' => true,
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.date', [
                    'label' => __('field.promotion_started_at'),
                    'field' => 'promotion_started_at',
                    'required' => true,
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.date', [
                    'label' => __('field.promotion_ended_at'),
                    'field' => 'promotion_ended_at',
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

