@switch($size)
    @case('xs')
        <div id="{{ $id }}" class="{{ $class }}">
            @if($url)
                <img src="{{ $url }}" class="rounded-circle" alt="{{ $id }}" height="20" width="20" />
            @else
                <div class="avatar bg-light-primary avatar-xs">
                    <span class="avatar-content font-small-3">{{ $initials }}</span>
                </div>
            @endif
        </div>
    @break

    @case('sm')
        <div id="{{ $id }}" class="{{ $class }}">
            @if($url)
                <img src="{{ $url }}" class="rounded-circle" alt="{{ $id }}" height="32" width="32" />
            @else
                <div class="avatar bg-light-primary">
                    <span class="avatar-content font-medium-1">{{ $initials }}</span>
                </div>
            @endif
        </div>
    @break

    @default
        <div id="{{ $id }}" class="{{ $class }}">
            @if($url)
                <img src="{{ $url }}" class="rounded-circle" alt="{{ $id }}" height="200" width="200" />
            @else
                <div class="avatar bg-light-primary avatar-xxl">
                    <span class="avatar-content font-large-5">{{ $initials }}</span>
                </div>
            @endif
        </div>
@endswitch
