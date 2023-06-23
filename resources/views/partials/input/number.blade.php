@props(['required' => false, 'value' => null])

<div class="form-group">

    @include('partials.input.label', compact('label', 'required', 'field'))

    <input type="number" id="{{ $field }}" name="{{ $field }}" class="form-control" value="{{ old($field, $value) }}" />

</div>