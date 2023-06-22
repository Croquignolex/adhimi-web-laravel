@if($model->organisation)
    <div class="d-flex">
        @include('partials.backoffice.round-image', ['url' => $model->organisation->logo?->url, 'initials' =>  $model->organisation->initials, 'size' => 'xs'])
        <div class="ml-50 mt-25">
            <a href="{{ route('admin.organisations.show', [$model->organisation]) }}">
                {{ $model->organisation->name }}
            </a>
        </div>
    </div>
@endif
