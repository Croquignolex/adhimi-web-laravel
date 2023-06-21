@if($model->country)
    <div class="d-flex">
        @include('partials.backoffice.round-image', ['url' => $model->country->flag?->url, 'initials' =>  $model->country->initials, 'size' => 'xs'])
        <div class="ml-50 mt-25">
            <a href="{{ route('admin.countries.show', [$model->country]) }}">
                {{ $model->country->name }}
            </a>
        </div>
    </div>
@endif
