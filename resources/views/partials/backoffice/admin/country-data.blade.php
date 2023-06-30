@if($country)
    <div class="d-flex">
        @include('partials.backoffice.round-image', ['url' => $country->flag?->url, 'initials' =>  $country->initials, 'size' => 'xs'])
        <div class="ml-50 mt-25">
            <a href="{{ route('admin.countries.show', [$country]) }}">
                {{ $country->name }}
            </a>
        </div>
    </div>
@endif
