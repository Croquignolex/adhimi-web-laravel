@props(['id' => '', 'size' => ''])

@switch($size)
    @case('sm')
        <div id="{{ $id }}">
            @if(is_null($avatar))
                <div class="avatar bg-light-primary">
                    <span class="avatar-content font-medium-1">{{ $user->initials }}</span>
                </div>
            @else
                <img src="{{ $avatar->url }}" class="rounded-circle" alt="{{ $id }}" height="32" width="32" />
            @endif
        </div>
    @break

    @default
        <div id="{{ $id }}">
            @if(is_null($avatar))
                <div class="avatar bg-light-primary avatar-xxl">
                    <span class="avatar-content font-large-5">{{ $user->initials }}</span>
                </div>
            @else
                <img src="{{ $avatar->url }}" class="rounded-circle" alt="{{ $id }}" height="200" width="200" />
            @endif
        </div>
@endswitch
