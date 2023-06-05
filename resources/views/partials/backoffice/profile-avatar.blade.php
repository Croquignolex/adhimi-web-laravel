@props(['id' => '', 'size' => '', 'class' => ''])

@switch($size)
    @case('sm')
        <div id="{{ $id }}" class="{{ $class }}">
            @if(is_null($user->avatar))
                <div class="avatar bg-light-primary">
                    <span class="avatar-content font-medium-1">{{ $user->initials }}</span>
                </div>
            @else
                <img src="{{ $user->avatar->url }}" class="rounded-circle" alt="{{ $id }}" height="32" width="32" />
            @endif
        </div>
    @break

    @default
        <div id="{{ $id }}" class="{{ $class }}">
            @if(is_null($user->avatar))
                <div class="avatar bg-light-primary avatar-xxl">
                    <span class="avatar-content font-large-5">{{ $user->initials }}</span>
                </div>
            @else
                <img src="{{ $user->avatar->url }}" class="rounded-circle" alt="{{ $id }}" height="200" width="200" />
            @endif
        </div>
@endswitch
