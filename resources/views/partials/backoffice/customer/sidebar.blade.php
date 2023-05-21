<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <h2 class="brand-text">{{ config(('app.name')) }}</h2>
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
            <li class="{{ active_page('home') }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('home') }}">
                    <i data-feather="home"></i>
                    <span class="menu-title text-truncate">Home</span>
                </a>
            </li>
            {{-- Dashboard menu --}}
            <li class="{{ active_page('dashboard') }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('dashboard') }}">
                    <i data-feather="pie-chart"></i>
                    <span class="menu-title text-truncate">Dashboard</span>
                </a>
            </li>
            {{-- Assistant menu --}}
            <li class="nav-item">
                <a class="d-flex align-items-center" href="javascript:void(0);">
                    <i data-feather="cpu"></i>
                    <span class="menu-title text-truncate">Assistant</span>
                </a>
                <ul class="menu-content">
                    {{-- Assistant questions menu item --}}
                    <li class="{{ active_page('questions') }}">
                        <a class="d-flex align-items-center" href="{{ route('questions') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item">Q&A</span>
                        </a>
                    </li>
                    @if(auth()->user()->is_premium || auth()->user()->is_ultimate)
                        {{-- Assistant image creations menu item --}}
                        <li class="{{ active_page('image-creations') }}">
                            <a class="d-flex align-items-center" href="{{ route('image-creations') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">Image creations</span>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->is_ultimate)
                        {{-- Assistant chats menu item --}}
                        <li class="{{ active_page('chats') }}">
                            <a class="d-flex align-items-center" href="{{ route('chats') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">Chats</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            @if(auth()->user()->is_admin)
                <li class="navigation-header">
                    <span>Admin</span>
                </li>
                {{-- Global dashboard menu --}}
                <li class="{{ active_page('dashboard.global') }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('dashboard.global') }}">
                        <i data-feather="globe"></i>
                        <span class="menu-title text-truncate">Global dashboard</span>
                    </a>
                </li>
                {{-- Users menu --}}
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="javascript:void(0);">
                        <i data-feather="users"></i>
                        <span class="menu-title text-truncate">Users</span>
                    </a>
                    <ul class="menu-content">
                        {{-- All users menu item --}}
                        <li class="{{ active_page('users.index') }}">
                            <a class="d-flex align-items-center" href="{{ route('users.index') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">All users</span>
                            </a>
                        </li>
                        {{-- New user menu item --}}
                        <li class="{{ active_page('users.create') }}">
                            <a class="d-flex align-items-center" href="{{ route('users.create') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">New user</span>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Assistant settings menu --}}
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="javascript:void(0);">
                        <i data-feather="settings"></i>
                        <span class="menu-title text-truncate">Assistant Settings</span>
                    </a>
                    <ul class="menu-content">
                        {{-- Assistant question settings menu item --}}
                        <li class="{{ active_page('settings.question') }}">
                            <a class="d-flex align-items-center" href="{{ route('settings.question') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">Q&A</span>
                            </a>
                        </li>
                        {{-- Assistant chat settings menu item --}}
                        <li class="{{ active_page('settings.chat') }}">
                            <a class="d-flex align-items-center" href="{{ route('settings.chat') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">Chat</span>
                            </a>
                        </li>
                        {{-- Assistant image creation settings menu item --}}
                        <li class="{{ active_page('settings.image-creation') }}">
                            <a class="d-flex align-items-center" href="{{ route('settings.image-creation') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">Image creation</span>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Global activities menu --}}
                <li class="nav-item">
                    <a class="d-flex align-items-center" href="javascript:void(0);">
                        <i data-feather="file-text"></i>
                        <span class="menu-title text-truncate">Global activities</span>
                    </a>
                    <ul class="menu-content">
                        {{-- Global activities history menu item --}}
                        <li class="{{ active_page('history.global') }}">
                            <a class="d-flex align-items-center" href="{{ route('history.global') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">History</span>
                            </a>
                        </li>
                        {{-- Global activities logs menu item --}}
                        <li class="{{ active_page('logs.global') }}">
                            <a class="d-flex align-items-center" href="{{ route('logs.global') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">Logs</span>
                            </a>
                        </li>
                        {{-- Global activities subscriptions menu item --}}
                        <li class="{{ active_page('subscriptions.global') }}">
                            <a class="d-flex align-items-center" href="{{ route('subscriptions.global') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">Subscriptions</span>
                            </a>
                        </li>
                        {{-- Global activities invoices menu item --}}
                        <li class="{{ active_page('invoices.global') }}">
                            <a class="d-flex align-items-center" href="{{ route('invoices.global') }}">
                                <i data-feather="circle"></i>
                                <span class="menu-item">Invoices</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            <li class="navigation-header">
                <span>Other</span>
            </li>
            {{-- other subscriptions menu --}}
            <li class="{{ active_page('subscription') }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('subscription') }}">
                    <i data-feather="award"></i>
                    <span class="menu-title text-truncate">Subscription</span>
                </a>
            </li>
            {{-- other subscriptions menu --}}
            <li class="{{ active_page('sponsorship') }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('sponsorship') }}">
                    <i data-feather="link"></i>
                    <span class="menu-title text-truncate">Sponsorship</span>
                </a>
            </li>
            {{-- other invoices menu --}}
            <li class="{{ active_page('invoices.index') }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('invoices.index') }}">
                    <i data-feather="file"></i>
                    <span class="menu-title text-truncate">Invoices</span>
                </a>
            </li>
        </ul>
    </div>
</div>