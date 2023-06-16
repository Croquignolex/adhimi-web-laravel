@props(['required' => false])

<div class="form-group">

    @include('partials.input.label', compact('label', 'required', 'field'))

    <input type="text" id="{{ $field }}" name="{{ $field }}" class="form-control flatpickr-basic" value="{{ old($field, $value ?? null) }}" />

</div>