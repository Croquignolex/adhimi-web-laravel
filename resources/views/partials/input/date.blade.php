@props(['required' => false, 'value' => null])

<div class="form-group">

    @include('partials.input.label', compact('label', 'required', 'field'))

    <input type="text" id="{{ $field }}" name="{{ $field }}" class="form-control flatpickr-basic" value="{{ old($field, $value) }}" data-locale="{{ \Illuminate\Support\Facades\App::getLocale() }}" />

</div>