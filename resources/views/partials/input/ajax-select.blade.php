@props(['required' => false, 'value' => null])

<div class="spinner-border text-primary mt-2" id="{{ $field }}-loader"></div>

<div class="form-group" id="{{ $field }}-area" style="display: none">

    @include('partials.input.label', compact('label', 'required', 'field'))

    <select class="select2 form-control" id="{{ $field }}" name="{{ $field }}" data-url="{{ $route }}" data-old="{{ old($field, $value) }}"></select>

</div>