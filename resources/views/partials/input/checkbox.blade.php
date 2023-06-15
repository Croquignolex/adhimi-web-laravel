@props(['required' => false, 'custom' => true, 'toggle' => false])

<div class="form-group">

    <div class="custom-control {{ $toggle ? 'custom-switch' : 'custom-checkbox' }}">

        <input type="checkbox" id="{{ $field }}" name="{{ $field }}" class="custom-control-input"
                {{ (isset($value) ? (old($field) ?? $value) : old($field)) ? 'checked' : '' }} />

        @include('partials.input.label', compact('label', 'required', 'field', 'custom'))

    </div>

</div>