@if($user)
    <div class="d-flex">
        @include('partials.backoffice.round-image', ['url' => $user->avatar?->url, 'initials' =>  $user->initials, 'size' => 'xs'])
        <div class="ml-50 mt-25">
            <a href="{{ route('admin.users.show', [$user]) }}">
                {{ $user->first_name }}
            </a>
        </div>
    </div>
@endif
