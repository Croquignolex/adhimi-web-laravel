@props(['required' => false])

<div class="form-group">

    @include('partials.input.label', compact('label', 'required', 'field'))

    <input type="text" id="{{ $field }}" name="{{ $field }}" class="form-control"
           value="{{ isset($value) ? (old($field) ?? $value) : old($field) }}" />

</div>