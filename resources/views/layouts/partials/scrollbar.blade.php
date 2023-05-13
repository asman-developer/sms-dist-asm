<div id="scrollbar">
    <div class="container-fluid">

        <div id="two-column-menu"></div>
        <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title"><span data-key="t-menu">Menu</span></li>
            <li class="nav-item">
                <a
                    class="nav-link menu-link"
                    href="#sidebarDashboards"
                    data-bs-toggle="collapse"
                    role="button"
                    aria-expanded="false"
                    aria-controls="sidebarDashboards"
                >
                    <i class="ri-dashboard-2-line"></i>
                    <span data-key="t-dashboards">{{ __('dashboards') }}</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarDashboards">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.index') }}" class="nav-link" data-key="t-analytics">
                                {{ __('dashboard_analytics') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </li> <!-- end Dashboard Menu -->
            <li class="nav-item">
                <a
                    class="nav-link menu-link"
                    href="#sidebarAuth"
                    data-bs-toggle="collapse"
                    role="button"
                    aria-expanded="false"
                    aria-controls="sidebarAuth"
                >
                    <i class="ri-chat-3-line"></i>
                    <span data-key="t-authentication">
                        {{ __('messages') }}
                    </span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarAuth">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ route('sms.list') }}" class="nav-link" data-key="t-team"> {{ __('message_all') }} </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('distribution.list') }}" class="nav-link" data-key="t-team"> {{ __('distributions') }} </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a
                    class="nav-link"
                    href="{{ route('filemanager') }}"
                    aria-expanded="false"
                >
                    <i class="ri-folders-line"></i>
                    {{ __('filemanager') }}
                </a>
            </li>

            @if(currentStaff()->role == \App\Enums\RoleEnum::ADMIN->value)
            <li class="nav-item">
                <a
                    class="nav-link"
                    href="{{ route('staff.list') }}"
                    aria-expanded="false"
                >
                    <i class=" ri-group-line"></i>
                    {{ __('staffs') }}
                </a>
            </li>

                <li class="nav-item">
                    <a
                        class="nav-link menu-link"
                        href="#sidebarAuth"
                        data-bs-toggle="collapse"
                        role="button"
                        aria-expanded="false"
                        aria-controls="sidebarAuth"
                    >
                        <i class="ri-settings-2-fill"></i>
                        <span data-key="t-authentication">
                        {{ __('settings') }}
                    </span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAuth">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('settings.service.list') }}" class="nav-link" data-key="t-team"> {{ __('services') }} </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('settings.usb.list') }}" class="nav-link" data-key="t-team"> {{ __('usbs') }} </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

        </ul>
    </div>
    <!-- Sidebar -->
</div>
