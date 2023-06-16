@if($model->creator)
    <div class="d-flex">
        @include('partials.backoffice.round-image', ['url' => $model->creator->avatar?->url, 'initials' =>  $model->creator->initials, 'size' => 'xs'])
        <div class="ml-50 mt-25">
            <a href="{{ route('admin.users.show', [$model->creator]) }}">
                {{ $model->creator->first_name }}
            </a>
        </div>
    </div>
@endif
