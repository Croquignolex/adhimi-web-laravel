@props(['plain' => false])

@if($model?->entity)
    @if($plain)
        {{ $model->entity['label'] }}

        <a href="{{ $model->entity['url'] }}" target="_blank">
            <i data-feather="external-link" class="ml-25 mb-25 text-secondary"></i>
        </a>
    @else
        @if($model->entity['has_image'])
            <div class="d-flex">
                @include('partials.backoffice.round-image', ['url' => $model->entity['image'], 'initials' => $model->initials, 'size' => 'xs'])
                <div class="ml-50 mt-25">
                    {{ $model->entity['label'] }}

                    <a href="{{ $model->entity['url'] }}" target="_blank">
                        <i data-feather="external-link" class="ml-25 mb-25 text-secondary"></i>
                    </a>
                </div>
            </div>
        @else
            {{ $model->entity['label'] }}

            <a href="{{ $model->entity['url'] }}" target="_blank">
                <i data-feather="external-link" class="ml-25 mb-25 text-secondary"></i>
            </a>
        @endif
    @endif
@endif