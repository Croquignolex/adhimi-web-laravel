@props(['model' => auth()->user()])

<span class="badge badge-light-{{ $model->status_badge['color'] }}">
    {{ $model->status_badge['value'] }}
</span>
