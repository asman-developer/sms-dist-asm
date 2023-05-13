<div class="layout-width">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box horizontal-logo d-flex align-items-center">
                <a href="#" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/asmanshop-light.svg') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/asmanshop-dark.svg') }}" alt="" height="22">
                    </span>
                </a>

                <a href="#" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/asmanshop-light.svg') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/asmanshop-light.svg') }}" alt="" height="22">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                <span class="hamburger-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>
        </div>

        <div class="d-flex align-items-center">
            <div class="dropdown ms-1 topbar-head-dropdown header-item">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @php $lang = app()->getLocale() @endphp
                    <img
                        id="header-lang-img"
                        src="{{ asset("assets/images/flags/{$lang}.svg") }}"
                        alt="Header Language"
                        height="20"
                        class="rounded"
                    >
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a href="{{ route('set.locale', ['lang' => 'tm']) }}" class="dropdown-item notify-item language py-2" data-lang="en" title="English">
                        <img src="{{ asset('assets/images/flags/tm.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                        <span class="align-middle">Türkmençe</span>
                    </a>

                    <!-- item-->
                    <a href="{{ route('set.locale', ['lang' => 'ru']) }}" class="dropdown-item notify-item language" data-lang="ru" title="Russian">
                        <img src="{{ asset('assets/images/flags/ru.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                        <span class="align-middle">Русский</span>
                    </a>
                </div>
            </div>

            <div class="ms-1 header-item d-none d-sm-flex">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                    <i class='bx bx-fullscreen fs-22'></i>
                </button>
            </div>

            <div class="dropdown ms-sm-3 header-item topbar-user">
                <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="d-flex align-items-center">
                        <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/logo-circle.png') }}" alt="Header Avatar">
                        <span class="text-start ms-xl-2">
                            <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ currentStaff()->fullName }}</span>
                            <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">Admin</span>
                        </span>
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <h6 class="dropdown-header">{{ __('welcome') }}, {{ currentStaff()->fullName }}!</h6>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('auth.logout') }}" method="post">
                        @csrf
                        <button
                            class="dropdown-item"
                            type="submit"
                        >
                            <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle" data-key="t-logout">{{ __('auth_sign_out') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
