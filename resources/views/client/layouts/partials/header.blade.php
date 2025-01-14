<style>
    .top-header .header-right-content .log-in li::before {
        content: none !important;
    }

    .header-right-content .log-in li {
        margin-left: 15px;
        margin-right: 15px;
    }

    .navbar .header-right-content a {
        color: #333;
        font-weight: 500;
        font-size: 14px;
        transition: color 0.3s ease;
    }

    .navbar .header-right-content a:hover {
        color: #2042e3;
    }

    .navbar .header-right-content .log-in li::before {
        content: none !important;
    }

    .dropdown-item:hover {
        background-color: transparent !important;
    }

    .dropdown-item:active {
        background-color: transparent !important;
        outline: none;
    }
</style>
<header class="header-area">
    <!-- Start Navbar Area -->
    <div class="navbar-area">

        <div class="mobile-nav">
            <div class="container">
                <div class="mobile-menu">
                    <div class="logo">
                        <a href="index.html">
                            <img src="{{ asset('theme/client/assets/images/logo-client.png') }}" alt="logo">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="desktop-nav">
            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ asset('theme/client/assets/images/logo-client.png') }}" alt="logo"
                            style="height: 100px; width: 100px;">
                    </a>

                    <div class="collapse navbar-collapse mean-menu">
                        <ul class="navbar-nav m-auto">
                            <li class="nav-item">
                                <a href="{{ route('home') }}"
                                    class="nav-link {{ str_contains(Route::currentRouteName(), 'home') ? 'active' : '' }}">
                                    Trang chủ
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('job.list') }}"
                                    class="nav-link {{ str_contains(Route::currentRouteName(), 'job') == 'job' ? 'active' : '' }}">
                                    Công việc
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('workshop.list') }}"
                                    class="nav-link {{ str_contains(Route::currentRouteName(), 'workshop') == 'universities' ? 'active' : '' }}">
                                    Hội thảo
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('universities.list') }}"
                                    class="nav-link {{ str_contains(Route::currentRouteName(), 'universities') == 'universities' ? 'active' : '' }}">
                                    Trường học
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('enterprises.index') }}"
                                    class="nav-link {{ str_contains(Route::currentRouteName(), 'enterprises') == 'enterprises' ? 'active' : '' }}">
                                    Doanh nghiệp
                                </a>
                            </li>
                        </ul>
                        <!-- Đăng ký/Đăng nhập -->
                        <div class="others-option ">
                            <div class="collapse navbar-collapse mean-menu">
                                <ul class="log-in d-flex align-items-center navbar-nav m-auto gap-3">
                                    @auth
                                        <li class="nav-item dropdown">
                                            <a class="dropdown-toggle nav-link" href="#" id="userDropdown"
                                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bxs-user"></i> {{ Auth::user()->username }}
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                                @if (Auth::user()->user_type == TYPE_ENTERPRISE && Auth::user()->role_id === ROLE_ADMIN)
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('enterprise.dashboard') }}">
                                                            <i class="bx bxs-dashboard"></i> Trang quản trị doanh nghiệp
                                                        </a>
                                                    </li>
                                                @elseif (Auth::user()->user_type == TYPE_UNIVERSITY && Auth::user()->role_id === ROLE_ADMIN)
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('university.dashboard') }}">
                                                            <i class="bx bxs-dashboard"></i> Trang quản trị trường học
                                                        </a>
                                                    </li>
                                                @elseif (Auth::user()->user_type == TYPE_ADMIN && Auth::user()->role_id === ROLE_ADMIN)
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('system-admin.dashboard') }}">
                                                            <i class="bx bxs-dashboard"></i> Trang quản trị hệ thống
                                                        </a>
                                                    </li>
                                                @endif
                                                <li class="">
                                                    <form id="logout-form" class="dropdown-item p-0"
                                                        action="{{ route('logout') }}" method="POST">
                                                        @csrf
                                                        <a type="button"
                                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                            <i class="bx bx-log-out"></i> Đăng xuất
                                                        </a>
                                                    </form>
                                                </li>
                                            </ul>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ route('login') }}">
                                                <i class="bx bxs-lock"></i> Đăng nhập
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('register') }}">
                                                <i class="bx bxs-user"></i> Đăng ký
                                            </a>
                                        </li>
                                    @endauth
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- End Navbar Area -->
</header>
