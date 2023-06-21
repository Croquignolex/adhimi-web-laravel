@props(['required' => false, 'value' => null, 'label' => __('field.description'), 'field' => 'description', 'row' => 4])

<div class="form-group">

    @include('partials.input.label', compact('label', 'required', 'field'))

    <textarea rows="{{ $row }}" id="{{ $field }}" name="{{ $field }}" class="form-control">{{ old($field, $value) }}</textarea>

</div>