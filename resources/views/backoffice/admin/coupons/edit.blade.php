@extends('layouts.backoffice.admin.coupon-edit', ['title' => __('page.coupons.edit')])

@section('coupon.content')
    <form class="validate-form mt-1" method="POST" action="{{ route('admin.coupons.update', [$coupon]) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.code'),
                    'field' => 'code',
                    'required' => true,
                    'value' => $coupon->code,
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.number', [
                    'label' => __('field.discount'),
                    'field' => 'discount',
                    'required' => true,
                    'value' => $coupon->discount,
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.date', [
                    'label' => __('field.promotion_started_at'),
                    'field' => 'promotion_started_at',
                    'required' => true,
                    'value' => $coupon->promotion_started_at,
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.date', [
                    'label' => __('field.promotion_ended_at'),
                    'field' => 'promotion_ended_at',
                    'required' => true,
                    'value' => $coupon->promotion_ended_at,
                ])
            </div>
            <div class="col-12">
                @include('partials.input.textarea', ['value' => $coupon->description])
            </div>
            <div class="col-12">
                @include('partials.input.button')
            </div>
        </div>
    </form>
@endsection
