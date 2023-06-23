@props(['user' => auth()->user()])

<span class="badge badge-light-{{ $user->roles_badge['color'] }}">
    {{ $user->roles_badge['value'] }}
</span>