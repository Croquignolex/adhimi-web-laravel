@props(['id' => '', 'size' => '', 'class' => ''])

@include('partials.backoffice.round-image', [
    'id' => $id,
    'size' => $size,
    'class' => $class,
    'url' => $model->logo?->url,
    'initials' => $model->initials,
])