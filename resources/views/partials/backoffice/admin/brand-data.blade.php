@if($brand)
    <div class="d-flex">
        @include('partials.backoffice.round-image', ['url' => $brand->logo?->url, 'initials' =>  $brand->initials, 'size' => 'xs'])
        <div class="ml-50 mt-25">
            <a href="{{ route('admin.brands.show', [$brand]) }}">
                {{ $brand->name }}
            </a>
        </div>
    </div>
@endif
