@inject('languageService', 'App\Services\LanguageService')
@php
    $currentLanguage = $languageService->currentLanguage();
@endphp

<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item">
                    <a class="nav-link menu-toggle" href="javascript:void(0);">
                        <i class="ficon" data-feather="menu"></i>
                    </a>
                </li>
            </ul>
            @include('partials.backoffice.breadcrumb', compact('title', 'breadcrumb_items'))
        </div>
        <ul class="nav navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown dropdown-language">
                <a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="flag-icon flag-icon-{{ $currentLanguage['icon'] }}"></i>
                    <span class="selected-language">
                        {{ $currentLanguage['label'] }}
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag">
                    @foreach($languageService->availableLanguages() as $languageItem)
                        <a class="dropdown-item" href="{{ $languageItem['url'] }}">
                            <i class="flag-icon flag-icon-{{ $languageItem['icon'] }}"></i>
                            {{ $languageItem['label'] }}
                        </a>
                    @endforeach
                </div>
            </li>
            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name font-weight-bolder">{{ auth()->user()->first_name }}</span>
                        <div class="font-small-2">
                            @each('partials.backoffice.badge', auth()->user()->roles_badge, 'data')
                        </div>
                    </div>
                    <div class="avatar bg-light-primary">
                        <span class="avatar-content font-medium-1">{{ auth()->user()->initials }}</span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
{{--                    <a class="dropdown-item" href="{{ route('profile') }}">--}}
{{--                        <i class="mr-50" data-feather="user"></i> Profile--}}
{{--                    </a>--}}
{{--                    <a class="dropdown-item" href="{{ route('settings') }}">--}}
{{--                        <i class="mr-50" data-feather="settings"></i> Settings--}}
{{--                    </a>--}}
{{--                    <a class="dropdown-item" href="{{ route('logs') }}">--}}
{{--                        <i class="mr-50" data-feather="file-text"></i> My logs--}}
{{--                    </a>--}}
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="javascript:void(0);"
                       onclick="document.getElementById('logout-form').submit();"
                    >
                        <form method="POST" action="{{ route('customer.logout') }}" id="logout-form">
                            @csrf
                        </form>
                        <i class="mr-50" data-feather="power"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>