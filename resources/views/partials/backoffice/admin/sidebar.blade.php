<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{ route('admin.home') }}">
                    <img src="{{ asset('assets/images/icons/apple-touch-icon.png') }}" alt="adhimi-logo" class="img-fluid"  width="35">
                    <h2 class="brand-text">{{ config('app.name') }}</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            {{-- Home menu --}}
            <li class="{{ active_page('admin.home') }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('admin.home') }}">
                    <i data-feather="home"></i>
                    <span class="menu-title text-truncate">@lang('page.home')</span>
                </a>
            </li>

            @if(auth()->user()->hasRole([\App\Enums\UserRoleEnum::SuperAdmin->value, \App\Enums\UserRoleEnum::Admin->value]))
                {{-- Organisations menu --}}
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="javascript:void(0);">
                        <i data-feather="globe"></i>
                        <span class="menu-title text-truncate">@lang('page.shops.shops')</span>
                    </a>
                    <ul class="menu-content">
                        {{-- All organisations menu item --}}
                        <li class="{{ active_page('admin.organisations.index') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.organisations.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.shops.all')</span>
                            </a>
                        </li>
                        {{-- New organisation menu item --}}
                        <li class="{{ active_page('admin.organisations.create') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.organisations.create') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.shops.new')</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="navigation-header">
                    <span>@lang('general.settings')</span>
                </li>

                {{-- Countries menu --}}
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="javascript:void(0);">
                        <i data-feather="flag"></i>
                        <span class="menu-title text-truncate">@lang('page.countries.countries')</span>
                    </a>
                    <ul class="menu-content">
                        {{-- All countries menu item --}}
                        <li class="{{ active_page('admin.countries.index') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.countries.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.countries.all')</span>
                            </a>
                        </li>
                        {{-- New country menu item --}}
                        <li class="{{ active_page('admin.countries.create') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.countries.create') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.countries.new')</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()->hasRole([\App\Enums\UserRoleEnum::Admin->value]))

            @endif

            @if(auth()->user()->hasRole([\App\Enums\UserRoleEnum::Merchant->value]))

            @endif

            @if(auth()->user()->hasRole([\App\Enums\UserRoleEnum::ShopManager->value]))

            @endif

            @if(auth()->user()->hasRole([\App\Enums\UserRoleEnum::Saler->value]))

            @endif
        </ul>
    </div>
</div>