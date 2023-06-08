@props(['id' => '', 'size' => '', 'class' => ''])

@include('partials.backoffice.round-image', [
    'id' => $id,
    'size' => $size,
    'class' => $class,
    'url' => $user->avatar?->url,
    'initials' => $user->initials,
])