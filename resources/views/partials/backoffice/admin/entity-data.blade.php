@if($model->entity)
    <div class="d-flex">
        @if($model->entity['has_image'])
            @include('partials.backoffice.round-image', ['url' => $model->entity['image'], 'initials' => $model->entity['initials'], 'size' => 'xs'])
        @endif
        <div class="ml-50 mt-25">
            <a href="{{ $model->entity['url'] }}">
                {{ $model->entity['name'] }}
            </a>
        </div>
    </div>
@endif
