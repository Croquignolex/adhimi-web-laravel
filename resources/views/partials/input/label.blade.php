@props(['required' => false])

<label for="{{ $field }}">
    {{ $label }}

    @if($required) <span class="text-danger">*</span> @endif

    @include('partials.feedbacks.validation', ['field' => $field])
</label>