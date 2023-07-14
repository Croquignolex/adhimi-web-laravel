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

            <li class="navigation-header">
                <span>Administration</span>
            </li>

            @if(auth()->user()->hasRole([\App\Enums\UserRoleEnum::SuperAdmin->value, \App\Enums\UserRoleEnum::Admin->value]))
                {{-- Organisations menu --}}
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="javascript:void(0);">
                        <i data-feather="globe"></i>
                        <span class="menu-title text-truncate">@lang('page.organisations.organisations')</span>
                    </a>
                    <ul class="menu-content">
                        {{-- All organisations menu item --}}
                        <li class="{{ active_page('admin.organisations.index') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.organisations.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.organisations.all')</span>
                            </a>
                        </li>
                        {{-- New organisation menu item --}}
                        <li class="{{ active_page('admin.organisations.create') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.organisations.create') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.organisations.new')</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()->hasRole([\App\Enums\UserRoleEnum::SuperAdmin->value, \App\Enums\UserRoleEnum::Admin->value, \App\Enums\UserRoleEnum::Merchant->value]))
                {{-- Shops menu --}}
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="javascript:void(0);">
                        <i data-feather="shopping-bag"></i>
                        <span class="menu-title text-truncate">@lang('page.shops.shops')</span>
                    </a>
                    <ul class="menu-content">
                        {{-- All shops menu item --}}
                        <li class="{{ active_page('admin.shops.index') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.shops.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.shops.all')</span>
                            </a>
                        </li>
                        {{-- New shop menu item --}}
                        <li class="{{ active_page('admin.shops.create') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.shops.create') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.shops.new')</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Vendors menu --}}
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="javascript:void(0);">
                        <i data-feather="truck"></i>
                        <span class="menu-title text-truncate">@lang('page.vendors.vendors')</span>
                    </a>
                    <ul class="menu-content">
                        {{-- All vendors menu item --}}
                        <li class="{{ active_page('admin.vendors.index') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.vendors.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.shops.all')</span>
                            </a>
                        </li>
                        {{-- New vendor menu item --}}
                        <li class="{{ active_page('admin.vendors.create') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.vendors.create') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.vendors.new')</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- Staff menu --}}
            <li class="nav-item">
                <a class="d-flex align-items-center" href="javascript:void(0);">
                    <i data-feather="grid"></i>
                    <span class="menu-title text-truncate">@lang('page.staffs.staffs')</span>
                </a>
                <ul class="menu-content">
                    {{-- All staffs menu item --}}
                    <li class="{{ active_page('admin.users.index') }}">
                        <a class="d-flex align-items-center" href="{{ route('admin.users.index') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item">@lang('page.staffs.all')</span>
                        </a>
                    </li>
                    {{-- New staff menu item --}}
                    <li class="{{ active_page('admin.users.create.admin') }}">
                        <a class="d-flex align-items-center" href="{{ route('admin.users.create.admin') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item">@lang('page.staffs.new_admin')</span>
                        </a>
                    </li>
                    <li class="{{ active_page('admin.users.create.merchant') }}">
                        <a class="d-flex align-items-center" href="{{ route('admin.users.create.merchant') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item">@lang('page.staffs.new_merchant')</span>
                        </a>
                    </li>
                    <li class="{{ active_page('admin.users.create.manager') }}">
                        <a class="d-flex align-items-center" href="{{ route('admin.users.create.manager') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item">@lang('page.staffs.new_manager')</span>
                        </a>
                    </li>
                    <li class="{{ active_page('admin.users.create.seller') }}">
                        <a class="d-flex align-items-center" href="{{ route('admin.users.create.seller') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item">@lang('page.staffs.new_seller')</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Customer menu --}}
            <li class="{{ active_page('admin.customers.index') }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('admin.customers.index') }}">
                    <i data-feather="users"></i>
                    <span class="menu-title text-truncate">@lang('page.customers.all')</span>
                </a>
            </li>

            @if(auth()->user()->hasRole([\App\Enums\UserRoleEnum::SuperAdmin->value, \App\Enums\UserRoleEnum::Admin->value, \App\Enums\UserRoleEnum::Merchant->value, \App\Enums\UserRoleEnum::ShopManager->value]))
                <li class="navigation-header">
                    <span>Catalog</span>
                </li>

                {{-- Brands menu --}}
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="javascript:void(0);">
                        <i data-feather="sun"></i>
                        <span class="menu-title text-truncate">@lang('page.brands.brands')</span>
                    </a>
                    <ul class="menu-content">
                        {{-- All brands menu item --}}
                        <li class="{{ active_page('admin.brands.index') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.brands.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.brands.all')</span>
                            </a>
                        </li>
                        {{-- New brand menu item --}}
                        <li class="{{ active_page('admin.brands.create') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.brands.create') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.brands.new')</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Groups menu --}}
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="javascript:void(0);">
                        <i data-feather="box"></i>
                        <span class="menu-title text-truncate">@lang('page.groups.groups')</span>
                    </a>
                    <ul class="menu-content">
                        {{-- All groups menu item --}}
                        <li class="{{ active_page('admin.groups.index') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.groups.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.groups.all')</span>
                            </a>
                        </li>
                        {{-- New group menu item --}}
                        <li class="{{ active_page('admin.groups.create') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.groups.create') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.groups.new')</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Categories menu --}}
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="javascript:void(0);">
                        <i data-feather="codesandbox"></i>
                        <span class="menu-title text-truncate">@lang('page.categories.categories')</span>
                    </a>
                    <ul class="menu-content">
                        {{-- All categories menu item --}}
                        <li class="{{ active_page('admin.categories.index') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.categories.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.groups.all')</span>
                            </a>
                        </li>
                        {{-- New category menu item --}}
                        <li class="{{ active_page('admin.categories.create') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.categories.create') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.categories.new')</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()->hasRole([\App\Enums\UserRoleEnum::SuperAdmin->value, \App\Enums\UserRoleEnum::Admin->value]))
                <li class="navigation-header">
                    <span>Utilitaires</span>
                </li>

                {{-- Coupons menu --}}
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="javascript:void(0);">
                        <i data-feather="percent"></i>
                        <span class="menu-title text-truncate">@lang('page.coupons.coupons')</span>
                    </a>
                    <ul class="menu-content">
                        {{-- All coupons menu item --}}
                        <li class="{{ active_page('admin.coupons.index') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.coupons.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.coupons.all')</span>
                            </a>
                        </li>
                        {{-- New coupon menu item --}}
                        <li class="{{ active_page('admin.coupons.create') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.coupons.create') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.coupons.new')</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Ratings menu --}}
                <li class="{{ active_page('admin.ratings.index') }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('admin.ratings.index') }}">
                        <i data-feather="star"></i>
                        <span class="menu-title text-truncate">@lang('page.ratings.all')</span>
                    </a>
                </li>
            @endif

            @if(auth()->user()->hasRole([\App\Enums\UserRoleEnum::SuperAdmin->value, \App\Enums\UserRoleEnum::Admin->value, \App\Enums\UserRoleEnum::Merchant->value]))
                <li class="navigation-header">
                    <span>Paramètres général</span>
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

                {{-- States menu --}}
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="javascript:void(0);">
                        <i data-feather="map"></i>
                        <span class="menu-title text-truncate">@lang('page.states.states')</span>
                    </a>
                    <ul class="menu-content">
                        {{-- All states menu item --}}
                        <li class="{{ active_page('admin.states.index') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.states.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.states.all')</span>
                            </a>
                        </li>
                        {{-- New state menu item --}}
                        <li class="{{ active_page('admin.states.create') }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.states.create') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">@lang('page.states.new')</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            <li class="navigation-header">
                <span>Paramètres du site</span>
            </li>
        </ul>
    </div>
</div>