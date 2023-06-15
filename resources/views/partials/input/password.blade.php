@props(['required' => false])

<div class="form-group">

    @include('partials.input.label', compact('label', 'required', 'field'))

    <div class="input-group form-password-toggle input-group-merge">
        <input type="password" class="form-control" id="{{ $field }}" name="{{ $field }}" />
        <div class="input-group-append">
            <div class="input-group-text cursor-pointer">
                <i data-feather="eye"></i>
            </div>
        </div>
    </div>

</div>