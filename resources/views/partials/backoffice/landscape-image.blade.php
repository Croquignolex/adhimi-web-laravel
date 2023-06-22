@props(['id' => '', 'class' => '', 'url' => null])

<div id="{{ $id }}" class="{{ $class }}">
    @if($url)
        <img src="{{ $url }}" class="img-fluid" alt="{{ $id }}" />
    @else
        <div class="banner bg-light-primary">
            <span class="banner-content font-large-5">{{ $initials }}</span>
        </div>
    @endif
</div>