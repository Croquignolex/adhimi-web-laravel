<div class="col-md-3 mb-2 mb-md-0">
    <ul class="nav nav-pills flex-column nav-left">
        <!-- general -->
        <li class="nav-item">
            <a class="nav-link {{ active_page('admin.profile.general') }}" href="{{ route('admin.profile.general') }}">
                <i data-feather="user" class="font-medium-3 mr-1"></i>
                <span class="font-weight-bold">@lang('general.profile.general')</span>
            </a>
        </li>
        <!-- avatar -->
        {{--<li class="nav-item">
            <a class="nav-link {{ active_page('admin.profile.avatar') }}" href="{{ route('admin.profile.avatar') }}">
                <i data-feather="image" class="font-medium-3 mr-1"></i>
                <span class="font-weight-bold">@lang('general.profile.avatar')</span>
            </a>
        </li>--}}
        <!-- password -->
        <li class="nav-item">
            <a class="nav-link {{ active_page('admin.profile.password') }}" href="{{ route('admin.profile.password') }}">
                <i data-feather="lock" class="font-medium-3 mr-1"></i>
                <span class="font-weight-bold">@lang('general.profile.password')</span>
            </a>
        </li>
        <!-- Settings -->
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" id="account-pill-notifications" data-toggle="pill" href="#account-vertical-notifications" aria-expanded="false">--}}
{{--                <i data-feather="bell" class="font-medium-3 mr-1"></i>--}}
{{--                <span class="font-weight-bold">Notifications</span>--}}
{{--            </a>--}}
{{--        </li>--}}
        <!-- Logs -->
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" id="account-pill-notifications" data-toggle="pill" href="#account-vertical-notifications" aria-expanded="false">--}}
{{--                <i data-feather="bell" class="font-medium-3 mr-1"></i>--}}
{{--                <span class="font-weight-bold">Notifications</span>--}}
{{--            </a>--}}
{{--        </li>--}}
    </ul>
</div>