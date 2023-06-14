@props(['label' => __('field.save'), 'type' => 'submit', 'color' => 'primary'])

<div class="form-group">

    <button type="{{ $type }}" class="btn btn-{{ $color }}">

        <i data-feather="save"></i>

        {{ $label }}

    </button>

</div>