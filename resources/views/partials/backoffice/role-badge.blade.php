@props(['model' => auth()->user()])

<span class="badge badge-light-{{ $model->roles_badge['color'] }}">
    {{ $model->roles_badge['value'] }}
</span>