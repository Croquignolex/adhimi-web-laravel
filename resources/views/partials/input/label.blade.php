@props(['required' => false, 'custom' => false])

<label for="{{ $field }}" class="{{ $custom ? 'custom-control-label' : '' }}">

    {{ $label }}

    @if($required) <span class="text-danger">*</span> @endif

    @include('partials.feedbacks.validation', ['field' => $field])

</label>