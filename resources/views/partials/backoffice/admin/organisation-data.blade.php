@if($organisation)
    <div class="d-flex">
        @include('partials.backoffice.round-image', ['url' => $organisation->logo?->url, 'initials' =>  $organisation->initials, 'size' => 'xs'])
        <div class="ml-50 mt-25">
            <a href="{{ route('admin.organisations.show', [$organisation]) }}">
                {{ $organisation->name }}
            </a>
        </div>
    </div>
@endif
