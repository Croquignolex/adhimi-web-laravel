@extends('layouts.backoffice.admin.shop-edit', ['title' => __('page.shops.add_manager')])

@section('shop.content')
    <form class="validate-form mt-1" method="POST" action="">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.first_name'),
                    'field' => 'first_name',
                    'required' => true,
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.last_name'),
                    'field' => 'last_name',
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.email'),
                    'field' => 'email',
                    'required' => true,
                ])
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.text', [
                    'label' => __('field.profession'),
                    'field' => 'profession',
                ])
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    @include('partials.input.label', [
                        'label' => __('field.gender'),
                        'required' => true,
                        'field' => 'gender',
                    ])
                    <select class="select2 form-control" id="gender" name="gender">
                        @foreach(\App\Enums\GenderEnum::values() as $gender)
                            <option value="{{ $gender }}" {{ old('gender') == $gender ? 'selected' : '' }}>
                                {{ $gender }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                @include('partials.input.date', [
                    'label' => __('field.birthdate'),
                    'field' => 'birthdate',
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

