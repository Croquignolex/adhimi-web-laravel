@props(['label' => __('field.save'), 'type' => 'submit', 'color' => 'primary', 'icon' => 'save'])

<div class="form-group">

    <button type="{{ $type }}" class="btn btn-{{ $color }}">
        <i data-feather="{{ $icon }}"></i>
        {{ $label }}
    </button>

</div>